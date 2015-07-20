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
		$data = Theme::language('search/search');

		JS::register('storage.min', 'jquery.min');

		Breadcrumb::add('lang_heading_title', 'search/search');

		if (isset(Request::p()->post['search'])):
			$search = Request::p()->post['search'];
		else:
			$search = false;
		endif;

		if (isset(Request::p()->get['page'])):
            $page = Request::p()->get['page'];
        else:
            $page = 1;
        endif;

        $limit = Config::get('config_catalog_limit');
        
        $filter = array(
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );
        
        if ($search):
            Theme::setTitle(Lang::get('lang_heading_title') . ' - ' . $search);
            $data['heading_title'] = Lang::get('lang_heading_title') . ': ' . $search;
            $data['search'] = $search;
        else:
        	Theme::setTitle(Lang::get('lang_heading_title'));
            $data['heading_title'] = Lang::get('lang_heading_title');
            $data['search'] = '';
        endif;

        $data['action'] = Url::link('search/search');

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
                                    'url'   => Url::link('catalog/product', 'product_id=' . $value['product_id'], 'SSL'),
                                    'type'  => Lang::get('lang_product')
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
                                    'url'   => Url::link('catalog/category', 'path=' . $path, 'SSL'),
                                    'type'  => Lang::get('lang_product_category')
                                );
                                $data['results'][] = $item;
                            endforeach;
                            break;
                        case 'posts':
                            foreach ($result as $value):
                                $item = array(
                                    'title' => $value['name'],
                                    'text'  => $value['description'],
                                    'url'   => Url::link('content/post', 'post_id=' . $value['post_id'], 'SSL'),
                                    'type'  => Lang::get('lang_article')
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
                                    'url'   => Url::link('content/category', 'bpath=' . $path, 'SSL'),
                                    'type'  => Lang::get('lang_blog_category')
                                );
                                $data['results'][] = $item;
                            endforeach;
                            break;
                        case 'pages':
                           foreach ($result as $value):
                                $url = ($value['event_id'] > 0) ? Url::link('event/page', 'event_page_id=' . $value['page_id'], 'SSL') : Url::link('content/page', 'page_id=' . $value['page_id'], 'SSL');
                                $item = array(
                                    'title' => $value['title'],
                                    'text'  => $value['description'],
                                    'url'   => $url,
                                    'type'  => Lang::get('lang_page')
                                );
                                $data['results'][] = $item;
                            endforeach;
                            break;
                        case 'manufacturers':
                            foreach ($result as $value):
                                $item = array(
                                    'title' => $value['name'],
                                    'text'  => '',
                                    'url'   => Url::link('catalog/manufacturer/info', 'manufacturer_id=' . $value['manufacturer_id'], 'SSL'),
                                    'type'  => Lang::get('lang_manufacturer')
                                );
                                $data['results'][] = $item;
                            endforeach;
                            break;
                    endswitch;
                endforeach;
            endif;

        endif;

        $data['pagination'] = Theme::paginate(
            $result_total, 
            $page, 
            Config::get('config_catalog_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('search/search', 'search=' . $search . '&page={page}')
        );
        
        Theme::loadjs('javascript/search/search', $data);

        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('search/search', $data));
	}
}
