<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Get option array of the banner effects
 */
class Mangoit_Custombanner_Model_Status extends Varien_Object
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    /**
     * Get Enable/Disable option array
     */
    static public function getOptionArray() 
    {
        return array(
            self::STATUS_ENABLED => Mage::helper('custombanner')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('custombanner')->__('Disabled')
        );
    }
    
    /**
     * Get Animation option array
     */
    static public function getAnimationArray() 
    {
        $animations = array();
        $animations = array(
            array(
                'value' => 'Fade/Appear',
                'label' => Mage::helper('custombanner')->__('Fade / Appear'),
            ),
            array(
                'value' => 'Shake',
                'label' => Mage::helper('custombanner')->__('Shake'),
            ),

            array(
                'value' => 'Pulsate',
                'label' => Mage::helper('custombanner')->__('Pulsate'),
            ),
            array(
                'value' => 'Puff',
                'label' => Mage::helper('custombanner')->__('Puff'),
            ),
            array(
                'value' => 'Grow',
                'label' => Mage::helper('custombanner')->__('Grow'),
            ),
            array(
                'value' => 'Shrink',
                'label' => Mage::helper('custombanner')->__('Shrink'),
            ),
            array(
                'value' => 'Fold',
                'label' => Mage::helper('custombanner')->__('Fold'),
            ),         
            array(
                'value' => 'Squish',
                'label' => Mage::helper('custombanner')->__('Squish'),
            ),
   
            array(
                'value' => 'BlindUp',
                'label' => Mage::helper('custombanner')->__('Blindup'),
            ),
             array(
                'value' => 'BlindDown',
                'label' => Mage::helper('custombanner')->__('BlindDown'),
            ),            
            array(
                'value' => 'DropOut',
                'label' => Mage::helper('custombanner')->__('DropOut'),
            ),
        );
        array_unshift($animations, array('label' => '--Select--', 'value' => ''));
        return $animations;
    }
    
    /**
     * Get custom animation option array
     */
    static public function getPreAnimationArray() 
    {
        $animations = array();
        $animations = array(
            array(
                'value' => 'Numbered Banner',
                'label' => Mage::helper('custombanner')->__('Numbered Banner'),
            ),
            array(
                'value' => 'Image Slider',
                'label' => Mage::helper('custombanner')->__('Image Slider'),
            ),
            array(
                'value' => 'Image Vertical Slider',
                'label' => Mage::helper('custombanner')->__('Image Vertical Slider'),
            ),
        );
        array_unshift($animations, array('label' => '--Select--', 'value' => ''));
        return $animations;
    }
}