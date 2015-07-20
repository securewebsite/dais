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

namespace Dais\Services\Providers\Response;

class Routes {
    
    private $routes        = [];
    private $custom_routes = [];
    private $slugs         = [];

    public function __construct() {
        $this->generate();
    }

    public function getRoutes() {
        return $this->routes;
    }

    public function getCustomRoutes() {
        return $this->custom_routes;
    }

    public function getSlugs() {
        return $this->slugs;
    }
    
    protected function generate() {
        $key       = 'default.store.routes';
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
                SELECT * 
                FROM " . DB::prefix() . "route 
                GROUP BY route, route_id
            ");
            
            $routes = [];
            
            foreach ($query->rows as $route):
                $id = preg_replace("/(.*?):(.*)/", "$2", $route['query']);
                $routes[$route['route']][$id] = $route['slug'];
            endforeach;

            /**
             * Vanity routes are set up for affiliates
             * so that we can properly route visitors.
             * This is only set IF affiliates are allowed.
             */
            
            if (Config::get('config_affiliate_allowed')):
                $query = DB::query("
                    SELECT * 
                    FROM " . DB::prefix() . "affiliate_route 
                    GROUP BY route, route_id
                ");
                
                foreach ($query->rows as $affiliate):
                    $id = preg_replace("/(.*?):(.*)/", "$2", $affiliate['query']);
                    $routes[$affiliate['route']][$id] = $affiliate['slug'];
                endforeach;
            endif; // End affiliate routes

            /**
             * Vanity routes are set up for social profiles
             * so that we can properly route visitors.
             * This is only set IF profiles are allowed.
             * FUTURE USE!
             */
            
            // if (Config::get('config_profiles_allowed')):
            //     $query = DB::query("
            //         SELECT * 
            //         FROM " . DB::prefix() . "vanity_route 
            //         GROUP BY route, route_id
            //     ");
                
            //     foreach ($query->rows as $vanity):
            //         if (!array_key_exists($vanity['route'], $routes)):
            //             $routes[$vanity['route']][] = array(
            //                 'query' => $vanity['query'],
            //                 'slug'  => $vanity['slug']
            //             );
            //         else:
            //             $items = array(
            //                 'query' => $vanity['query'],
            //                 'slug'  => $vanity['slug']
            //             );
                        
            //             $routes[$vanity['route']][] = $items;
            //         endif;
            //     endforeach;
            // endif; // End vanity routes
            
            $cachefile = $routes;
            Cache::set($key, $cachefile);
        endif;
        
        $this->routes        = $cachefile;
        $this->custom_routes = $this->custom_routes();
        $this->slugs = $this->generate_slugs();
    }
    
    protected function custom_routes() {
        $key       = 'custom.routes';
        $cachefile = Cache::get($key);

        if (is_bool($cachefile)):
            $query = DB::query("
                SELECT route, slug 
                FROM " . DB::prefix() . "custom_route
            ");

            $routes = array();

            foreach($query->rows as $row):
                $routes[$row['slug']] = $row['route'];
            endforeach;

            $cachefile = $routes;
            Cache::set($key, $cachefile);
        
        endif;

        return $cachefile;
    }

    protected function generate_slugs() {
        return [
            'catalog/category'          => $this->categories(),
            'catalog/manufacturer/info' => $this->manufacturers(),
            'catalog/product'           => $this->products(),
            'content/category'          => $this->blog(),
            'content/post'              => $this->posts(),
            'content/page'              => $this->pages(),
            'event/page'                => $this->events(),
            'content/home'              => $this->affiliate(),
        ];
    }

    public function allRoutes() {
        $routes = [];

        $key       = 'all.routes';
        $cachefile = Cache::get($key);

        if (is_bool($cachefile)):
            $query = DB::query("
                SELECT * 
                FROM " . DB::prefix() . "affiliate_route 
                UNION 
                SELECT * 
                FROM " . DB::prefix() . "route 
                UNION 
                SELECT * 
                FROM " . DB::prefix() . "vanity_route
            ");

            foreach($query->rows as $row):
                unset($row['route_id']);
                $routes[] = $row;
            endforeach;

            $cachefile = $routes;
            Cache::set($key, $cachefile);

        endif;

        return $cachefile;
    }

    public function categories() {
        $routes     = $this->routes['catalog/category'];
        $categories = [];

        $key = 'category.route.slugs';
        $cachefile = Cache::get($key);

        if (is_bool($cachefile)):
            // top level categories
            $query_a = DB::query("
                SELECT category_id 
                FROM " . DB::prefix() . "category 
                WHERE parent_id = 0 
                AND status >= 1
            ");

            if ($query_a->num_rows):
                foreach($query_a->rows as $row_a):
                    $a              = $row_a['category_id'];
                    $categories[$a] = $routes[$a];

                    // 2nd level categories
                    $query_b = DB::query("
                        SELECT category_id 
                        FROM " . DB::prefix() . "category 
                        WHERE parent_id = '" . (int)$a . "' 
                        AND status >= 1
                    ");

                    if ($query_b->num_rows):
                        foreach($query_b->rows as $row_b):
                            $id_b = $row_b['category_id'];
                            $b    = $a . '_' . $id_b;

                            $route_b = $routes[$a] . '/' . $routes[$id_b];

                            $categories[$b] = $route_b;

                            // third level categories
                            $query_c = DB::query("
                                SELECT category_id 
                                FROM " . DB::prefix() . "category 
                                WHERE parent_id = '" . (int)$id_b . "' 
                                AND status >= 1
                            ");

                            if ($query_c->num_rows):
                                foreach($query_c->rows as $row_c):
                                    $id_c = $row_c['category_id'];
                                    $c = $b . '_' . $id_c;

                                    $route_c = $route_b . '/' . $routes[$id_c];

                                    $categories[$c] = $route_c;

                                endforeach;
                            endif;
                        endforeach;
                    endif;
                endforeach;

                $cachefile = $categories;
                Cache::set($key, $cachefile);
            endif;
        endif;

        return $this->format($cachefile);
    }

    public function manufacturers() {
        return $this->format($this->routes['catalog/manufacturer/info']);
    }

    public function blog() {
        $routes = $this->routes['content/category'];
        $categories = [];

        $key = 'blog.route.slugs';
        $cachefile = Cache::get($key);

        if (is_bool($cachefile)):
            // top level categories
            $query_a = DB::query("
                SELECT category_id 
                FROM " . DB::prefix() . "blog_category 
                WHERE parent_id = 0 
                AND status >= 1
            ");

            if ($query_a->num_rows):
                foreach($query_a->rows as $row_a):
                    $a              = $row_a['category_id'];
                    $categories[$a] = $routes[$a];

                    // 2nd level categories
                    $query_b = DB::query("
                        SELECT category_id 
                        FROM " . DB::prefix() . "blog_category 
                        WHERE parent_id = '" . (int)$a . "' 
                        AND status >= 1
                    ");

                    if ($query_b->num_rows):
                        foreach($query_b->rows as $row_b):
                            $id_b = $row_b['category_id'];
                            $b    = $a . '_' . $id_b;

                            $route_b = $routes[$a] . '/' . $routes[$id_b];

                            $categories[$b] = $route_b;

                            // third level categories
                            $query_c = DB::query("
                                SELECT category_id 
                                FROM " . DB::prefix() . "blog_category 
                                WHERE parent_id = '" . (int)$id_b . "' 
                                AND status >= 1
                            ");

                            if ($query_c->num_rows):
                                foreach($query_c->rows as $row_c):
                                    $id_c = $row_c['category_id'];
                                    $c = $b . '_' . $id_c;

                                    $route_c = $route_b . '/' . $routes[$id_c];

                                    $categories[$c] = $route_c;

                                endforeach;
                            endif;
                        endforeach;
                    endif;
                endforeach;

                $cachefile = $this->format($categories);
                Cache::set($key, $cachefile);
            endif;
        endif;

        return $cachefile;
    }

    public function products() {
        return $this->format($this->routes['catalog/product']);
    }

    public function posts() {
        return $this->format($this->routes['content/post']);
    }

    public function pages() {
        return $this->format($this->routes['content/page']);
    }

    public function events() {
        return $this->format($this->routes['event/page']);
    }

    protected function affiliate() {
        return $this->format($this->routes['content/home']);
    }

    public function vanity() {

    }

    protected function format(array $links) {
        $segments = [];

        foreach($links as $key => $link):
            $parts = explode('/', $link);
            
            foreach($parts as $k => $part):
                if (Config::get('config_ucfirst')):
                    $parts[$k] = Naming::cap_slug($part);
                else:
                    $parts[$k] = strtolower($part);
                endif;
            endforeach;

            if (Config::get('config_top_level')):
                $segments[$key] = array_pop($parts);
            else:
                $segments[$key] = implode('/', $parts);
            endif;
        endforeach;

        return $segments;
    }
}
