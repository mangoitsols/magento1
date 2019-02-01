<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 */
class Mangoit_Custombanner_Block_Custombanner extends Mage_Core_Block_Template
{
    /**
     * Get banner data
     */
    public function getBanner() 
    {
        if (!$this->hasData('custombanner')) {
            $this->setData('custombanner', Mage::registry('custombanner'));
        }

        return $this->getData('custombanner');
    }
    
    /**
     * Get custom banner group data with banner group code
     */ 
    public function getDataByGroupCode($groupCode)
    {
        return Mage::getModel('custombanner/custombannergroup')->getDataByGroupCode($groupCode);
    }

    /**
     * Get resized image
     */
    public function getResizeImage($bannerPath, $groupName, $w = 0, $h = 0) 
    {
        $name = '';
        $_helper = Mage::helper('custombanner');
        $bannerDirPath = $_helper->updateDirSepereator($bannerPath);
        $baseDir = Mage::getBaseDir();
        $mediaDir = Mage::getBaseDir('media');
        $mediaUrl = Mage::getBaseUrl('media');
        $resizeDir = $mediaDir . DS . 'custom' . DS . 'banners' . DS . 'resize' . DS;
        $resizeUrl = $mediaUrl.'custom/banners/resize/';
        $imageName = basename($bannerDirPath);
        if (file_exists($mediaDir . DS . $bannerDirPath)) {
            $name = $mediaDir . DS . $bannerPath;
            $this->checkDir($resizeDir . $groupName);
            $smallImgPath = $resizeDir . $groupName . DS . $imageName;
            $smallImg = $resizeUrl . $groupName .'/'. $imageName;
        }

        if ($name != '') {
            $resizeObject = Mage::helper('custombanner');
            $imageResize = $resizeObject->getImageResize($bannerPath, $groupName, $w, $h);
            if ($imageResize === false) {
                return $resizeObject->error();
            } else {                
                return $imageResize;
            }
        } else {
            return '';
        }
    }
    
    /**
     * Check if the directory exist to save banner image
     */
    protected function checkDir($directory) 
    {
        if (!is_dir($directory)) {
            umask(0);
            mkdir($directory, 0777, true);
            return true;
        }
    }
}
