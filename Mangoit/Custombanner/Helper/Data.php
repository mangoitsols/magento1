<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Helper class to get image url, delete image etc..
 */
class Mangoit_Custombanner_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected static $_egridImgDir = null;
    protected static $_egridImgURL = null;
    protected static $_egridImgThumb = null;
    protected static $_egridImgThumbWidth = null;
    protected $_allowedExtensions = Array();

    public function __construct() 
    {
        self::$_egridImgDir = Mage::getBaseDir('media') . DS;
        self::$_egridImgURL = Mage::getBaseUrl('media');
        self::$_egridImgThumb = "thumb/";
        self::$_egridImgThumbWidth = 100;
    }

    /**
     * Update directory separator with slash
     */
    public function updateDirSepereator($path)
    {
        return str_replace('\\', DS, $path);
    }

    /**
     * Get image url
     */
    public function getImageUrl($imageFile) 
    {
        $url = false;
        if (file_exists(self::$_egridImgDir . self::$_egridImgThumb . $this->updateDirSepereator($imageFile))) {
            $url = self::$_egridImgURL . self::$_egridImgThumb . $imageFile; 
        } else {
            $url = self::$_egridImgURL . $imageFile; 
        }

        return $url;
    }

    /**
     * Check if image exists in the path
     */
    public function getFileExists($imageFile) 
    {
        $fileExists = false;
        $fileExists = file_exists(self::$_egridImgDir . $this->updateDirSepereator($imageFile));
        return $fileExists;
    }
    
    /**
     * Get thumbnail image to show in the banner grid
     */
    public function getImageThumbSize($imageFile) 
    {
        $imgFile = $this->updateDirSepereator(self::$_egridImgDir . $imageFile);
        if ($imageFile == '' || !file_exists($imageFile)) {
            return false; 
        }
        
        list($width, $height, $type, $attr) = getimagesize($imgFile);
        $aHeight = (int) ((self::$_egridImgThumbWidth / $width) * $height);
        return Array('width' => self::$_egridImgThumbWidth, 'height' => $aHeight);
    }
    
    /**
     * Delete image
     */
    public function deleteFiles($imageFile) 
    {
        $pass = true;
        if (!unlink(self::$_egridImgDir . $imageFile)) {
            $pass = false; 
        }

        if (!unlink(self::$_egridImgDir . self::$_egridImgThumb . $imageFile)) {
            $pass = false; 
        }

        return $pass;
    }
    
    /**
     * Resize image
     */
    public function getImageResize($newFile,$groupName, $width = 713, $height = 313) 
    {
        $newFile = str_replace('custom/banners/', '', $newFile);
        // return when the original image doesn't exist
        $imagePath = Mage::getBaseDir('media') . DS . 'custom' . DS . 'banners'
               . DS . $newFile;
        // resize the image if needed
        $rszImagePath = Mage::getBaseDir('media') . '/custom' . DS . 'banners'
                  . DS . 'resize' . DS .  $groupName .DS 
                  . $newFile;        
        $image = new Varien_Image($imagePath);
        try {
             $image->constrainOnly(true);
             $image->keepAspectRatio(false);
             $image->keepFrame(false);
             $image->quality(true);
             $image->resize($width, $height);
             $image->save($rszImagePath);
        }  catch (Exception $e) {
            return $e->getMessage();
        }

        // return the image URL
        return Mage::getBaseUrl('media') . 'custom/banners/resize/'. $groupName .DS . $newFile;
    }
}
