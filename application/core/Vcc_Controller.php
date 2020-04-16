<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vcc_Controller extends MX_Controller{
    protected $per_page = 20;

    public function __construct()
    {
        parent::__construct();
    }
    protected function message($msg, $status=false){
        return array(
            'success' => $status,
            'msg' => $msg
        );
    }
    public function logE($msg){
        logE($msg);
    }
    protected function get_config_upload($config=array()){
        $default_config = array();
        $default_config['upload_path'] = FCPATH . 'uploads/';
        $default_config['allowed_types'] = '*';
        $default_config['max_size'] = 1024 * 10;
        /*$default_config['image_width'] = 260;
        $default_config['image_height'] = 195;*/

        $default_config['file_ext_tolower'] = true;
        return array_merge($default_config, $config);
    }
    protected function save_file($file_field, $file_old, $config=array()){
        if($_FILES && isset($_FILES[$file_field]) && $_FILES[$file_field]['name']) {
            $upload_config = $this->get_config_upload($config);
            if($_FILES[$file_field]['tmp_name']){
                if(isset($upload_config['min_width']) || isset($upload_config['min_height']) || isset($upload_config['max_width']) || isset($upload_config['max_height'])){
                    //print_r($_FILES[$file_field]);exit();
                    list($width, $height) = getimagesize($_FILES[$file_field]['tmp_name']);
                    $msg_min = 'File ảnh của bạn kích thước nhỏ hơn quy định. Kích thước tối thiểu là: '.(isset($upload_config['min_width'])?$upload_config['min_width']:'*').'x'.(isset($upload_config['min_height'])?$upload_config['min_height']:'*').'px';
                    $msg_max = 'File ảnh của bạn kích thước lớn hơn quy định. Kích thước tối đa là: '.(isset($upload_config['max_width'])?$upload_config['max_width']:'*').'x'.(isset($upload_config['max_height'])?$upload_config['max_height']:'*').'px';
                    if(isset($upload_config['min_width']) && $width<$upload_config['min_width']){
                        return $this->message($msg_min);
                    }
                    if(isset($upload_config['min_height']) && $height<$upload_config['min_height']){
                        return $this->message($msg_min);
                    }
                    if(isset($upload_config['max_width']) && $width>$upload_config['max_width']){
                        return $this->message($msg_max);
                    }
                    if(isset($upload_config['max_height']) && $height>$upload_config['max_height']){
                        return $this->message($msg_max);
                    }
                }
            }

            $upload_config['file_name'] = $this->get_file_name($file_field);
            $upload_config['file_ext_tolower'] = true;

            if(!isset($this->upload)){
                $this->load->library('upload');
            }
            $this->upload->initialize($upload_config);

            if (!$this->upload->do_upload($file_field)) {
                $error = array('error' => $this->upload->display_errors());
                return $this->message($error['error'], false);
            } else {
                $data = $this->upload->data();
                $path_replace = str_replace('\\', '/', FCPATH);
                if($file_old && file_exists(FCPATH . $file_old)){
                    unlink(FCPATH . $file_old);
                }
                $thumbnail = str_replace($path_replace, '', $data['full_path']);

                $this->image_auto_rotate($data['full_path']);
                return $thumbnail;
            }
        }
        return '';
    }

    protected function image_auto_rotate($filename){
        $image_size = getimagesize($filename);
        if($image_size['mime']=='image/png'){
            $img = imagecreatefrompng($filename);
        }elseif($image_size['mime']=='image/jpeg'){
            $img = imagecreatefromjpeg($filename);
        }elseif($image_size['mime']=='image/gif'){
            $img = imagecreatefromgif($filename);
        }else{
            return false;
        }
        if(!function_exists('exif_read_data')) return false;
        $exif = @exif_read_data($filename, null, true);
        if ($img && $exif && isset($exif['IFD0']['Orientation']))
        {
            $ort = $exif['IFD0']['Orientation'];

            if ($ort == 6 || $ort == 5){
                $img = imagerotate($img, 270, null);
            }
            if ($ort == 3 || $ort == 4){
                $img = imagerotate($img, 180, null);
            }
            if ($ort == 8 || $ort == 7){
                $img = imagerotate($img, 90, null);
            }

            if ($ort == 5 || $ort == 4 || $ort == 7){
                imageflip($img, IMG_FLIP_HORIZONTAL);
            }
            if($image_size['mime']=='image/png'){
                header('Content-Type: '.$image_size['mime']);
                imagepng($img, $filename);
            }elseif($image_size['mime']=='image/jpeg'){
                header('Content-Type: '.$image_size['mime']);
                imagejpeg($img, $filename);
            }elseif($image_size['mime']=='image/gif'){
                header('Content-Type: '.$image_size['mime']);
                imagegif($img, $filename);
            }else{
                return false;
            }
        }
        return false;
    }
    protected function get_sizes(){
        return array();
    }
    protected function resize_thumbnail_upload($source_file){
        $sizes = $this->get_sizes();
        if(!$sizes) return null;
        $info = pathinfo($source_file);
        $file_type_image = array('png','jpe','jpeg','jpg','gif','bmp','ico','tiff','tif','svg','svgz');
        if(in_array( $info['extension'], $file_type_image)===false) return null;
        $resize_images = array();

        $path_replace = str_replace('\\', '/', FCPATH);
        foreach($sizes as $s){
            $new_path = $info['dirname'] . '/' . $info['filename'].'-'.$s['w'].'x'.$s['h'].'.'.$info['extension'];
            $this->resize_crop_image($s['w'], $s['h'], $source_file, $new_path, 100);
            $new_path = str_replace('\\', '/', $new_path);
            if(file_exists($new_path)){
                $resize_images[] = str_replace($path_replace, '/', $new_path);
            }
        }
        return $resize_images;
    }

    //resize and crop image by center
    protected function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        switch($mime){
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if($width_new > $width){
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        }else{
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $dst_dir, $quality);

        if($dst_img)imagedestroy($dst_img);
        if($src_img)imagedestroy($src_img);
    }
    protected function save_files($file_field, $images=array(), $config=array()){
        if ($_FILES && isset($_FILES[$file_field]) && $_FILES[$file_field]['name'][0]) {
            $default_config = $this->get_config_upload($config);
            $files = $_FILES;
            $cpt = count($_FILES[$file_field]['name']);
            $error = '';
            for($i=0; $i<$cpt; $i++){
                $_FILES[$file_field]['name']= $files[$file_field]['name'][$i];
                $_FILES[$file_field]['type']= $files[$file_field]['type'][$i];
                $_FILES[$file_field]['tmp_name']= $files[$file_field]['tmp_name'][$i];
                $_FILES[$file_field]['error']= $files[$file_field]['error'][$i];
                $_FILES[$file_field]['size']= $files[$file_field]['size'][$i];

                $default_config['file_name'] = $this->get_file_name($file_field);
                if(!isset($this->upload)){
                    $this->load->library('upload');
                }
                $this->upload->initialize($default_config);

                if (!$this->upload->do_upload($file_field)) {
                    $this->logE($this->upload->display_errors());
                    $error = array('error' => $this->upload->display_errors());
                    break;
                } else {
                    $data = $this->upload->data();
                    $path_replace = str_replace('\\', '/', FCPATH);
                    $images[] = str_replace($path_replace, '', $data['full_path']);
                }
            }
            if($error){
                return $this->message($error['error'], false);
            }
            return $images;
        } else {
            return $images;
        }
    }
    protected function get_file_name($file_field){
        $path_info = pathinfo($_FILES[$file_field]['name']);
        $new_name = url_title(sanitizeTitle($path_info['filename']), '-', true) . '-' . time();
        return str_replace($path_info['filename'], $new_name, $path_info['basename']);
    }
    protected function get_user_agent(){
        return $_SERVER['HTTP_USER_AGENT'];
    }
    protected function get_client_ip(){
        $ipAddress = null;
        if (getenv('HTTP_X_CLIENT_RIP')) $ipAddress = getenv('HTTP_X_CLIENT_RIP');
        else if (getenv('HTTP_CLIENT_IP')) $ipAddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR')) $ipAddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED')) $ipAddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR')) $ipAddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED')) $ipAddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR')) $ipAddress = getenv('REMOTE_ADDR');
        else $ipAddress = 'UNKNOWN';
        return $ipAddress;
    }
}