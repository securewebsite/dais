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

namespace Dais\Services\Providers;

class Routes {
    
    private $routes = [];
    private $custom_routes = [];
    private $raw_routes = [];

    public function __construct() {
        $this->generate();
    }

    public function getRoutes() {
        return $this->routes;
    }

    public function getCustomRoutes() {
        return $this->custom_routes;
    }
    
    protected function generate() {
        $key       = 'default.store.routes';
        $cachefile = \Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = \DB::query("
                SELECT * 
                FROM " . \DB::p()->prefix . "route 
                GROUP BY route, route_id
            ");
            
            $routes = array();
            
            foreach ($query->rows as $route):
                if (!array_key_exists($route['route'], $routes)):
                    $routes[$route['route']][] = array(
                        'query' => $route['query'],
                        'slug'  => $route['slug']
                    );
                else:
                    $items = array(
                        'query' => $route['query'],
                        'slug'  => $route['slug']
                    );
                    
                    $routes[$route['route']][] = $items;
                endif;
            endforeach;

            /**
             * Vanity routes are set up for affiliates
             * so that we can properly route visitors.
             * This is only set IF affiliates are allowed.
             */
            
            if (\Config::get('config_affiliate_allowed')):
                $query = \DB::query("
                    SELECT * 
                    FROM " . \DB::p()->prefix . "affiliate_route 
                    GROUP BY route, route_id
                ");
                
                foreach ($query->rows as $affiliate):
                    if (!array_key_exists($affiliate['route'], $routes)):
                        $routes[$affiliate['route']][] = array(
                            'query' => $affiliate['query'],
                            'slug'  => $affiliate['slug']
                        );
                    else:
                        $items = array(
                            'query' => $affiliate['query'],
                            'slug'  => $affiliate['slug']
                        );
                        
                        $routes[$affiliate['route']][] = $items;
                    endif;
                endforeach;
            endif; // End affiliate routes

            /**
             * Vanity routes are set up for social profiles
             * so that we can properly route visitors.
             * This is only set IF profiles are allowed.
             * FUTURE USE!
             */
            
            // if (\Config::get('config_profiles_allowed')):
            //     $query = \DB::query("
            //         SELECT * 
            //         FROM " . \DB::p()->prefix . "vanity_route 
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
            \Cache::set($key, $cachefile);
        endif;
        
        $this->routes        = $cachefile;
        $this->custom_routes = $this->custom_routes();
    }
    
    protected function custom_routes() {
        $key       = 'custom.routes';
        $cachefile = \Cache::get($key);

        if (is_bool($cachefile)):
            $query = \DB::query("
                SELECT route, slug 
                FROM " . \DB::p()->prefix . "custom_route
            ");

            $routes = array();

            foreach($query->rows as $row):
                $routes[$row['slug']] = $row['route'];
            endforeach;

            $cachefile = $routes;
            \Cache::set($key, $cachefile);
        
        endif;

        return $cachefile;
    }

    public function allRoutes() {
        $routes = [];

        $key       = 'all.routes';
        $cachefile = \Cache::get($key);

        if (is_bool($cachefile)):
            $query = \DB::query("
                SELECT * 
                FROM " . \DB::prefix() . "affiliate_route 
                UNION 
                SELECT * 
                FROM " . \DB::prefix() . "route 
                UNION 
                SELECT * 
                FROM " . \DB::prefix() . "vanity_route
            ");

            $base = $query->rows;

            $query = \DB::query("
                SELECT * 
                FROM " . \DB::prefix() . "custom_route
            ");

            foreach($query->rows as $row):
                unset($row['route_id']);
                $routes[] = $row;
            endforeach;

            foreach($base as $row):
                unset($row['route_id']);
                $routes[] = $row;
            endforeach;

            $cachefile = $routes;
            \Cache::set($key, $cachefile);

        endif;

        return $cachefile;
    }
}
