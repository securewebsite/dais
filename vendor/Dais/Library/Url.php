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

class Url extends LibraryService {
    private $domain;
    private $ssl;
    
    public function __construct($domain, $ssl = '', Container $app) {
        parent::__construct($app);
        
        $this->domain = $domain;
        $this->ssl    = $ssl;
    }
    
    public function external($href, $text, $rel = 'nofollow', $target = '_blank') {
        $link = '<a href="' . $href . '" title="' . $text . '" rel="' . $rel . '" target="' . $target . '">' . $text . '</a>';
        
        return $link;
    }
    
    public function link($route, $args = '', $secure = false) {
        if (!$secure):
            $url = $this->domain;
        else:
            $url = $this->ssl;
        endif;
        
        $url.= 'index.php?route=' . $route;
        
        $urlargs = array();
        
        if ($args):
            if (parent::$app['active.fascade'] === FRONT_FASCADE):
                
                // Catalog access only
                $cache = parent::$app['cache'];
                parse_str($args, $urlargs);
                if (array_key_exists('product_id', $urlargs)):
                    
                    // Product URLS
                    if (!parent::$app['config_top_level']):
                        if (!array_key_exists('path', $urlargs)):
                            $key = 'product.paths.' . md5(serialize($urlargs));
                            $urlargs['path'] = $cache->get($key);
                            if (is_bool($urlargs['path'])):
                                $path            = $this->build_category_paths((int)$urlargs['product_id']);
                                $urlargs['path'] = $path;
                                $cache->set($key, $urlargs['path']);
                            endif;
                        endif;
                    else:
                        if (array_key_exists('path', $urlargs)):
                            unset($urlargs['path']);
                        endif;
                    endif;
                elseif (array_key_exists('post_id', $urlargs)):
                    
                    // Blog post URLS
                    if (!parent::$app['config_top_level']):
                        if (!array_key_exists('bpath', $urlargs)):
                            $key              = 'blog.category.paths.' . md5(serialize($urlargs));
                            $urlargs['bpath'] = $cache->get($key);
                            if (is_bool($urlargs['bpath'])):
                                $path             = $this->build_blog_category_paths((int)$urlargs['post_id']);
                                $urlargs['bpath'] = $path;
                                $cache->set($key, $urlargs['bpath']);
                            endif;
                        endif;
                    else:
                        if (array_key_exists('bpath', $urlargs)):
                            unset($urlargs['bpath']);
                        endif;
                    endif;
                else:
                    if (parent::$app['config_top_level']):
                        if (array_key_exists('path', $urlargs)):
                            
                            // Product categories
                            $paths = explode('_', $urlargs['path']);
                            $urlargs['path'] = array_pop($paths);
                        endif;
                        if (array_key_exists('bpath', $urlargs)):
                            
                            // Blog categories
                            $bpaths = explode('_', $urlargs['bpath']);
                            $urlargs['bpath'] = array_pop($bpaths);
                        endif;
                    endif;
                endif;
                ksort($urlargs);
                $args = http_build_query($urlargs);
            endif;
            $url.= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
        endif;
        
        if (parent::$app['active.fascade'] === FRONT_FASCADE):
            // Catalog access
            return $this->rewrite($url);
        elseif (parent::$app['active.fascade'] === INSTALL_FASCADE):
            // Installer access
            return $this->install_rewrite($url);
        else:
            return $url;
        endif;
    }
    
    /*
    Moved the rewrite function from the router to the url class in order to
    simplify and make the rewiter more logical.
    
    Routing is routing and url creation is url creation, no need to mix the two.
    */
    private function rewrite($link) {
        $ucfirst = parent::$app['config_ucfirst'];
        $slugs   = parent::$app['routes'];
        $custom  = parent::$app['custom_routes'];
        
        $url_info = parse_url(str_replace('&amp;', '&', $link));
        $url      = '';
        $route    = array();
        parse_str($url_info['query'], $route);
        
        // Some standard routes
        foreach ($custom as $key => $value):
            foreach ($route as $k => $v):
                if (isset($route['route'])):
                    switch ($route['route']):
                        case $value:
                            $url.= '/' . $key;
                            break;

                        case 'account/returns/insert':
                            // special case for return insert
                            if (isset($route['order_id']) && isset($route['product_id'])):
                                $url.= '/' . $route['route'] . '&order_id=' . $route['order_id'] . '&product_id=' . $route['product_id'];
                                unset($route[$k]);
                                unset($route['order_id']);
                                unset($route['product_id']);
                                unset($route['path']);
                            endif;
                            break;
                    endswitch;
                endif;
            endforeach;
        endforeach;
        
        // Rewrite our Slug Urls
        foreach ($route as $key => $value):
            foreach ($custom as $k => $v):
                if ($route['route'] === $v):
                    unset($route[$v]);
                endif;
            endforeach;

            switch ($route['route']):
                case 'search/tag' && $key === 'tag':
                    $url .= '/' . $route['route'] . '/' . urlencode(trim($route['tag']));
                    unset($route[$key]);
                    unset($route['tag']);
                    break;

                case 'search/search' && $key === 'search':
                    $url .= '/search/' . urlencode(trim($route['search']));
                    unset($route[$key]);
                    unset($route['search']);
                    break;

                case 'catalog/product' && $key === 'path':
                    $array = $slugs['catalog/category'];
                    $categories = explode('_', $value);
                    foreach ($categories as $category):
                        $slug = 'category_id:' . $category;
                        foreach ($array as $k => $v):
                            if (in_array($slug, $v)):
                                if ($ucfirst):
                                    $url.= '/' . $this->cap_slug($v['slug']);
                                else:
                                    $url.= '/' . $v['slug'];
                                endif;
                            endif;
                        endforeach;
                        unset($route[$key]);
                        unset($slug);
                    endforeach;
                    unset($array);
                    break;

                case 'catalog/category' && $key === 'path':
                    $array = $slugs['catalog/category'];
                    $categories = explode('_', $value);
                    foreach ($categories as $category):
                        $slug = 'category_id:' . $category;
                        foreach ($array as $k => $v):
                            if (in_array($slug, $v)):
                                if ($ucfirst):
                                    $url.= '/' . $this->cap_slug($v['slug']);
                                else:
                                    $url.= '/' . $v['slug'];
                                endif;
                            endif;
                        endforeach;
                        unset($route[$key]);
                        unset($slug);
                    endforeach;
                    unset($array);
                    break;

                case 'catalog/product' && $key === 'product_id':
                    $array = $slugs['catalog/product'];
                    $slug = 'product_id:' . $value;
                    foreach ($array as $k => $v):
                        if (in_array($slug, $v)):
                            if ($ucfirst):
                                $url.= '/' . $this->cap_slug($v['slug']);
                            else:
                                $url.= '/' . $v['slug'];
                            endif;
                        endif;
                    endforeach;
                    unset($route[$key]);
                    unset($slug);
                    unset($array);
                    break;

                case ('catalog/manufacturer/info' || 'catalog/product') && $key === 'manufacturer_id':
                    $array = $slugs['catalog/manufacturer/info'];
                    $slug = 'manufacturer_id:' . $value;
                    foreach ($array as $k => $v):
                        if (in_array($slug, $v)):
                            if ($ucfirst):
                                $url.= '/' . $this->cap_slug($v['slug']);
                            else:
                                $url.= '/' . $v['slug'];
                            endif;
                        endif;
                    endforeach;
                    unset($route[$key]);
                    unset($slug);
                    unset($array);
                    break;

                case ('content/page' && $route['route'] !== 'content/page/info') && $key === 'page_id':
                    $array = $slugs['content/page'];
                    $slug = 'page_id:' . $value;
                    foreach ($array as $k => $v):
                        if (in_array($slug, $v)):
                            if ($ucfirst):
                                $url.= '/' . $this->cap_slug($v['slug']);
                            else:
                                $url.= '/' . $v['slug'];
                            endif;
                        endif;
                    endforeach;
                    unset($route[$key]);
                    unset($slug);
                    unset($array);
                    break;

                case 'content/page/info' && $key === 'page_id':
                    $array = $slugs['content/page'];
                    $slug = 'page_id:' . $value;
                    foreach ($array as $k => $v):
                        if (in_array($slug, $v)):
                            if ($ucfirst):
                                $url.= '/content/page/info/' . $this->cap_slug($v['slug']);
                            else:
                                $url.= '/content/page/info/' . $v['slug'];
                            endif;
                        endif;
                    endforeach;
                    unset($route[$key]);
                    unset($slug);
                    unset($array);
                    break;

                case 'content/category' && $key == 'bpath':
                    $array = $slugs['content/category'];
                    $categories = explode('_', $value);
                    foreach ($categories as $category):
                        $slug = 'blog_category_id:' . $category;
                        foreach ($array as $k => $v):
                            if (in_array($slug, $v)):
                                if ($ucfirst):
                                    $url.= '/' . $this->cap_slug($v['slug']);
                                else:
                                    $url.= '/' . $v['slug'];
                                endif;
                            endif;
                        endforeach;
                        unset($route[$key]);
                        unset($slug);
                    endforeach;
                    unset($array);
                    break;

                case 'content/post' && $key === 'post_id':
                    $array = $slugs['content/post'];
                    $slug = 'post_id:' . $value;
                    foreach ($array as $k => $v):
                        if (in_array($slug, $v)):
                            if ($ucfirst):
                                $url.= '/' . $this->cap_slug($v['slug']);
                            else:
                                $url.= '/' . $v['slug'];
                            endif;
                        endif;
                    endforeach;
                    unset($route[$key]);
                    unset($slug);
                    unset($array);
                    break;

                case ('content/home' || 'shop/home') && $key === 'affiliate_id':
                    if ($route['route'] === 'content/home'):
                        $array = $slugs['content/home'];
                    else:
                        $array = $slugs['shop/home'];
                    endif;
                    $slug = 'affiliate_id:' . $value;
                    foreach ($array as $k => $v):
                        if (in_array($slug, $v)):
                            if ($ucfirst):
                                $url.= '/' . $this->cap_slug($v['slug']);
                            else:
                                $url.= '/' . $v['slug'];
                            endif;
                        endif;
                    endforeach;
                    unset($route[$key]);
                    unset($slug);
                    unset($array);
                    break;

            endswitch;
        endforeach;
        
        if ($url):
            unset($route['route']);
            $query = '';
            if ($route):
                foreach ($route as $key => $value):
                    $query.= '&' . $key . '=' . $value;
                endforeach;
                
                if ($query):
                    $query = '?' . trim($query, '&');
                endif;
            endif;
            
            if (parent::$app['theme']->style === 'shop'):
                $url = str_replace('/shop', '', $url);
            else:
                if (!parent::$app['config_home_page']):
                    $url = str_replace('/blog', '', $url);
                endif;
            endif;
            
            return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
        else:
            if (parent::$app['theme']->style === 'shop'):
                return preg_replace('/(index\.php\?route=|shop\/home)/', '', $link);
            else:
                return preg_replace('/(index\.php\?route=|content\/home)/', '', $link);
            endif;
        endif;
    }
    
    /*
    Rewriter for installer
    */
    private function install_rewrite($link) {
        $url_info = parse_url(str_replace('&amp;', '&', $link));
        $url = '';
        $route = array();
        parse_str($url_info['query'], $route);
        
        foreach ($route as $key => $value):
            if (isset($route['route'])):
                $url.= '/' . $route['route'];
                unset($route[$key]);
            endif;
        endforeach;
        
        if ($url):
            unset($route['route']);
            $query = '';
            if ($route):
                foreach ($route as $key => $value):
                    $query.= '&' . rawurlencode($key) . '=' . rawurlencode($value);
                endforeach;
                
                if ($query):
                    $query = '?' . trim($query, '&');
                endif;
            endif;
            return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
        endif;
    }
    
    /*
    This function allows the dynamic addition of category paths for all urls
    when the top-level flag is unset.
    
    No changes need to be made calls to url->link()
    */
    private function build_category_paths($product_id) {
        $theme = parent::$app['theme'];
        
        $theme->model('catalog/product');
        
        $model = parent::$app['model_catalog_product'];
        $category_id = $model->getProductParentCategory($product_id);
        $path = $category_id;
        $categories = $model->getCategories($product_id);
        
        foreach ($categories as $category):
            if ($category['category_id'] != $category_id):
                $path.= '_' . (int)$category['category_id'];
            endif;
        endforeach;
        
        return $path;
    }
    
    private function build_blog_category_paths($post_id) {
        $theme = parent::$app['theme'];
        
        $theme->model('content/post');
        
        $model = parent::$app['model_content_post'];
        $category_id = $model->getPostParentCategory($post_id);
        $path = $category_id;
        $categories = $model->getCategories($post_id);
        
        foreach ($categories as $category):
            if ($category['category_id'] != $category_id):
                $path.= '_' . (int)$category['category_id'];
            endif;
        endforeach;
        
        return $path;
    }
    
    /*
    This function was created to remove special chars and sanitize foreign letters
    for route slug creation for entry into the database.
    call ::  $this->url->sanitize ($string)
    */
    
    public function sanitize_name($string) {
        $normalize = array(
            'Š' => 'S',
            'š' => 's',
            'Ð' => 'Dj',
            'Ž' => 'Z',
            'ž' => 'z',
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Þ' => 'B',
            'ß' => 'Ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ý' => 'y',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y',
            'ƒ' => 'f',
            '"&#xA0;' => "'"
        );
        
        $string = str_replace(', ', ',', $string);
        $string = str_replace(',', ', ', $string);
        $string = str_replace('. ', '.', $string);
        $string = str_replace('.', '. ', $string);
        $string = str_replace('/ ', '/', $string);
        $string = str_replace(' /', '/', $string);
        $string = str_replace('/', ' / ', $string);
        
        $string = ucwords(strtolower($string));
        
        return strtr($string, $normalize);
    }
    
    /*
    This method was created to automate the building of route slugs via
    the dashboard slug() method. Will take the passed in name of product,
    category, manufacturer or page and return a lowercase hyphenated and
    sanitized slug.
    
    Example:
    
    Product Name: Apple iPhone 5 & WaterProof Case
    Returned Slug: apple-iphone-5-and-waterproof-case
    
    call :: $this->url->build_slug($string)
    */
    
    public function build_slug($string) {
        $string = $this->sanitize_name($string);
        
        $string = str_replace('&amp', '&', $string);
        $string = str_replace('&quot', '"', $string);
        $string = str_replace('&', '-and-', $string);
        $string = str_replace(' / ', ' ', $string);
        $string = str_replace('/', ' ', $string);
        
        // convert measurement quotes
        $string = str_replace('"', '-inch-', $string);
        $string = str_replace("'", "-foot-", $string);
        
        // punctuation
        $string = trim(preg_replace('/[^\w\d_ -]/si', '', $string));
        $string = str_replace(' - ', '-', $string);
        $string = str_replace(' ', '-', $string);
        $string = str_replace('--', '-', $string);
        $string = str_replace('-------', '-', $string);
        
        return strtolower($string);
    }
    
    /*
    This method is used in conjunction with the config_ucfirst
    configuration variable to rewrite urls to capitalize the
    first letter of each word in the slug for seo.
    
    Example:
    
    Product Slug: apple-iphone-5-and-waterproof-case
    New Url Slug: Apple-Iphone-5-and-Waterproof-Case
    
    call :: $this->url->cap_slug($slug)
    */
    
    public function cap_slug($word) {
        $keyword = null;
        if (substr_count($word, '-') > 0):
            $arr = array();
            $data = explode('-', $word);
            foreach ($data as $key):
                if (!empty($key)):
                    $arr[] = ucfirst(strtolower($key));
                endif;
            endforeach;
            $keyword = implode('-', $arr);
        else:
            $keyword = ucfirst(strtolower(trim($word, '-')));
        endif;
        $keyword = str_replace('And', 'and', $keyword);
        $keyword = str_replace('For', 'for', $keyword);
        $keyword = str_replace('Or', 'or', $keyword);
        return $keyword;
    }
}
