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

namespace App\Models\Front\Tool;

use App\Models\Model;
use Dais\Support\Image as LibraryImage;

class Image extends Model {
    
    /**
     *
     *	@param filename string
     *	@param width
     *	@param height
     *	@param type char [default, w, h]
     *				default = scale with white space,
     *				w = fill according to width,
     *				h = fill according to height
     *
     */
    public function resize($filename, $width, $height, $type = "") {
        if (!file_exists(Config::get('path.image') . $filename) || !is_file(Config::get('path.image') . $filename)) {
            return;
        }
    
        $info = pathinfo($filename);
        
        $extension = $info['extension'];
        
        $old_image = $filename;
        $new_image = 'cache/' . $this->encode->substr($filename, 0, $this->encode->strrpos($filename, '.')) . '-' . $width . 'x' . $height . $type . '.' . $extension;
        
        if (!file_exists(Config::get('path.image') . $new_image) || (filemtime(Config::get('path.image') . $old_image) > filemtime(Config::get('path.image') . $new_image))) {
            $path = '';
            
            $directories = explode('/', dirname(str_replace('../', '', $new_image)));
            
            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;
                
                if (!file_exists(Config::get('path.image') . $path)) {
                    @mkdir(Config::get('path.image') . $path, 0777);
                }
            }
            
            list($width_orig, $height_orig) = getimagesize(Config::get('path.image') . $old_image);
            
            if ($width_orig != $width || $height_orig != $height) {
                $image = new LibraryImage(Config::get('path.image') . $old_image);
                if ($type == 'f'):
                    if ($width_orig > $height_orig):
                        $type = 'h';
                    elseif ($width_orig < $height_orig):
                        $type = 'w';
                    else:
                        $type = NULL;
                    endif;
                endif;
                $image->resize($width, $height, $type);
                $image->save(Config::get('path.image') . $new_image, 80, 9);
            } else {
                copy(Config::get('path.image') . $old_image, Config::get('path.image') . $new_image);
            }
        }
        
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            return Config::get('config_ssl') . 'image/' . $new_image;
        } else {
            return Config::get('config_url') . 'image/' . $new_image;
        }
    }
}
