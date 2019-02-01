<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Initialize custom banner group block
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombannergroup extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Constructor class
     */
    public function __construct() 
    {
        $this->_controller = 'adminhtml_custombannergroup';
        $this->_blockGroup = 'custombanner';
        $this->_headerText = Mage::helper('custombanner')->__('Custom Banner Group Manager');
        $this->_addButtonLabel = Mage::helper('custombanner')->__('Add Custom Banner Group');
        parent::__construct();
    }
}