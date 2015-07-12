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

namespace App\Models\Admin\Sale;

use App\Models\Model;
use Dais\Support\Text;
use Dais\Support\Template;

class GiftCard extends Model {
    public function addGiftcard($data) {
        $this->db->query("
            INSERT INTO {$this->db->prefix}gift_card 
            SET 
                code              = '" . $this->db->escape($data['code']) . "', 
                from_name         = '" . $this->db->escape($data['from_name']) . "', 
                from_email        = '" . $this->db->escape($data['from_email']) . "', 
                to_name           = '" . $this->db->escape($data['to_name']) . "', 
                to_email          = '" . $this->db->escape($data['to_email']) . "', 
                gift_card_theme_id = '" . (int)$data['gift_card_theme_id'] . "', 
                message           = '" . $this->db->escape($data['message']) . "', 
                amount            = '" . (float)$data['amount'] . "', 
                status            = '" . (int)$data['status'] . "', 
                date_added        = NOW()"
        );
    }
    
    public function editGiftcard($gift_card_id, $data) {
        $this->db->query("
            UPDATE {$this->db->prefix}gift_card 
            SET 
                code              = '" . $this->db->escape($data['code']) . "', 
                from_name         = '" . $this->db->escape($data['from_name']) . "', 
                from_email        = '" . $this->db->escape($data['from_email']) . "', 
                to_name           = '" . $this->db->escape($data['to_name']) . "', 
                to_email          = '" . $this->db->escape($data['to_email']) . "', 
                gift_card_theme_id = '" . (int)$data['gift_card_theme_id'] . "', 
                message           = '" . $this->db->escape($data['message']) . "', 
                amount            = '" . (float)$data['amount'] . "', 
                status            = '" . (int)$data['status'] . "' 
            WHERE gift_card_id = '" . (int)$gift_card_id . "'
        ");
    }
    
    public function deleteGiftcard($gift_card_id) {
        $this->db->query("
            DELETE FROM {$this->db->prefix}gift_card 
            WHERE gift_card_id = '" . (int)$gift_card_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}gift_card_history 
            WHERE gift_card_id = '" . (int)$gift_card_id . "'");
    }
    
    public function getGiftcard($gift_card_id) {
        $query = $this->db->query("
            SELECT DISTINCT * 
            FROM {$this->db->prefix}gift_card 
            WHERE gift_card_id = '" . (int)$gift_card_id . "'
        ");
        
        return $query->row;
    }
    
    public function getGiftcardByCode($code) {
        $query = $this->db->query("
            SELECT DISTINCT * 
            FROM {$this->db->prefix}gift_card 
            WHERE code = '" . $this->db->escape($code) . "'
        ");
        
        return $query->row;
    }
    
    public function getGiftcards($data = array()) {
        $sql = "
        SELECT 
            v.gift_card_id, 
            v.code, 
            v.from_name, 
            v.from_email, 
            v.to_name, 
            v.to_email, 
            (SELECT vtd.name 
                FROM {$this->db->prefix}gift_card_theme_description vtd 
                WHERE vtd.gift_card_theme_id = v.gift_card_theme_id 
                AND vtd.language_id = '" . (int)Config::get('config_language_id') . "') AS theme, 
            v.amount, 
            v.status, 
            v.date_added 
        FROM {$this->db->prefix}gift_card v";
        
        $sort_data = array(
            'v.code', 
            'v.from_name', 
            'v.from_email', 
            'v.to_name', 
            'v.to_email', 
            'v.theme', 
            'v.amount', 
            'v.status', 
            'v.date_added'
        );
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY v.date_added";
        }
        
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql.= " DESC";
        } else {
            $sql.= " ASC";
        }
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            
            $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }
    
    public function sendGiftcard($gift_card_id) {
        $gift_card_info = $this->getGiftcard($gift_card_id);
        
        if ($gift_card_info):
            Theme::model('sale/gift_card_theme');
            $gift_card_theme_info = $this->model_sale_gift_card_theme->getGiftcardTheme($gift_card_info['gift_card_theme_id']);

            $card = array(
                'image'      => $gift_card_theme_info['image'],
                'theme'      => $gift_card_theme_info['name'],
                'to_name'    => $gift_card_info['to_name'],
                'code'       => $gift_card_info['code'],
                'amount'     => $gift_card_info['amount'],
                'message'    => $gift_card_info['message'],
                'from_name'  => $gift_card_info['from_name'],
                'from_email' => $gift_card_info['from_email']
            );

            $split    = explode(' ', $gift_card_info['to_name']);
            $callback = array(
                'firstname' => $split[0],
                'lastname'  => isset($split[1]) ? $split[1] : '',
                'email'     => $gift_card_info['to_email']
            );

            $this->notify->setGenericCustomer($callback);
            
            $message  = $this->notify->fetch('admin_gift_card_send');
            $priority = $message['priority'];
            
            // decorate the base email
            $message = $this->buildMessage($card, $message);

            $this->notify->fetchWrapper($priority);

            $message = $this->notify->formatEmail($message, 1);
            
            if ($priority == 1):
                $this->notify->send($message);
            else:
                $this->notify->addToEmailQueue($message);
            endif;
        endif;
    }
    
    public function getTotalGiftcards() {
        $query = $this->db->query("
            SELECT COUNT(*) AS total 
            FROM {$this->db->prefix}gift_card
        ");
        
        return $query->row['total'];
    }
    
    public function getTotalGiftcardsByGiftcardThemeId($gift_card_theme_id) {
        $query = $this->db->query("
            SELECT COUNT(*) AS total 
            FROM {$this->db->prefix}gift_card 
            WHERE gift_card_theme_id = '" . (int)$gift_card_theme_id . "'
        ");
        
        return $query->row['total'];
    }
    
    public function getGiftcardHistories($gift_card_id, $start = 0, $limit = 10) {
        if ($start < 0) {
            $start = 0;
        }
        
        if ($limit < 1) {
            $limit = 10;
        }
        
        $query = $this->db->query("
            SELECT 
                vh.order_id, 
                CONCAT(o.firstname, ' ', o.lastname) AS customer, 
                vh.amount, vh.date_added 
            FROM {$this->db->prefix}gift_card_history vh 
            LEFT JOIN `{$this->db->prefix}order` o 
            ON (vh.order_id = o.order_id) 
            WHERE vh.gift_card_id = '" . (int)$gift_card_id . "' 
            ORDER BY vh.date_added ASC 
            LIMIT " . (int)$start . "," . (int)$limit);
        
        return $query->rows;
    }
    
    public function getTotalGiftcardHistories($gift_card_id) {
        $query = $this->db->query("
            SELECT COUNT(*) AS total 
            FROM {$this->db->prefix}gift_card_history 
            WHERE gift_card_id = '" . (int)$gift_card_id . "'
        ");
        
        return $query->row['total'];
    }

    public function buildMessage($data, $message) {
        $call = $data;
        unset($data);

        $data = Theme::language('notification/gift_card');

        $data['theme_image'] = Config::get('http.public') . 'image/' . $call['image'];
        $data['theme_name']  = $call['theme'];
        $data['store_name']  = Config::get('config_name');
        $data['to_name']     = $call['to_name'];
        $data['code']        = $call['code'];

        $data['text_message'] = false;
        $data['html_message'] = false;

        if (isset($call['message'])):
            $data['text_message'] = $call['message'];
            $data['html_message'] = nl2br($call['message']);
        endif;

        $data['lang_text_message'] = sprintf(Lang::get('lang_text_message'), $call['from_name']);

        $search = array(
            '!amount!',
            '!sender!',
            '!sender_email!',
            '!code!'
        );

        $replace = array(
            Currency::format($call['amount']),
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
