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

namespace Admin\Model\Sale;
use Dais\Engine\Model;
use Dais\Library\Language;
use Dais\Library\Text;
use Dais\Library\Template;

class Giftcard extends Model {
    public function addGiftcard($data) {
        $this->db->query("
            INSERT INTO {$this->db->prefix}giftcard 
            SET 
                code              = '" . $this->db->escape($data['code']) . "', 
                from_name         = '" . $this->db->escape($data['from_name']) . "', 
                from_email        = '" . $this->db->escape($data['from_email']) . "', 
                to_name           = '" . $this->db->escape($data['to_name']) . "', 
                to_email          = '" . $this->db->escape($data['to_email']) . "', 
                giftcard_theme_id = '" . (int)$data['giftcard_theme_id'] . "', 
                message           = '" . $this->db->escape($data['message']) . "', 
                amount            = '" . (float)$data['amount'] . "', 
                status            = '" . (int)$data['status'] . "', 
                date_added        = NOW()"
        );
    }
    
    public function editGiftcard($giftcard_id, $data) {
        $this->db->query("
            UPDATE {$this->db->prefix}giftcard 
            SET 
                code              = '" . $this->db->escape($data['code']) . "', 
                from_name         = '" . $this->db->escape($data['from_name']) . "', 
                from_email        = '" . $this->db->escape($data['from_email']) . "', 
                to_name           = '" . $this->db->escape($data['to_name']) . "', 
                to_email          = '" . $this->db->escape($data['to_email']) . "', 
                giftcard_theme_id = '" . (int)$data['giftcard_theme_id'] . "', 
                message           = '" . $this->db->escape($data['message']) . "', 
                amount            = '" . (float)$data['amount'] . "', 
                status            = '" . (int)$data['status'] . "' 
            WHERE giftcard_id = '" . (int)$giftcard_id . "'
        ");
    }
    
    public function deleteGiftcard($giftcard_id) {
        $this->db->query("
            DELETE FROM {$this->db->prefix}giftcard 
            WHERE giftcard_id = '" . (int)$giftcard_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}giftcard_history 
            WHERE giftcard_id = '" . (int)$giftcard_id . "'");
    }
    
    public function getGiftcard($giftcard_id) {
        $query = $this->db->query("
            SELECT DISTINCT * 
            FROM {$this->db->prefix}giftcard 
            WHERE giftcard_id = '" . (int)$giftcard_id . "'
        ");
        
        return $query->row;
    }
    
    public function getGiftcardByCode($code) {
        $query = $this->db->query("
            SELECT DISTINCT * 
            FROM {$this->db->prefix}giftcard 
            WHERE code = '" . $this->db->escape($code) . "'
        ");
        
        return $query->row;
    }
    
    public function getGiftcards($data = array()) {
        $sql = "
        SELECT 
            v.giftcard_id, 
            v.code, 
            v.from_name, 
            v.from_email, 
            v.to_name, 
            v.to_email, 
            (SELECT vtd.name 
                FROM {$this->db->prefix}giftcard_theme_description vtd 
                WHERE vtd.giftcard_theme_id = v.giftcard_theme_id 
                AND vtd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS theme, 
            v.amount, 
            v.status, 
            v.date_added 
        FROM {$this->db->prefix}giftcard v";
        
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
    
    public function sendGiftcard($giftcard_id) {
        $giftcard_info = $this->getGiftcard($giftcard_id);
        
        if ($giftcard_info):
            $this->theme->model('sale/giftcardtheme');
            $giftcard_theme_info = $this->model_sale_giftcardtheme->getGiftcardTheme($giftcard_info['giftcard_theme_id']);

            $card = array(
                'image'      => $giftcard_theme_info['image'],
                'theme'      => $giftcard_theme_info['name'],
                'to_name'    => $giftcard_info['to_name'],
                'code'       => $giftcard_info['code'],
                'amount'     => $giftcard_info['amount'],
                'message'    => $giftcard_info['message'],
                'from_name'  => $giftcard_info['from_name'],
                'from_email' => $giftcard_info['from_email']
            );

            $split    = explode(' ', $giftcard_info['to_name']);
            $callback = array(
                'firstname' => $split[0],
                'lastname'  => isset($split[1]) ? $split[1] : '',
                'email'     => $giftcard_info['to_email']
            );

            $this->notify->setGenericCustomer($callback);
            
            $message  = $this->notify->fetch('admin_giftcard_send');
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
            FROM {$this->db->prefix}giftcard
        ");
        
        return $query->row['total'];
    }
    
    public function getTotalGiftcardsByGiftcardThemeId($giftcard_theme_id) {
        $query = $this->db->query("
            SELECT COUNT(*) AS total 
            FROM {$this->db->prefix}giftcard 
            WHERE giftcard_theme_id = '" . (int)$giftcard_theme_id . "'
        ");
        
        return $query->row['total'];
    }
    
    public function getGiftcardHistories($giftcard_id, $start = 0, $limit = 10) {
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
            FROM {$this->db->prefix}giftcard_history vh 
            LEFT JOIN `{$this->db->prefix}order` o 
            ON (vh.order_id = o.order_id) 
            WHERE vh.giftcard_id = '" . (int)$giftcard_id . "' 
            ORDER BY vh.date_added ASC 
            LIMIT " . (int)$start . "," . (int)$limit);
        
        return $query->rows;
    }
    
    public function getTotalGiftcardHistories($giftcard_id) {
        $query = $this->db->query("
            SELECT COUNT(*) AS total 
            FROM {$this->db->prefix}giftcard_history 
            WHERE giftcard_id = '" . (int)$giftcard_id . "'
        ");
        
        return $query->row['total'];
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
