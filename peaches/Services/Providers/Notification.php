<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|	
|	(c) Vince Kronlein <vince@dais.io>
|	
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|	
*/

namespace Dais\Services\Providers;

class Notification {
    
    private $html;
    private $text;
    private $customer;
    private $order_id = 0;
    private $user;
    private $to_name;
    private $to_email;
    private $preference = array();
    
    /**
     * fetch the wrapper from the email object.
     * @return array $data for calling from outside the class.
     */
    public function fetchWrapper($priority) {
        $data = \Email::fetchWrapper($priority);
        
        $this->text = html_entity_decode($data['text'], ENT_QUOTES, 'UTF-8');
        $this->html = html_entity_decode($data['html'], ENT_QUOTES, 'UTF-8');

        return $data;
    }

    /**
     * fetch the data for the called notification
     * @param  string $name slug string of notification
     * @return array  subject, text, html, priority
     */
    public function fetch($name) {
        return \Email::fetch($name);
    }

    public function getNotificationType($name) {
        $query = \DB::query("
            SELECT email_id, recipient 
            FROM " . \DB::p()->prefix . "email 
            WHERE email_slug = '" . \DB::escape($name) . "'");

        return $query->row;
    }

    public function setCustomer($email_id, $customer_id, $order = false) {
        $customer = array();

        if ($this->order_id && $order):
            // this handles guests
            $customer = $this->setCustomerByOrder($order);

            $this->preference = array(
                'email'    => 1,
                'internal' => 0
            );
        else:
            $query = \DB::query("
                SELECT DISTINCT * 
                FROM " . \DB::p()->prefix . "customer 
                WHERE customer_id = '" . (int)$customer_id . "'");

            foreach ($query->row as $key => $value):
                $customer[$key] = $value;
            endforeach;

            $query = \DB::query("
                SELECT SUM(points) AS total 
                FROM " . \DB::p()->prefix . "customer_reward 
                WHERE customer_id = '" . (int)$customer_id . "'
            ");

            $points = $query->row['total'] ? $query->row['total'] : 0;

            $customer['points'] = $points;

            // set the preference for this specific email
            $this->setCustomerPreference($email_id, $customer_id);
        endif;

        $this->customer = $customer;

        // Let's set our to_name and to_email for the send method
        $this->to_name  = (isset($this->customer['firstname'])) ? $this->customer['firstname'] . ' ' . $this->customer['lastname'] : $this->customer['username'];
        $this->to_email = $this->customer['email'];
    }

    public function setCustomerByOrder($order) {
        $customer = array(
            'firstname' => $order['firstname'],
            'lastname'  => $order['lastname'],
            'username'  => '',
            'email'     => $order['email'],
            'telephone' => $order['telephone'],
            'ip'        => isset($order['ip']) ? $order['ip'] : 0,
            'points'    => 0
        );

        return $customer;
    }

    public function setGenericCustomer($data) {
        $this->customer = array(
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'username'  => '',
            'email'     => $data['email'],
            'telephone' => '',
            'ip'        => isset($data['ip']) ? $data['ip'] : 0,
            'points'    => 0
        );

        $this->preference = array(
            'email'    => 1,
            'internal' => 0
        );

        $this->to_name  = (isset($this->customer['lastname'])) ? $this->customer['firstname'] . ' ' . $this->customer['lastname'] : $this->customer['firstname'];
        $this->to_email = $this->customer['email'];
    }

    public function setOrderId($order_id) {
        $this->order_id = $order_id;
    }

    public function setUser($user_id) {
        $query = \DB::query("
            SELECT DISTINCT * 
            FROM " . \DB::p()->prefix . "user 
            WHERE user_id = '" . (int)$user_id . "'");

        $this->user = $query->row;

        // Let's set our to_name and to_email for the send method
        $this->to_name  = (isset($this->user['firstname'])) ? $this->user['firstname'] . ' ' . $this->user['lastname'] : $this->user['user_name'];
        $this->to_email = $this->user['email'];

        // there's no need to check preference here as admins
        // always receive email only
        
        $this->preference = array(
            'email'    => 1,
            'internal' => 0
        );
    }

    private function setCustomerPreference($email_id, $customer_id) {
        $query = \DB::query("
            SELECT settings 
            FROM " . \DB::p()->prefix . "customer_notification 
            WHERE customer_id = '" . (int)$customer_id . "'");

        $data = unserialize($query->row['settings']);

        // If the email_id exists in the array then we will use
        // the preferences provided, otherwise this notification
        // isn't configurable and we should send them email only.
        // This would be the case for a forgotten password etc.
        if (array_key_exists($email_id, $data)):
            $preference = $data[$email_id];
        else:
            $preference = array(
                'email'    => 1,
                'internal' => 0
            );
        endif;

        $this->preference = $preference;
    }

    public function getPreference() {
        return $this->preference;
    }

    public function customerInternal($message) {
        $message['html'] .= '!signature!';
        $message = \Decorator::decorateCustomerNotification($message, $this->customer, $this->order_id);

        /**
         * Let's go ahead and insert the message.
         */

        $customer_id = $this->customer['customer_id'];
        $subject     = $message['subject'];
        $content     = $message['html'];
        
        \DB::query("
            INSERT INTO " . \DB::p()->prefix . "customer_inbox 
            SET 
                customer_id = '" . (int)$customer_id . "', 
                subject = '" . \DB::escape($subject) . "', 
                message = '" . \DB::escape($content) . "'
        ");

        return $message;
    }

    public function formatEmail($email, $type) {
        $message = array();
        // subject
        $message['subject'] = $email['subject'];
        // text
        $message['text']    = str_replace('!content!', $email['text'], $this->text);
        
        // html
        $this->html         = str_replace('!subject!', $email['subject'], $this->html);
        $message['html']    = str_replace('!content!', $email['html'], $this->html);
        

        switch($type):
            case 1:
                $message = \Decorator::decorateCustomerNotification($message, $this->customer, $this->order_id);
                break;
            case 2:
                $message = \Decorator::decorateUserNotification($message, $this->user);
                break;
        endswitch;
        
        return $message;
    }

    public function addToEmailQueue($message) {
        // first add all parts of the email to queue and get the insert id
        $id = \Email::addToEmailQueue($message, $this->to_email, $this->to_name);

        // now pass the insert id and message to decorator to decorate 
        // the webversion and unsubscribe urls
        $message = \Decorator::decorateUrls($id, $message);

        // now update the queue with the html
        \Email::updateHtml($id, $message);

        return true;
    }

    public function send($message, $add = array()) {
        return \Email::send($message, $this->to_email, $this->to_name, true, $add);
    }
}
