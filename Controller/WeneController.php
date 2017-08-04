<?php
    class WeneController extends AppController {

        
    public $imgDir;
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'empty';
        $this->Auth->allow();
        $this->imgDir =  WWW_ROOT.'wene' . DS;
            
    }

    
    
    public function index($query = null) {die();}
   
    
    
    
    
    

    private function _stage1($section, $imageName){
        if (empty($section) || empty($imageName)){
                        throw new NotFoundException('Error!');
        }
    }
    
    private function _stage2($section){
        if ($section != 'hunermend' && $section != 'berhem' && $section != 'endam'){
            throw new NotFoundException('Error!');
        }
    }
    
    private function _stage3($section, $imageName){
        
        $imageDir = $this->imgDir . $section . DS;
        $imageFullPath = $imageDir . $imageName;
        
        if (!fileExistsInPath($imageFullPath)){
            $imageFullPath = $imageDir . $section . '-nenas.jpg';
        }
        
        return $imageFullPath;
    }
    
//    private function _stage4($image_c, $properties = null){
//        
//    }
    
    private function _stage4($image, $scale, $dimension){
            
            $width = $height = $dimension;
            $start_width = $start_height = 0;
            list($imagewidth, $imageheight, $imageType) = getimagesize($image);
            $imageType = image_type_to_mime_type($imageType);

            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            switch($imageType) {
                    case "image/gif":
                            $source=imagecreatefromgif($image); 
                            break;
                case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                            $source=imagecreatefromjpeg($image); 
                            break;
                case "image/png":
                    case "image/x-png":
                            $source=imagecreatefrompng($image); 
                            break;
            }
            imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
            switch($imageType) {
                    case "image/gif":
                            return imagegif($newImage,null); 
                            break;
            case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                            return imagejpeg($newImage,null,100); 
                            break;
                    case "image/png":
                    case "image/x-png":
                            return imagepng($newImage,null);  
                            break;
        }
            return true;
    }
    
    
    private function _stager($section, $imageName, $scale){
        
        $this->_stage1($section, $imageName);
        $this->_stage2($section);
        $imageFulPath = $this->_stage3($section, $imageName);
        $dimension = 200;

        header('Content-Type: image/jpeg');
        $this->_stage4($imageFulPath,$scale, $dimension); 
        $this->response->type('image/jpeg');
        $this->render(FALSE);
        
    }
    
    public function orginal($section = null, $imageName = null){
        $this->_stager($section,$imageName,1);
    }
    public function mzn($section = null, $imageName = null){
        $this->_stager($section,$imageName,0.9);
    }
    public function tun($section = null, $imageName = null){
        $this->_stager($section,$imageName,0.6);
    }
    public function cuk($section = null, $imageName = null){
        $this->_stager($section,$imageName,0.4);
    }

    
    public function og($query = null) {
      
        $file = 'https://hunerakurdi.com//wene/berhem/' . $query;
        
        
        // load source image to memory
        $image = $this->imagecreatefromfile($file);
        if (!$image) die('_');

        // load watermark to memory
        $watermark = $this->imagecreatefromfile('https://hunerakurdi.com//wene/player_watermark.png');
        if (!$image) die('__');

        // calculate the position of the watermark in the output image (the
        // watermark shall be placed in the lower right corner)
        $watermark_pos_x = imagesx($image) - imagesx($watermark);
        $watermark_pos_y = imagesy($image) - imagesy($watermark);
      //  $watermark_pos_x = imagesx($image) - imagesx($watermark)-124;
      //  $watermark_pos_y = imagesy($image) - imagesy($watermark)-5;

        // merge the source image and the watermark
        imagecopy($image, $watermark,  $watermark_pos_x, $watermark_pos_y, 0, 0,
          imagesx($watermark), imagesy($watermark));

        // output watermarked image to browser
        header('Content-Type: image/jpeg');
        imagejpeg($image, NULL, 100);  // use best image quality (100)
        // remove the images from memory
        imagedestroy($image);
        imagedestroy($watermark);
        
        $this->response->type('image/jpeg');
        $this->render(FALSE);
        }
        
       
            
        
        function imagecreatefromfile($image_path) {
            // retrieve the type of the provided image file
           
            list($width, $height, $image_type) = getimagesize($image_path);

            // select the appropriate imagecreatefrom* function based on the determined
            // image type
            switch ($image_type)
            {
              case IMAGETYPE_GIF: return imagecreatefromgif($image_path); break;
              case IMAGETYPE_JPEG: return imagecreatefromjpeg($image_path); break;
              case IMAGETYPE_PNG: return imagecreatefrompng($image_path); break;
              default: return ''; break;
            }
          }
          
          
          

    }
        