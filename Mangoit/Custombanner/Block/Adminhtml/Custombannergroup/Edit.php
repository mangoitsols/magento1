<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Custom banner  group edit block
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombannergroup_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Constructor class
     */
    public function __construct() 
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'custombanner';
        $this->_controller = 'adminhtml_custombannergroup';
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
            function showBannerEfects(){
                var typeId=$('animation_type').value;
                var reqClass = ((typeId==1)?'required-entry':'');
                var preReqClass = ((typeId==1)?'':'required-entry');
                $('banner_effects').disabled = ((typeId==1)?false:true);
                $('pre_custombanner_effects').disabled = ((typeId==1)?true:false);
                $('banner_effects').addClassName(reqClass);
                $('pre_custombanner_effects').addClassName(preReqClass);
            }
            Event.observe('animation_type', 'change', function(){
                    showBannerEfects();
                });
            Event.observe(window, 'load', function(){
                    showBannerEfects();
                });
        ";
    }
    
    /**
     * Add Header text in custom banner group add/edit form
     */
    public function getHeaderText() 
    {
        if (Mage::registry('custombannergroup_data') && Mage::registry('custombannergroup_data')->getId()) {
            return Mage::helper('custombanner')->__("Edit Banner Group '%s'", $this->htmlEscape(Mage::registry('custombannergroup_data')->getGroupName()));
        } else {
            return Mage::helper('custombanner')->__('Add Banner Group');
        }
    }
}
