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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

class Cart extends LibraryService {
    private $data = array();
    
    public function __construct(Container $app) {
        parent::__construct($app);
        
        if (!isset($app['session']->data['cart']) || !is_array($app['session']->data['cart'])):
            $app['session']->data['cart'] = array();
        endif;
    }
    
    public function getProducts() {
        $customer = parent::$app['customer'];
        $session  = parent::$app['session'];
        $db       = parent::$app['db'];
        
        if (!$this->data):
            foreach ($session->data['cart'] as $key => $quantity):
                $product    = explode(':', $key);
                $product_id = $product[0];
                $stock      = true;
                
                // Options
                if (!empty($product[1])):
                    $options = unserialize(base64_decode($product[1]));
                else:
                    $options = array();
                endif;
                
                // Profile
                
                if (!empty($product[2])):
                    $recurring_id = $product[2];
                else:
                    $recurring_id = 0;
                endif;
                
                $product_query = $db->query("
                    SELECT * 
                    FROM {$db->prefix}product p 
                    LEFT JOIN {$db->prefix}product_description pd 
                        ON (p.product_id = pd.product_id) 
                    WHERE p.product_id = '" . (int)$product_id . "' 
                    AND pd.language_id = '" . (int)parent::$app['config_language_id'] . "' 
                    AND p.date_available <= NOW() 
                    AND p.status = '1'
                ");
                
                if ($product_query->num_rows):
                    $option_price  = 0;
                    $option_points = 0;
                    $option_weight = 0;
                    
                    $option_data   = array();
                    
                    foreach ($options as $product_option_id => $option_value):
                        $option_query = $db->query("
                            SELECT 
                                po.product_option_id, 
                                po.option_id, 
                                od.name, 
                                o.type 
                            FROM {$db->prefix}product_option po 
                            LEFT JOIN `{$db->prefix}option` o 
                                ON (po.option_id = o.option_id) 
                            LEFT JOIN {$db->prefix}option_description od 
                                ON (o.option_id = od.option_id) 
                            WHERE po.product_option_id = '" . (int)$product_option_id . "' 
                            AND po.product_id = '" . (int)$product_id . "' 
                            AND od.language_id = '" . (int)parent::$app['config_language_id'] . "'
                        ");
                        
                        if ($option_query->num_rows):
                            if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image'):
                                $option_value_query = $db->query("
                                    SELECT 
                                        pov.option_value_id, 
                                        ovd.name, 
                                        pov.quantity, 
                                        pov.subtract, 
                                        pov.price, 
                                        pov.price_prefix, 
                                        pov.points, 
                                        pov.points_prefix, 
                                        pov.weight, 
                                        pov.weight_prefix 
                                    FROM {$db->prefix}product_option_value pov 
                                    LEFT JOIN {$db->prefix}option_value ov 
                                        ON (pov.option_value_id = ov.option_value_id) 
                                    LEFT JOIN {$db->prefix}option_value_description ovd 
                                        ON (ov.option_value_id = ovd.option_value_id) 
                                    WHERE pov.product_option_value_id = '" . (int)$option_value . "' 
                                    AND pov.product_option_id = '" . (int)$product_option_id . "' 
                                    AND ovd.language_id = '" . (int)parent::$app['config_language_id'] . "'
                                ");
                                
                                if ($option_value_query->num_rows):
                                    if ($option_value_query->row['price_prefix'] == '+'):
                                        $option_price+= $option_value_query->row['price'];
                                    elseif ($option_value_query->row['price_prefix'] == '-'):
                                        $option_price-= $option_value_query->row['price'];
                                    endif;
                                    
                                    if ($option_value_query->row['points_prefix'] == '+'):
                                        $option_points+= $option_value_query->row['points'];
                                    elseif ($option_value_query->row['points_prefix'] == '-'):
                                        $option_points-= $option_value_query->row['points'];
                                    endif;
                                    
                                    if ($option_value_query->row['weight_prefix'] == '+'):
                                        $option_weight+= $option_value_query->row['weight'];
                                    elseif ($option_value_query->row['weight_prefix'] == '-'):
                                        $option_weight-= $option_value_query->row['weight'];
                                    endif;
                                    
                                    if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))):
                                        $stock = false;
                                    endif;
                                    
                                    $option_data[] = array(
                                        'product_option_id'       => $product_option_id,
                                        'product_option_value_id' => $option_value,
                                        'option_id'               => $option_query->row['option_id'],
                                        'option_value_id'         => $option_value_query->row['option_value_id'],
                                        'name'                    => $option_query->row['name'],
                                        'option_value'            => $option_value_query->row['name'],
                                        'type'                    => $option_query->row['type'],
                                        'quantity'                => $option_value_query->row['quantity'],
                                        'subtract'                => $option_value_query->row['subtract'],
                                        'price'                   => $option_value_query->row['price'],
                                        'price_prefix'            => $option_value_query->row['price_prefix'],
                                        'points'                  => $option_value_query->row['points'],
                                        'points_prefix'           => $option_value_query->row['points_prefix'],
                                        'weight'                  => $option_value_query->row['weight'],
                                        'weight_prefix'           => $option_value_query->row['weight_prefix']
                                    );
                                endif;
                            elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)):
                                foreach ($option_value as $product_option_value_id):
                                    $option_value_query = $db->query("
                                        SELECT 
                                            pov.option_value_id, 
                                            ovd.name, 
                                            pov.quantity, 
                                            pov.subtract, 
                                            pov.price, 
                                            pov.price_prefix, 
                                            pov.points, 
                                            pov.points_prefix, 
                                            pov.weight, 
                                            pov.weight_prefix 
                                        FROM {$db->prefix}product_option_value pov 
                                        LEFT JOIN {$db->prefix}option_value ov 
                                            ON (pov.option_value_id = ov.option_value_id) 
                                        LEFT JOIN {$db->prefix}option_value_description ovd 
                                            ON (ov.option_value_id = ovd.option_value_id) 
                                        WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' 
                                        AND pov.product_option_id = '" . (int)$product_option_id . "' 
                                        AND ovd.language_id = '" . (int)parent::$app['config_language_id'] . "'
                                    ");
                                    
                                    if ($option_value_query->num_rows):
                                        if ($option_value_query->row['price_prefix'] == '+'):
                                            $option_price+= $option_value_query->row['price'];
                                        elseif ($option_value_query->row['price_prefix'] == '-'):
                                            $option_price-= $option_value_query->row['price'];
                                        endif;
                                        
                                        if ($option_value_query->row['points_prefix'] == '+'):
                                            $option_points+= $option_value_query->row['points'];
                                        elseif ($option_value_query->row['points_prefix'] == '-'):
                                            $option_points-= $option_value_query->row['points'];
                                        endif;
                                        
                                        if ($option_value_query->row['weight_prefix'] == '+'):
                                            $option_weight+= $option_value_query->row['weight'];
                                        elseif ($option_value_query->row['weight_prefix'] == '-'):
                                            $option_weight-= $option_value_query->row['weight'];
                                        endif;
                                        
                                        if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))):
                                            $stock = false;
                                        endif;
                                        
                                        $option_data[] = array(
                                            'product_option_id'       => $product_option_id,
                                            'product_option_value_id' => $product_option_value_id,
                                            'option_id'               => $option_query->row['option_id'],
                                            'option_value_id'         => $option_value_query->row['option_value_id'],
                                            'name'                    => $option_query->row['name'],
                                            'option_value'            => $option_value_query->row['name'],
                                            'type'                    => $option_query->row['type'],
                                            'quantity'                => $option_value_query->row['quantity'],
                                            'subtract'                => $option_value_query->row['subtract'],
                                            'price'                   => $option_value_query->row['price'],
                                            'price_prefix'            => $option_value_query->row['price_prefix'],
                                            'points'                  => $option_value_query->row['points'],
                                            'points_prefix'           => $option_value_query->row['points_prefix'],
                                            'weight'                  => $option_value_query->row['weight'],
                                            'weight_prefix'           => $option_value_query->row['weight_prefix']
                                        );
                                    endif;
                                endforeach;
                            elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time'):
                                
                                $option_data[] = array(
                                    'product_option_id'       => $product_option_id,
                                    'product_option_value_id' => '',
                                    'option_id'               => $option_query->row['option_id'],
                                    'option_value_id'         => '',
                                    'name'                    => $option_query->row['name'],
                                    'option_value'            => $option_value,
                                    'type'                    => $option_query->row['type'],
                                    'quantity'                => '',
                                    'subtract'                => '',
                                    'price'                   => '',
                                    'price_prefix'            => '',
                                    'points'                  => '',
                                    'points_prefix'           => '',
                                    'weight'                  => '',
                                    'weight_prefix'           => ''
                                );
                            endif;
                        endif;
                    endforeach;
                    
                    if ($customer->isLogged()):
                        $customer_group_id = $customer->getGroupId();
                    else:
                        $customer_group_id = parent::$app['config_customer_group_id'];
                    endif;
                    
                    $price = $product_query->row['price'];
                    
                    // Product Discounts
                    $discount_quantity = 0;
                    
                    foreach ($session->data['cart'] as $key_2 => $quantity_2):
                        $product_2 = explode(':', $key_2);
                        
                        if ($product_2[0] == $product_id):
                            $discount_quantity+= $quantity_2;
                        endif;
                    endforeach;
                    
                    $product_discount_query = $db->query("
                        SELECT price 
                        FROM {$db->prefix}product_discount 
                        WHERE product_id = '" . (int)$product_id . "' 
                        AND customer_group_id = '" . (int)$customer_group_id . "' 
                        AND quantity <= '" . (int)$discount_quantity . "' 
                        AND ((date_start = '0000-00-00' OR date_start < NOW()) 
                        AND (date_end = '0000-00-00' OR date_end > NOW())) 
                        ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1
                    ");
                    
                    if ($product_discount_query->num_rows):
                        $price = $product_discount_query->row['price'];
                    endif;
                    
                    // Product Specials
                    $product_special_query = $db->query("
                        SELECT price 
                        FROM {$db->prefix}product_special 
                        WHERE product_id = '" . (int)$product_id . "' 
                        AND customer_group_id = '" . (int)$customer_group_id . "' 
                        AND ((date_start = '0000-00-00' OR date_start < NOW()) 
                        AND (date_end = '0000-00-00' OR date_end > NOW())) 
                        ORDER BY priority ASC, price ASC LIMIT 1
                    ");
                    
                    if ($product_special_query->num_rows):
                        $price = $product_special_query->row['price'];
                    endif;
                    
                    // Reward Points
                    $product_reward_query = $db->query("
                        SELECT points 
                        FROM {$db->prefix}product_reward 
                        WHERE product_id = '" . (int)$product_id . "' 
                        AND customer_group_id = '" . (int)$customer_group_id . "'
                    ");
                    
                    if ($product_reward_query->num_rows):
                        $reward = $product_reward_query->row['points'];
                    else:
                        $reward = 0;
                    endif;
                    
                    // Downloads
                    $download_data = array();
                    
                    $download_query = $db->query("
                        SELECT * 
                        FROM {$db->prefix}product_to_download p2d 
                        LEFT JOIN {$db->prefix}download d 
                            ON (p2d.download_id = d.download_id) 
                        LEFT JOIN {$db->prefix}download_description dd 
                            ON (d.download_id = dd.download_id) 
                        WHERE p2d.product_id = '" . (int)$product_id . "' 
                        AND dd.language_id = '" . (int)parent::$app['config_language_id'] . "'
                    ");
                    
                    foreach ($download_query->rows as $download):
                        $download_data[] = array(
                            'download_id' => $download['download_id'],
                            'name'        => $download['name'],
                            'filename'    => $download['filename'],
                            'mask'        => $download['mask'],
                            'remaining'   => $download['remaining']
                        );
                    endforeach;
                    
                    // Stock
                    if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity)):
                        $stock = false;
                    endif;
                    
                    if ($customer->isLogged()):
                        $group_id = $customer->getGroupId();
                    else:
                        $group_id = parent::$app['config_default_visibility'];
                    endif;
                    
                    $recurring_query = $db->query("
                        SELECT * 
                        FROM {$db->prefix}recurring p 
                        JOIN {$db->prefix}product_recurring pp 
                            ON (pp.recurring_id = p.recurring_id) 
                            AND (pp.product_id = " . (int)$product_query->row['product_id'] . ") 
                        JOIN {$db->prefix}recurring_description pd 
                            ON (pd.recurring_id = p.recurring_id) 
                            AND (pd.language_id = " . (int)parent::$app['config_language_id'] . ") 
                        WHERE pp.recurring_id = '" . (int)$recurring_id . "' 
                        AND status = '" . (int)1 . "' 
                        AND pp.customer_group_id = '" . (int)$group_id . "'");
                    
                    if ($recurring_query->num_rows):
                        $recurring = array(
                            'recurring_id'    => $recurring_id,
                            'name'            => $recurring_query->row['name'],
                            'frequency'       => $recurring_query->row['frequency'],
                            'price'           => $recurring_query->row['price'],
                            'cycle'           => $recurring_query->row['cycle'],
                            'duration'        => $recurring_query->row['duration'],
                            'trial'           => $recurring_query->row['trial_status'],
                            'trial_frequency' => $recurring_query->row['trial_frequency'],
                            'trial_price'     => $recurring_query->row['trial_price'],
                            'trial_cycle'     => $recurring_query->row['trial_cycle'],
                            'trial_duration'  => $recurring_query->row['trial_duration']
                        );
                    else:
                        $recurring = false;
                    endif;
                    
                    if ($recurring):
                        $new_price = $recurring['price'] + $option_price;
                    else:
                        $new_price = $price + $option_price;
                    endif;
                    
                    $this->data[$key] = array(
                        'key'             => $key,
                        'product_id'      => $product_query->row['product_id'],
                        'name'            => $product_query->row['name'],
                        'model'           => $product_query->row['model'],
                        'shipping'        => $product_query->row['shipping'],
                        'image'           => $product_query->row['image'],
                        'option'          => $option_data,
                        'download'        => $download_data,
                        'quantity'        => $quantity,
                        'minimum'         => $product_query->row['minimum'],
                        'subtract'        => $product_query->row['subtract'],
                        'stock'           => $stock,
                        'price'           => $new_price,
                        'total'           => $new_price * $quantity,
                        'reward'          => $reward * $quantity,
                        'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0) ,
                        'tax_class_id'    => $product_query->row['tax_class_id'],
                        'weight'          => ($product_query->row['weight'] + $option_weight) * $quantity,
                        'weight_class_id' => $product_query->row['weight_class_id'],
                        'length'          => $product_query->row['length'],
                        'width'           => $product_query->row['width'],
                        'height'          => $product_query->row['height'],
                        'length_class_id' => $product_query->row['length_class_id'],
                        'recurring'       => $recurring
                    );
                else:
                    $this->remove($key);
                endif;
            endforeach;
        endif;
        
        return $this->data;
    }
    
    public function getRecurringProducts() {
        $recurring_products = array();
        
        foreach ($this->getProducts() as $key => $value):
            if ($value['recurring']):
                $recurring_products[$key] = $value;
            endif;
        endforeach;
        
        return $recurring_products;
    }
    
    public function add($product_id, $qty = 1, $option, $recurring_id = '') {
        $session = parent::$app['session'];
        $key     = (int)$product_id . ':';
        
        if ($option):
            $key.= base64_encode(serialize($option)) . ':';
        else:
            $key.= ':';
        endif;
        
        if ($recurring_id):
            $key.= (int)$recurring_id;
        endif;
        
        if ((int)$qty && ((int)$qty > 0)):
            if (!isset($session->data['cart'][$key])):
                $session->data['cart'][$key] = (int)$qty;
            else:
                $session->data['cart'][$key]+= (int)$qty;
            endif;
        endif;
        
        $this->data = array();
    }
    
    public function update($key, $qty) {
        $session = parent::$app['session'];
        
        if ((int)$qty && ((int)$qty > 0)):
            $session->data['cart'][$key] = (int)$qty;
        else:
            $this->remove($key);
        endif;
        
        $this->data = array();
    }
    
    public function remove($key) {
        $session = parent::$app['session'];
        
        if (isset($session->data['cart'][$key])):
            unset($session->data['cart'][$key]);
        endif;
        
        $this->data = array();
    }
    
    public function clear() {
        $session = parent::$app['session'];
        
        $session->data['cart'] = array();
        $this->data = array();
    }
    
    public function getWeight() {
        $weight = parent::$app['weight'];
        
        $weight_data = 0;
        
        foreach ($this->getProducts() as $product):
            if ($product['shipping']):
                $weight_data+= $weight->convert($product['weight'], $product['weight_class_id'], parent::$app['config_weight_class_id']);
            endif;
        endforeach;
        
        return $weight_data;
    }
    
    public function getSubTotal() {
        $total = 0;
        
        foreach ($this->getProducts() as $product):
            $total+= $product['total'];
        endforeach;
        
        return $total;
    }
    
    public function getTaxes() {
        $tax = parent::$app['tax'];
        
        $tax_data = array();
        
        foreach ($this->getProducts() as $product):
            if ($product['tax_class_id']):
                $tax_rates = $tax->getRates($product['price'], $product['tax_class_id']);
                
                foreach ($tax_rates as $tax_rate):
                    if (!isset($tax_data[$tax_rate['tax_rate_id']])):
                        $tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
                    else:
                        $tax_data[$tax_rate['tax_rate_id']]+= ($tax_rate['amount'] * $product['quantity']);
                    endif;
                endforeach;
            endif;
        endforeach;
        
        return $tax_data;
    }
    
    public function getTotal() {
        $tax = parent::$app['tax'];
        
        $total = 0;
        
        foreach ($this->getProducts() as $product):
            $total+= $tax->calculate($product['price'], $product['tax_class_id'], parent::$app['config_tax']) * $product['quantity'];
        endforeach;
        
        return $total;
    }
    
    public function countProducts() {
        $product_total = 0;
        
        $products = $this->getProducts();
        
        foreach ($products as $product):
            $product_total+= $product['quantity'];
        endforeach;
        
        return $product_total;
    }
    
    public function hasProducts() {
        $session = parent::$app['session'];
        
        return count($session->data['cart']);
    }
    
    public function hasRecurringProducts() {
        return count($this->getRecurringProducts());
    }
    
    public function hasStock() {
        $stock = true;
        
        foreach ($this->getProducts() as $product):
            if (!$product['stock']):
                $stock = false;
            endif;
        endforeach;
        
        return $stock;
    }
    
    public function hasShipping() {
        $shipping = false;
        
        foreach ($this->getProducts() as $product):
            if ($product['shipping']):
                $shipping = true;
                break;
            endif;
        endforeach;
        
        return $shipping;
    }
    
    public function hasDownload() {
        $download = false;
        
        foreach ($this->getProducts() as $product):
            if ($product['download']):
                $download = true;
                break;
            endif;
        endforeach;
        
        return $download;
    }
}
