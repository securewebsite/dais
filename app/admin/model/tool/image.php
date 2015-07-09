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

namespace Admin\Model\Tool;
use Dais\Engine\Model;
use Dais\Library\Image as NewImage;

class Image extends Model {
    public function resize($filename, $width, $height) {
        if (!file_exists(Config::get('path.image') . $filename) || !is_file(Config::get('path.image') . $filename)) {
            return;
        }
        
        $info = pathinfo($filename);
        
        $extension = $info['extension'];
        
        $old_image = $filename;
        $new_image = 'cache/' . Encode::substr($filename, 0, Encode::strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
        
        if (!file_exists(Config::get('path.image') . $new_image) || (filemtime(Config::get('path.image') . $old_image) > filemtime(Config::get('path.image') . $new_image))) {
            $path = '';
            
            $directories = explode('/', dirname(str_replace('../', '', $new_image)));
            
            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;
                
                if (!file_exists(Config::get('path.image') . $path)) {
                    @mkdir(Config::get('path.image') . $path, 0777);
                }
            }
            
            $image = new NewImage(Config::get('path.image') . $old_image);
            $image->resize($width, $height);
            $image->save(Config::get('path.image') . $new_image);
        }
        
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            return Config::get('https.public') . 'image/' . $new_image;
        } else {
            return Config::get('http.public') . 'image/' . $new_image;
        }
    }
}
