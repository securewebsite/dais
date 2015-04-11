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

namespace Front\Controller\Account;
use Dais\Engine\Controller;

class Affiliate extends Controller {

	private $error = array();
	private $post_errors = array(
        'code',
        'tax_id',
        'payment',
        'cheque',
        'paypal',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'slug',
        'agree'
    );

	public function index() {
        if (!$this->customer->isLogged()):
            $this->session->data['redirect'] = $this->url->link('account/affiliate', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        endif;
        
        $this->theme->language('account/affiliate');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }

    public function update() {
		if (!$this->customer->isLogged()):
            $this->session->data['redirect'] = $this->url->link('account/affiliate', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        endif;

		$this->theme->language('account/affiliate');
        $this->theme->model('account/affiliate');

        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
        	$this->model_account_affiliate->editSettings($this->request->post);

        	$this->session->data['success'] = $this->language->get('lang_text_success');
        	$this->response->redirect($this->url->link('account/dashboard', '', 'SSL'));
        endif;

        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
	}

	public function register() {
		if (!$this->customer->isLogged()):
            $this->session->data['redirect'] = $this->url->link('account/affiliate', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        endif;

		$this->theme->language('account/affiliate');
        $this->theme->model('account/affiliate');

        $this->theme->setTitle($this->language->get('lang_heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateRegister()):
        	$this->model_account_affiliate->addAffiliate();
        	$this->response->redirect($this->url->link('account/affiliate', '', 'SSL'));
        endif;

        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
	}

	public function getForm() {
		if (!$this->customer->isLogged()):
            $this->session->data['redirect'] = $this->url->link('account/affiliate', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        endif;
        
        $data = $this->theme->language('account/affiliate');
        $this->theme->model('account/affiliate');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->breadcrumb->add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        $this->breadcrumb->add('lang_heading_title', 'account/affiliate', null, true, 'SSL');
        
        if (isset($this->session->data['warning'])):
            $data['warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        elseif (isset($this->error['warning'])):
            $data['warning'] = $this->error['warning'];
        else:
            $data['warning'] = '';
        endif;

        $data['action'] = $this->url->link('account/affiliate/update', '', 'SSL');
        $data['enroll'] = $this->url->link('account/affiliate/register', '', 'SSL');

		if ($this->request->server['REQUEST_METHOD'] != 'POST'):
			$customer_info = $this->model_account_affiliate->getSettings();
		endif;
        
		$data['is_affiliate'] = $this->customer->isAffiliate();
		$data['customer_id']  = $this->customer->getId();

		foreach ($this->post_errors as $error):
            if (isset($this->error[$error])):
                $data['error_' . $error] = $this->error[$error];
            else:
                $data['error_' . $error] = '';
            endif;
        endforeach;

        $code = $this->model_account_affiliate->generateId();

        $defaults = array(
            'affiliate_status'    => 0,
            'company'             => '',
            'website'             => '',
            'code'                => $code,
            'commission'          => $this->config->get('config_commission'),
            'tax_id'              => '',
            'payment_method'      => '',
            'cheque'              => '',
            'paypal'              => '',
            'bank_name'           => '',
            'bank_branch_number'  => '',
            'bank_swift_code'     => '',
            'bank_account_name'   => '',
            'bank_account_number' => '',
            'slug'                => ''
        );

        if ($this->config->get('config_affiliate_terms')):
            $this->theme->model('content/page');
            
            $page_info = $this->model_content_page->getPage($this->config->get('config_affiliate_terms'));
            if ($page_info):
				$data['text_agree']     = sprintf($this->language->get('lang_text_terms'), $this->url->link('content/page/info', 'page_id=' . $this->config->get('config_affiliate_terms'), 'SSL'), $page_info['title'], $page_info['title']);
				$data['js_error_agree'] = sprintf($this->language->get('lang_error_agree'), $page_info['title']);
            else:
				$data['text_agree']     = '';
				$data['js_error_agree'] = '';
            endif;
        else:
			$data['text_agree']     = '';
			$data['js_error_agree'] = '';
        endif;

        if (isset($this->request->post['agree'])):
            $data['agree'] = $this->request->post['agree'];
        else:
            $data['agree'] = false;
        endif;

        foreach ($defaults as $key => $value):
            if (isset($this->request->post[$key])):
                $data[$key] = $this->request->post[$key];
            elseif (!empty($customer_info)):
                $data[$key] = $customer_info[$key];
            else:
                $data[$key] = $value;
            endif;
        endforeach;

        $data['vanity_base'] = $this->app['http.server'];

        if (!empty($customer_info)):
            $base_url = $this->url->link($this->theme->style . '/home', 'affiliate_id=' . $this->customer->getId());
        else:
            $base_url = $this->url->link($this->theme->style . '/home');
        endif;

		$data['lang_text_description'] = sprintf($this->language->get('lang_text_description'), $base_url);
		$data['lang_text_enroll_now']  = sprintf($this->language->get('lang_text_enroll_now'), $this->customer->getFirstname());
		$data['column_amount']         = sprintf($this->language->get('lang_column_amount'), $this->config->get('config_currency'));

		$data['commissions'] = array();

        if (isset($this->request->get['page'])):
            $page = $this->request->get['page'];
        else:
            $page = 1;
        endif;
        
        $filter = array(
			'sort'  => 't.date_added', 
			'order' => 'DESC', 
			'start' => ($page - 1) * 10, 
			'limit' => 10
        );

		$total_commissions = $this->model_account_affiliate->getTotalCommissions();
		$commissions       = $this->model_account_affiliate->getCommissions($filter);
		$data['balance']   = $this->currency->format($this->model_account_affiliate->getBalance());
        
        foreach ($commissions as $commission):
            $data['commissions'][] = array(
				'amount'      => $this->currency->format($commission['amount'], $this->config->get('config_currency')), 
				'description' => $commission['description'], 
				'date_added'  => date($this->language->get('lang_date_format_short'), strtotime($commission['date_added']))
            );
        endforeach;

        $data['pagination'] = $this->theme->paginate(
            $total_commissions, 
            $page, 
            10, 
            $this->language->get('lang_text_pagination'), 
            $this->url->link('account/affiliate#tab-commission', 'page={page}', 'SSL')
        );

        $this->theme->loadjs('javascript/account/affiliate', $data);

        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('account/affiliate', $data));
	}

	public function autocomplete() {
        if (!$this->customer->isLogged()):
            $this->session->data['redirect'] = $this->url->link('account/affiliate', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        endif;

        $json = array();
        
        if (isset($this->request->get['filter_name'])):
            $this->theme->model('catalog/product');
            
            $filter = array(
				'filter_name' => $this->request->get['filter_name'], 
				'start'       => 0, 
				'limit'       => 20
            );
            
            $results = $this->model_catalog_product->getProducts($filter);
            
            foreach ($results as $result):
                $json[] = array(
                	'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 
                	'link' => str_replace('&amp;', '&', $this->url->link('catalog/product', 'product_id=' . $result['product_id'] . '&z=' . $this->customer->getCode()))
                );
            endforeach;
        endif;
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }

    private function validateRegister() {
    	if ($this->config->get('config_affiliate_terms')):
            $this->theme->model('content/page');
            
            $page_info = $this->model_content_page->getPage($this->config->get('config_affiliate_terms'));
            
            if ($page_info && !isset($this->request->post['agree'])):
                $this->error['warning'] = sprintf($this->language->get('lang_error_agree'), $page_info['title']);
            endif;
        endif;
        
        if ($this->error && !isset($this->error['warning'])):
            $this->error['warning'] = $this->language->get('lang_error_warning');
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }

	private function validate() {
        if ($this->encode->strlen($this->request->post['tax_id']) < 1):
            $this->error['tax_id'] = $this->language->get('lang_error_tax_id');
        endif;

        if ($this->encode->strlen($this->request->post['slug']) < 1):
            $this->error['slug'] = $this->language->get('lang_error_slug');
        endif;

        if (!$this->request->post['payment_method']):
            $this->error['payment'] = $this->language->get('lang_error_payment');
        else:
            if ($this->request->post['payment_method'] == 'cheque' && $this->encode->strlen($this->request->post['cheque']) < 1):
                $this->error['cheque'] = $this->language->get('lang_error_cheque');
            endif;

            if ($this->request->post['payment_method'] == 'paypal' && $this->encode->strlen($this->request->post['paypal']) < 1):
                $this->error['paypal'] = $this->language->get('lang_error_paypal');
            endif;

            if ($this->request->post['payment_method'] == 'bank' && $this->encode->strlen($this->request->post['bank_name']) < 1):
                $this->error['bank_name'] = $this->language->get('lang_error_bank_name');
            endif;

            if ($this->request->post['payment_method'] == 'bank' && $this->encode->strlen($this->request->post['bank_account_name']) < 1):
                $this->error['bank_account_name'] = $this->language->get('lang_error_account_name');
            endif;

            if ($this->request->post['payment_method'] == 'bank' && $this->encode->strlen($this->request->post['bank_account_number']) < 1):
                $this->error['bank_account_number'] = $this->language->get('lang_error_account_number');
            endif;
        endif;
        
        if ($this->error && !isset($this->error['warning'])):
            $this->error['warning'] = $this->language->get('lang_error_warning');
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
	}

    public function slug() {
        if (!$this->customer->isLogged()):
            $this->session->data['redirect'] = $this->url->link('account/affiliate', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        endif;

        $this->language->load('account/affiliate');
        $this->theme->model('tool/utility');
        
        $json = array();
        
        if (!isset($this->request->get['name']) || $this->encode->strlen($this->request->get['name']) < 1):
            $json['error'] = $this->language->get('lang_error_slug');
        else:
            
            // build slug
            $slug = $this->url->build_slug($this->request->get['name']);
            
            // check that the slug is globally unique
            $query = $this->model_tool_utility->findSlugByName($slug);
            
            if ($query):
                if ($query != 'affiliate_id:' . $this->customer->getId()):
                    $json['error'] = sprintf($this->language->get('lang_error_slug_found'), $slug);
                else:
                    $json['slug'] = $slug;
                endif;
            else:
                $json['slug'] = $slug;
            endif;
        endif;
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
