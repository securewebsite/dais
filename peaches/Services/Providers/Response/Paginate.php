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

class Paginate {
    
    private $total         = 0;
    private $page          = 1;
    private $limit         = 20;
    private $num_links     = 10;
    private $url           = '';
    private $text          = 'Showing {start} to {end} of {total} ({pages} {plural})';
    private $text_first    = '|&lt;';
    private $text_last     = '&gt;|';
    private $text_next     = '&gt;';
    private $text_prev     = '&lt;';
    private $style_links   = 'links';
    private $style_results = 'results';
    
    public function render() {
        $total = $this->total;
        
        $this->url = rawurldecode($this->url);
        
        if ($this->page < 1):
            $page = 1;
        else:
            $page = $this->page;
        endif;
        
        if (!(int)$this->limit):
            $limit = 10;
        else:
            $limit = $this->limit;
        endif;
        
        $num_links = $this->num_links;
        $num_pages = ceil($total / $limit);
        
        $output = '';
        
        if ($page > 1):
            $output.= ' <a href="' . str_replace('{page}', 1, $this->url) . '">' . $this->text_first . '</a> <a href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a> ';
        endif;
        
        if ($num_pages > 1):
            if ($num_pages <= $num_links):
                $start = 1;
                $end = $num_pages;
            else:
                $start = $page - floor($num_links / 2);
                $end = $page + floor($num_links / 2);
                
                if ($start < 1):
                    $end+= abs($start) + 1;
                    $start = 1;
                endif;
                
                if ($end > $num_pages):
                    $start-= ($end - $num_pages);
                    $end = $num_pages;
                endif;
            endif;
            
            if ($start > 1):
                $output.= ' .... ';
            endif;
            
            for ($i = $start; $i <= $end; $i++):
                if ($page == $i):
                    $output.= ' <b>' . $i . '</b> ';
                else:
                    $output.= ' <a href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a> ';
                endif;
            endfor;
            
            if ($end < $num_pages):
                $output.= ' .... ';
            endif;
        endif;
        
        if ($page < $num_pages):
            $output.= ' <a href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a> <a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</a> ';
        endif;
        
        $find = array(
            '{start}',
            '{end}',
            '{total}',
            '{pages}',
            '{plural}'
        );
        
        $replace = array(
            ($total) ? (($page - 1) * $limit) + 1 : 0,
            ((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
            $total,
            $num_pages,
            ($num_pages === (float)1) ? 'Page' : 'Pages'
        );
        
        return ($output ? '<div class="' . $this->style_links . '">' . $output . '</div>' : '') . '<div class="' . $this->style_results . '">' . str_replace($find, $replace, $this->text) . '</div>';
    }

    public function set($property, $value) {
        $this->{$property} = $value;
    }
}
