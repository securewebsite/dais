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

class Routes extends LibraryService {
    
    public function __construct(Container $app) {
        parent::__construct($app);
        
        $this->generate();
    }
    
    public function generate() {
        $db        = parent::$app['db'];
        $cache     = parent::$app['cache'];
        
        $key       = 'default.store.routes';
        $cachefile = $cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $db->query("
                SELECT * 
                FROM {$db->prefix}route 
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
            
            if (parent::$app['config_affiliate_allowed']):
                $query = $db->query("
                    SELECT * 
                    FROM {$db->prefix}affiliate_route 
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
            
            // if (parent::$app['config_profiles_allowed']):
            //     $query = $db->query("
            //         SELECT * 
            //         FROM {$db->prefix}vanity_route 
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
            $cache->set($key, $cachefile);
        endif;
        
        parent::$app['routes']        = $cachefile;
        parent::$app['custom_routes'] = $this->custom_routes();
    }
    
    public function custom_routes() {
        $routes = array();
        
        if (parent::$app->offsetExists('custom.routes')):
            $routes = parent::$app['custom.routes'];
        endif;
        
        return $routes;
    }
}
