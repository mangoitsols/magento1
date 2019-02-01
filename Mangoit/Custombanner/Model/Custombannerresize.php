<?php
/**
 * category   Mangoit
 * package    Mangoit_Custombanner
 * Model to resize custom banner image
 */
define("Mangoit_AUTO_NAME", 1);
class Mangoit_Custombanner_Model_Custombannerresize
{

    public $imgFile = "";
    public $imgWidth = 0;
    public $imgHeight = 0;
    public $imgType = "";
    public $imgAttr = "";
    public $type = null;
    public $img = null;
    public $error = "";
    /**
     * Constructor
     *
     * param  [String $imgFile] Image File Name
     * return RESIZEIMAGE (Class Object)
     */
    public function Mangoit_Custombanner_Model_Custombannerresize($imgFile="") 
    {
        if (!function_exists("imagecreate")) {
            $this->_error = "Error: GD Library is not available.";
            return false;
        }

        $this->type = Array(1 => 'GIF', 2 => 'JPG', 3 => 'PNG', 4 => 'SWF', 5 => 'PSD', 6 => 'BMP', 7 => 'TIFF', 8 => 'TIFF', 9 => 'JPC', 10 => 'JP2', 11 => 'JPX', 12 => 'JB2', 13 => 'SWC', 14 => 'IFF', 15 => 'WBMP', 16 => 'XBM');
        if (!empty($imgFile)) {
            $this->setImage($imgFile); 
        }
    }

    /**
     * Error occured while resizing the image.
     *
     * return String
     */
    public function error() 
    {
        return $this->_error;
    }

    /**
     * Set image file name
     *
     * param  String $imgFile
     * return void
     */
    public function setImage($imgFile) 
    {
        $this->imgFile = $imgFile;
        return $this->_createImage();
    }

    /**
     *
     * return void
     */
    public function close() 
    {
        return imagedestroy($this->_img);
    }

    /**
     * Resize a image to given width and height and keep it's current width and height ratio
     *
     * param Number  $imgwidth
     * param Numnber $imgheight
     * param String  $newfile
     */
    public function resizeLimitwh($imgwidth, $imgheight, $newfile=null) 
    {
        $imagePer = 100;
        list($width, $height, $type, $attr) = getimagesize($this->imgFile);
        if ($width > $imgwidth && $imgwidth > 0) {
            $imagePer = (double) (($imgwidth * 100) / $width); 
        }

        if (floor(($height * $imagePer) / 100) > $imgheight && $imgheight > 0) {
            $imagePer = (double) (($imgheight * 100) / $height); 
        }

        $this->resizePercentage($imagePer, $newfile);
    }

    /**
     * Resize an image to given percentage.
     *
     * param  Number $percent
     * param  String $newfile
     * return Boolean
     */
    public function resizePercentage($percent=100, $newfile=null) 
    {
        $newWidth = ($this->imgWidth * $percent) / 100;
        $newHeight = ($this->imgHeight * $percent) / 100;
        return $this->resize($newWidth, $newHeight, $newfile);
    }

    /**
     * Resize an image to given X and Y percentage.
     *
     * param  Number $xpercent
     * param  Number $ypercent
     * param  String $newfile
     * return Boolean
     */
    public function resizeXYpercentage($xpercent=100, $ypercent=100, $newfile=null) 
    {
        $newWidth = ($this->imgWidth * $xpercent) / 100;
        $newHeight = ($this->imgHeight * $ypercent) / 100;
        return $this->resize($newWidth, $newHeight, $newfile);
    }

    /**
     * Resize an image to given width and height
     *
     * param  Number $width
     * param  Number $height
     * param  String $newfile
     * return Boolean
     */
    public function resize($width, $height, $newfile=null) 
    {
        if (empty($this->imgFile)) {
            $this->_error = "File name is not initialised.";
            return false;
        }

        if ($this->imgWidth <= 0 || $this->imgHeight <= 0) {
            $this->_error = "Could not resize given image";
            return false;
        }

        if ($width <= 0) {
            $width = $this->imgWidth; 
        }

        if ($height <= 0) {
            $height = $this->imgHeight; 
        }

        return $this->_resize($width, $height, $newfile);
    }

    /**
     * Get the image attributes
     *
     * access Private
     */
    public function _getImageInfo() 
    {
        list($this->imgWidth, $this->imgHeight, $type, $this->imgAttr) = getimagesize($this->imgFile);
        $this->imgType = $this->type[$type];
    }

    /**
     * Create the image resource
     *
     * access Private
     * return Boolean
     */
    public function _createImage() 
    {
        $this->_getImageInfo($this->imgFile);
        if ($this->imgType == 'GIF') {
            $this->_img = imagecreatefromgif($this->imgFile);
        } elseif ($this->imgType == 'JPG') {
            $this->_img = imagecreatefromjpeg($this->imgFile);
        } elseif ($this->imgType == 'PNG') {
            $this->_img = imagecreatefrompng($this->imgFile);
        }

        if (!$this->_img || !is_resource($this->_img)) {
            $this->_error = "Error loading " . $this->imgFile;
            return false;
        }

        return true;
    }

    /**
     * Function is used to resize the image
     *
     * access Private
     * param  Number $width
     * param  Number $height
     * param  String $newfile
     * return Boolean
     */
    public function _resize($width, $height, $newfile=null) 
    {
        $funcExist = function_exists("imagecreate");
        $this->imageCreate($funcExist);

        $newimg = imagecreatetruecolor($width, $height);
        if ($this->imgType == 'GIF' || $this->imgType == 'PNG') {
            /**
            * Code to keep transparency of image * 
            */
            $colorcount = imagecolorstotal($this->_img);
            $this->colorCount($colorcount);
            
            imagetruecolortopalette($newimg, true, $colorcount);
            imagepalettecopy($newimg, $this->_img);
            $transparentcolor = imagecolortransparent($this->_img);
            imagefill($newimg, 0, 0, $transparentcolor);
            imagecolortransparent($newimg, $transparentcolor);
        }

        imagecopyresampled($newimg, $this->_img, 0, 0, 0, 0, $width, $height, $this->imgWidth, $this->imgHeight);
        if ($newfile === Mangoit_AUTO_NAME) {
            if (preg_match("/\..*+$/", basename($this->imgFile), $matches)) {
                $newfile = substr_replace($this->imgFile, "_har", -strlen($matches[0]), 0); 
            }
        } elseif (!empty($newfile)) {
            if (!preg_match("/\..*+$/", basename($newfile))) {
                if (preg_match("/\..*+$/", basename($this->imgFile), $matches)) {
                    $newfile = $newfile . $matches[0]; 
                }
            }
        }

        if ($this->imgType == 'GIF') {
            $this->imageTypeGif($newfile, $newimg);
        } elseif ($this->imgType == 'JPG') {
            $this->imageTypeJpg($newfile, $newimg);
        } elseif ($this->imgType == 'PNG') {
            $this->imageTypePng($newfile, $newimg);
        }

        imagedestroy($newimg);
    }

    public function imageCreate($funcExist)
    {
        if (!$funcExist) {
            $this->_error = "Error: GD Library is not available.";
            return false;
        }
    }

    public function colorCount($colorcount)
    {
        if ($colorcount == 0) {
            $colorcount = 256; 
        }
    }

    public function imageTypeGif($newfile, $newimg)
    {
        if (!empty($newfile)) {
            imagegif($newimg, $newfile); 
        } else {
            header("Content-type: image/gif");
            imagegif($newimg);
        }
    }

    public function imageTypeJpg($newfile, $newimg)
    {
        if (!empty($newfile)) {
            imagejpeg($newimg, $newfile);                
        } else {
            header("Content-type: image/jpeg");
            imagejpeg($newimg);
        }
    }

    public function imageTypePng($newfile, $newimg)
    {
        if (!empty($newfile)) {
            imagepng($newimg, $newfile); 
        } else {
            header("Content-type: image/png");
            imagepng($newimg);
        }
    }
    
    public function getImageResize($newFile,$groupName, $width = 713, $height = 313) 
    {
        $newFile = str_replace('custom/banners/', '', $newFile);
        // return when the original image doesn't exist
        $imagePath = Mage::getBaseDir('media') . DS . 'custom' . DS . 'banners'
               . DS . $newFile;
        if (!file_exists($imagePath)) {
            return false;
        }

        // resize the image if needed
        $rszImagePath = Mage::getBaseDir('media') . '/custom' . DS . 'banners'
                  . DS . 'resize' . DS .  $groupName .DS 
                  . $newFile;
        if (!file_exists($rszImagePath)) {
            $image = new Varien_Image($imagePath);
            try {
                $image->resize($width, $height);
                $image->save($rszImagePath);
            }  catch (Exception $e) {
                return $e->getMessage();
            }
        }

        // return the image URL
        return Mage::getBaseUrl('media') . 'custom/banners/resize/'. $groupName .DS . $newFile;
    }
}