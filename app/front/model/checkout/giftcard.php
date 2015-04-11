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

namespace Front\Model\Checkout;
use Dais\Engine\Model;
use Dais\Library\Language;
use Dais\Library\Template;
use Dais\Library\Text;

class Giftcard extends Model {
    public function addGiftcard($order_id, $data) {
        $this->db->query("
            INSERT INTO {$this->db->prefix}giftcard 
            SET 
                order_id          = '" . (int)$order_id . "', 
                code              = '" . $this->db->escape($data['code']) . "', 
                from_name         = '" . $this->db->escape($data['from_name']) . "', 
                from_email        = '" . $this->db->escape($data['from_email']) . "', 
                to_name           = '" . $this->db->escape($data['to_name']) . "', 
                to_email          = '" . $this->db->escape($data['to_email']) . "', 
                giftcard_theme_id = '" . (int)$data['giftcard_theme_id'] . "', 
                message           = '" . $this->db->escape($data['message']) . "', 
                amount            = '" . (float)$data['amount'] . "', 
                status            = '1', 
                date_added        = NOW()");
        
        return $this->db->getLastId();
    }
    
    public function getGiftcard($code) {
        $status = true;
        
        $giftcard_query = $this->db->query("
            SELECT 
                *, 
                vtd.name AS theme 
            FROM {$this->db->prefix}giftcard v 
            LEFT JOIN {$this->db->prefix}giftcard_theme vt 
                ON (v.giftcard_theme_id = vt.giftcard_theme_id) 
            LEFT JOIN {$this->db->prefix}giftcard_theme_description vtd 
                ON (vt.giftcard_theme_id = vtd.giftcard_theme_id) 
            WHERE v.code = '" . $this->db->escape($code) . "' 
            AND vtd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            AND v.status = '1'");
        
        if ($giftcard_query->num_rows) {
            if ($giftcard_query->row['order_id']) {
                $order_query = $this->db->query("
                    SELECT * 
                    FROM `{$this->db->prefix}order` 
                    WHERE order_id = '" . (int)$giftcard_query->row['order_id'] . "' 
                    AND order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "'");
                
                if (!$order_query->num_rows) {
                    $status = false;
                }
                
                $order_giftcard_query = $this->db->query("
                    SELECT * 
                    FROM `{$this->db->prefix}order_giftcard` 
                    WHERE order_id = '" . (int)$giftcard_query->row['order_id'] . "' 
                    AND giftcard_id = '" . (int)$giftcard_query->row['giftcard_id'] . "'");
                
                if (!$order_giftcard_query->num_rows) {
                    $status = false;
                }
            }
            
            $giftcard_history_query = $this->db->query("
                SELECT SUM(amount) AS total 
                FROM `{$this->db->prefix}giftcard_history` vh 
                WHERE vh.giftcard_id = '" . (int)$giftcard_query->row['giftcard_id'] . "' 
                GROUP BY vh.giftcard_id");
            
            if ($giftcard_history_query->num_rows) {
                $amount = $giftcard_query->row['amount'] + $giftcard_history_query->row['total'];
            } else {
                $amount = $giftcard_query->row['amount'];
            }
            
            if ($amount <= 0) {
                $status = false;
            }
        } else {
            $status = false;
        }
        
        if ($status) {
            return array(
                'giftcard_id'       => $giftcard_query->row['giftcard_id'],
                'code'              => $giftcard_query->row['code'],
                'from_name'         => $giftcard_query->row['from_name'],
                'from_email'        => $giftcard_query->row['from_email'],
                'to_name'           => $giftcard_query->row['to_name'],
                'to_email'          => $giftcard_query->row['to_email'],
                'giftcard_theme_id' => $giftcard_query->row['giftcard_theme_id'],
                'theme'             => $giftcard_query->row['theme'],
                'message'           => $giftcard_query->row['message'],
                'image'             => $giftcard_query->row['image'],
                'amount'            => $amount,
                'status'            => $giftcard_query->row['status'],
                'date_added'        => $giftcard_query->row['date_added']
            );
        }
    }
    
    public function confirm($order_id) {
        $this->theme->model('checkout/order');
        
        $order_info = $this->model_checkout_order->getOrder($order_id);
        
        if ($order_info):
            $giftcard_query = $this->db->query("
                SELECT 
                    *, 
                    gtd.name AS theme 
                FROM {$this->db->prefix}giftcard g 
                LEFT JOIN {$this->db->prefix}giftcard_theme gt 
                ON (g.giftcard_theme_id = gt.giftcard_theme_id) 
                LEFT JOIN {$this->db->prefix}giftcard_theme_description gtd 
                ON (gt.giftcard_theme_id = gtd.giftcard_theme_id) 
                AND gtd.language_id = '" . (int)$order_info['language_id'] . "' 
                WHERE g.order_id = '" . (int)$order_id . "'");
            
            foreach ($giftcard_query->rows as $giftcard):
                $split    = explode(' ', $giftcard['to_name']);
                $callback = array(
                    'firstname' => $split[0],
                    'lastname'  => isset($split[1]) ? $split[1] : '',
                    'email'     => $giftcard['to_email']
                );

                $this->notify->setGenericCustomer($callback);
                
                $message  = $this->notify->fetch('public_giftcard_confirm');
                $priority = $message['priority'];
                
                // decorate the base email
                $message = $this->buildMessage($giftcard, $message);

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
    
    public function redeem($giftcard_id, $order_id, $amount) {
        $this->db->query("
            INSERT INTO `{$this->db->prefix}giftcard_history` 
            SET 
                giftcard_id = '" . (int)$giftcard_id . "', 
                order_id    = '" . (int)$order_id . "', 
                amount      = '" . (float)$amount . "', 
                date_added  = NOW()");
    }

    public function buildMessage($data, $message) {
        $call = $data;
        unset($data);
        
        $data = $this->theme->language('notification/giftcard');

        $data['theme_image'] = $this->app['http.public'] . 'image/' . $call['image'];
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

        $html = new Template($this->app);
        $text = new Text($this->app);

        $html->data = $data;
        $text->data = $data;

        $html = $html->fetch('notification/giftcard');
        $text = $text->fetch('notification/giftcard');

        $message['text'] = str_replace('!content!', $text, $message['text']);
        $message['html'] = str_replace('!content!', $html, $message['html']);
        
        return $message;
    } 
}
