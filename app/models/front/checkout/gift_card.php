<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|   
|   (c) Vince Kronlein <vince@dais.io>
|   
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
*/

namespace App\Models\Front\Checkout;
use App\Models\Model;
use Dais\Library\Template;
use Dais\Library\Text;

class GiftCard extends Model {
    public function addGiftcard($order_id, $data) {
        $this->db->query("
            INSERT INTO {$this->db->prefix}gift_card 
            SET 
                order_id          = '" . (int)$order_id . "', 
                code              = '" . $this->db->escape($data['code']) . "', 
                from_name         = '" . $this->db->escape($data['from_name']) . "', 
                from_email        = '" . $this->db->escape($data['from_email']) . "', 
                to_name           = '" . $this->db->escape($data['to_name']) . "', 
                to_email          = '" . $this->db->escape($data['to_email']) . "', 
                gift_card_theme_id = '" . (int)$data['gift_card_theme_id'] . "', 
                message           = '" . $this->db->escape($data['message']) . "', 
                amount            = '" . (float)$data['amount'] . "', 
                status            = '1', 
                date_added        = NOW()");
        
        return $this->db->getLastId();
    }
    
    public function getGiftcard($code) {
        $status = true;
        
        $gift_card_query = $this->db->query("
            SELECT 
                *, 
                vtd.name AS theme 
            FROM {$this->db->prefix}gift_card v 
            LEFT JOIN {$this->db->prefix}gift_card_theme vt 
                ON (v.gift_card_theme_id = vt.gift_card_theme_id) 
            LEFT JOIN {$this->db->prefix}gift_card_theme_description vtd 
                ON (vt.gift_card_theme_id = vtd.gift_card_theme_id) 
            WHERE v.code = '" . $this->db->escape($code) . "' 
            AND vtd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            AND v.status = '1'");
        
        if ($gift_card_query->num_rows) {
            if ($gift_card_query->row['order_id']) {
                $order_query = $this->db->query("
                    SELECT * 
                    FROM `{$this->db->prefix}order` 
                    WHERE order_id = '" . (int)$gift_card_query->row['order_id'] . "' 
                    AND order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "'");
                
                if (!$order_query->num_rows) {
                    $status = false;
                }
                
                $order_gift_card_query = $this->db->query("
                    SELECT * 
                    FROM `{$this->db->prefix}order_gift_card` 
                    WHERE order_id = '" . (int)$gift_card_query->row['order_id'] . "' 
                    AND gift_card_id = '" . (int)$gift_card_query->row['gift_card_id'] . "'");
                
                if (!$order_gift_card_query->num_rows) {
                    $status = false;
                }
            }
            
            $gift_card_history_query = $this->db->query("
                SELECT SUM(amount) AS total 
                FROM `{$this->db->prefix}gift_card_history` vh 
                WHERE vh.gift_card_id = '" . (int)$gift_card_query->row['gift_card_id'] . "' 
                GROUP BY vh.gift_card_id");
            
            if ($gift_card_history_query->num_rows) {
                $amount = $gift_card_query->row['amount'] + $gift_card_history_query->row['total'];
            } else {
                $amount = $gift_card_query->row['amount'];
            }
            
            if ($amount <= 0) {
                $status = false;
            }
        } else {
            $status = false;
        }
        
        if ($status) {
            return array(
                'gift_card_id'       => $gift_card_query->row['gift_card_id'],
                'code'              => $gift_card_query->row['code'],
                'from_name'         => $gift_card_query->row['from_name'],
                'from_email'        => $gift_card_query->row['from_email'],
                'to_name'           => $gift_card_query->row['to_name'],
                'to_email'          => $gift_card_query->row['to_email'],
                'gift_card_theme_id' => $gift_card_query->row['gift_card_theme_id'],
                'theme'             => $gift_card_query->row['theme'],
                'message'           => $gift_card_query->row['message'],
                'image'             => $gift_card_query->row['image'],
                'amount'            => $amount,
                'status'            => $gift_card_query->row['status'],
                'date_added'        => $gift_card_query->row['date_added']
            );
        }
    }
    
    public function confirm($order_id) {
        $this->theme->model('checkout/order');
        
        $order_info = $this->model_checkout_order->getOrder($order_id);
        
        if ($order_info):
            $gift_card_query = $this->db->query("
                SELECT 
                    *, 
                    gtd.name AS theme 
                FROM {$this->db->prefix}gift_card g 
                LEFT JOIN {$this->db->prefix}gift_card_theme gt 
                ON (g.gift_card_theme_id = gt.gift_card_theme_id) 
                LEFT JOIN {$this->db->prefix}gift_card_theme_description gtd 
                ON (gt.gift_card_theme_id = gtd.gift_card_theme_id) 
                AND gtd.language_id = '" . (int)$order_info['language_id'] . "' 
                WHERE g.order_id = '" . (int)$order_id . "'");
            
            foreach ($gift_card_query->rows as $gift_card):
                $split    = explode(' ', $gift_card['to_name']);
                $callback = array(
                    'firstname' => $split[0],
                    'lastname'  => isset($split[1]) ? $split[1] : '',
                    'email'     => $gift_card['to_email']
                );

                $this->notify->setGenericCustomer($callback);
                
                $message  = $this->notify->fetch('public_gift_card_confirm');
                $priority = $message['priority'];
                
                // decorate the base email
                $message = $this->buildMessage($gift_card, $message);

                $this->notify->fetchWrapper($priority);

                $message = $this->notify->formatEmail($message, 1);
                
                if ($priority == 1):
                    $this->notify->send($message);
                else:
                    $this->notify->addToEmailQueue($message);
                endif;
                
            endforeach;
        endif;
    }
    
    public function redeem($gift_card_id, $order_id, $amount) {
        $this->db->query("
            INSERT INTO `{$this->db->prefix}gift_card_history` 
            SET 
                gift_card_id = '" . (int)$gift_card_id . "', 
                order_id    = '" . (int)$order_id . "', 
                amount      = '" . (float)$amount . "', 
                date_added  = NOW()");
    }

    public function buildMessage($data, $message) {
        $call = $data;
        unset($data);
        
        $data = $this->theme->language('notification/gift_card');

        $data['theme_image'] = Config::get('http.public') . 'image/' . $call['image'];
        $data['theme_name']  = $call['theme'];
        $data['store_name']  = $this->config->get('config_name');
        $data['to_name']     = $call['to_name'];
        $data['code']        = $call['code'];

        $data['text_message'] = false;
        $data['html_message'] = false;

        if (isset($call['message'])):
            $data['text_message'] = $call['message'];
            $data['html_message'] = nl2br($call['message']);
        endif;

        $data['lang_text_message'] = sprintf($this->language->get('lang_text_message'), $call['from_name']);

        $search = array(
            '!amount!',
            '!sender!',
            '!sender_email!',
            '!code!'
        );

        $replace = array(
            $this->currency->format($call['amount']),
            $call['from_name'],
            $call['from_email'],
            $call['code']
        );

        foreach($message as $key => $value):
            $message[$key] = str_replace($search, $replace, $value);
        endforeach;

        $html = new Template;
        $text = new Text;

        $html->data = $data;
        $text->data = $data;

        $html = $html->fetch('notification/gift_card');
        $text = $text->fetch('notification/gift_card');

        $message['text'] = str_replace('!content!', $text, $message['text']);
        $message['html'] = str_replace('!content!', $html, $message['html']);
        
        return $message;
    } 
}
