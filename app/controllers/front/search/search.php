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

namespace App\Controllers\Front\Search;
use App\Controllers\Controller;

class Search extends Controller {

	public function index() {
		$data = $this->theme->language('search/search');

		$this->javascript->register('storage.min', 'jquery.min');

		$this->breadcrumb->add('lang_heading_title', 'search/search');

		if (isset($this->request->post['search'])):
			$search = $this->request->post['search'];
		else:
			$search = false;
		endif;

		if (isset($this->request->get['page'])):
            $page = $this->request->get['page'];
        else:
            $page = 1;
        endif;

        $limit = $this->config->get('config_catalog_limit');
        
        $filter = array(
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );
        
        if ($search):
            $this->theme->setTitle($this->language->get('lang_heading_title') . ' - ' . $search);
            $data['heading_title'] = $this->language->get('lang_heading_title') . ': ' . $search;
            $data['search'] = $search;
        else:
        	$this->theme->setTitle($this->language->get('lang_heading_title'));
            $data['heading_title'] = $this->language->get('lang_heading_title');
            $data['search'] = '';
        endif;

        $data['action'] = $this->url->link('search/search');

        $data['results'] = array();

        $result_total = 0;

        if ($search):

            $results      = $this->search->execute($search, $filter);
            $result_total = $this->search->total();

            if ($results):
                foreach ($results as $key => $result):
                    switch($key):
                        case 'products':
                            foreach ($result as $value):
                                $item = array(
                                    'title' => $value['name'],
                                    'text'  => $value['description'],
                                    'url'   => $this->url->link('catalog/product', 'product_id=' . $value['product_id'], 'SSL'),
                                    'type'  => $this->language->get('lang_product')
                                );
                                $data['results'][] = $item;
                            endforeach;
                            break;
                        case 'categories':
                            foreach ($result as $value):
                                $path = ($value['parent_id'] > 0) ? $value['parent_id'] . '_' . $value['category_id'] : $value['category_id'];

                                $item = array(
                                    'title' => $value['name'],
                                    'text'  => $value['description'],
                                    'url'   => $this->url->link('catalog/category', 'path=' . $path, 'SSL'),
                                    'type'  => $this->language->get('lang_product_category')
                                );
                                $data['results'][] = $item;
                            endforeach;
                            break;
                        case 'posts':
                            foreach ($result as $value):
                                $item = array(
                                    'title' => $value['name'],
                                    'text'  => $value['description'],
                                    'url'   => $this->url->link('content/post', 'post_id=' . $value['post_id'], 'SSL'),
                                    'type'  => $this->language->get('lang_article')
                                );
                                $data['results'][] = $item;
                            endforeach;
                            break;
                        case 'blog_categories':
                            foreach ($result as $value):
                                $path = ($value['parent_id'] > 0) ? $value['parent_id'] . '_' . $value['category_id'] : $value['category_id'];

                                $item = array(
                                    'title' => $value['name'],
                                    'text'  => $value['description'],
                                    'url'   => $this->url->link('content/category', 'bpath=' . $path, 'SSL'),
                                    'type'  => $this->language->get('lang_blog_category')
                                );
                                $data['results'][] = $item;
                            endforeach;
                            break;
                        case 'pages':
                           foreach ($result as $value):
                                $url = ($value['event_id'] > 0) ? $this->url->link('event/page', 'event_page_id=' . $value['page_id'], 'SSL') : $this->url->link('content/page', 'page_id=' . $value['page_id'], 'SSL');
                                $item = array(
                                    'title' => $value['title'],
                                    'text'  => $value['description'],
                                    'url'   => $url,
                                    'type'  => $this->language->get('lang_page')
                                );
                                $data['results'][] = $item;
                            endforeach;
                            break;
                        case 'manufacturers':
                            foreach ($result as $value):
                                $item = array(
                                    'title' => $value['name'],
                                    'text'  => '',
                                    'url'   => $this->url->link('catalog/manufacturer/info', 'manufacturer_id=' . $value['manufacturer_id'], 'SSL'),
                                    'type'  => $this->language->get('lang_manufacturer')
                                );
                                $data['results'][] = $item;
                            endforeach;
                            break;
                    endswitch;
                endforeach;
            endif;

        endif;

        $data['pagination'] = $this->theme->paginate(
            $result_total, 
            $page, 
            $this->config->get('config_catalog_limit'), 
            $this->language->get('lang_text_pagination'), 
            $this->url->link('search/search', 'search=' . $search . '&page={page}')
        );
        
        $this->theme->loadjs('javascript/search/search', $data);

        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        $data = $this->theme->renderControllers($data);
        
        $this->response->setOutput($this->theme->view('search/search', $data));
	}
}
