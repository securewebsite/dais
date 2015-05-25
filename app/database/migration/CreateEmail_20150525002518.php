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
|   Your table prefix has been included so that you can easily write your 
|   migrations to include the proper prefix.
|   
|   $users = $this->create_table("{$this->prefix}users");
|
|   Obviously if you have no table prefix, this variable will be empty.
|   
*/

namespace Database\Migration;
use Egress\Library\Migration\MigrationBase;

class CreateEmail_20150525002518 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}email", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('email_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('email_slug', 'string', array('limit' => 55));
        $table->column('configurable', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 0));
        $table->column('priority', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 2));
        $table->column('config_description', 'text');
        $table->column('recipient', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 1));
        $table->column('is_system', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 1));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}email` (`email_id`, `email_slug`, `configurable`, `priority`, `config_description`, `recipient`, `is_system`) VALUES
                (1, 'admin_forgotten_email', 0, 1, '', 2, 1),
                (2, 'admin_people_contact', 1, 2, 'Customer Newsletter', 1, 1),
                (3, 'admin_event_add', 1, 2, 'Administrator Adds You to an Event', 1, 1),
                (4, 'admin_event_waitlist', 1, 2, 'Administrator Adds You to an Event Waitlist ', 1, 1),
                (5, 'admin_affiliate_add_commission', 1, 2, 'Administrator Adds a Commission to Your Affiliate Account', 1, 1),
                (7, 'admin_customer_approve', 0, 2, '', 1, 1),
                (8, 'admin_customer_add_credit', 1, 2, 'Administrator Adds a Store Credit to Your Customer Account', 1, 1),
                (9, 'admin_customer_add_reward', 1, 2, 'Administrator Adds Reward Points to Your Customer Account', 1, 1),
                (10, 'admin_order_add_history', 1, 2, 'Administrator Updates Your Active Orders', 1, 1),
                (11, 'admin_return_add_history', 1, 2, 'Administrator Updates Your Active Returns', 1, 1),
                (12, 'admin_gift_card_send', 0, 1, '', 1, 1),
                (14, 'public_waitlist_join', 1, 2, 'You Join an Event Waitlist', 1, 1),
                (15, 'public_customer_order_confirm', 1, 2, 'You Place an Order', 1, 1),
                (16, 'public_admin_order_confirm', 0, 2, '', 2, 1),
                (18, 'public_customer_forgotten', 0, 1, '', 1, 1),
                (20, 'public_contact_admin', 0, 2, '', 2, 1),
                (21, 'public_contact_customer', 0, 1, '', 1, 1),
                (22, 'public_register_customer', 0, 2, '', 1, 1),
                (23, 'public_register_admin', 0, 2, '', 2, 1),
                (26, 'public_giftcard_confirm', 0, 1, '', 1, 1),
                (27, 'email_wrapper', 0, 2, '', 1, 1),
                (28, 'email_wrapper', 0, 1, '', 1, 1)";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}email");
    }
}
