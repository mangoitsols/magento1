<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Initialize custom banner edit form
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombanner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Constructor class
     */
    public function __construct() 
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'custombanner';
        $this->_controller = 'adminhtml_custombanner';
        $this->_updateButton('save', 'label', Mage::helper('custombanner')->__('Save Banner'));
        $this->_updateButton('delete', 'label', Mage::helper('custombanner')->__('Delete Banner'));
        $this->_addButton(
            'saveandcontinue', array(
            'label' => Mage::helper('custombanner')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
            ), -100
        );
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('banner_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'banner_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'banner_content');
                }
            }
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText() 
    {
        if (Mage::registry('banner_data') && Mage::registry('banner_data')->getId()) {
            return Mage::helper('custombanner')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('banner_data')->getTitle()));
        } else {
            return Mage::helper('custombanner')->__('Add Item');
        }
    }
}
