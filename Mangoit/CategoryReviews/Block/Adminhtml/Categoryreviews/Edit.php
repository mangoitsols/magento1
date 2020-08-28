<?php

/**
 * @author Mangoit Team
 * @copyright Copyright (c) 2020 Mangoit
 * @package Mangoit_CategoryReviews
 */
class Mangoit_CategoryReviews_Block_Adminhtml_Categoryreviews_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'categoryreviews';
        $this->_controller = 'adminhtml_categoryreviews';
        $this->_mode = 'edit';
        $mid = Mage::registry('categoryreviews')->getId();

        if ($mid) {
            $this->_addButton(
                'save_and_continue',
                array(
                    'label' => Mage::helper('categoryreviews')->__('Save and Continue Edit'),
                    'onclick' => 'saveAndContinueEdit()',
                    'class' => 'save'
                ),
                10
            );
            $this->_formScripts[] =
                " function saveAndContinueEdit(){ editForm.submit($('edit_form').action + 'continue/edit') } ";

            $url = $this->getUrl('adminhtml/value/new', array('categoryreviews' => $mid));
            $this->_formScripts[] = " function newCategoryReviews(){ setLocation('$url'); } ";
        }

        $this->_removeButton('reset');
    }

    public function getHeaderText()
    {
        $header = Mage::helper('categoryreviews')->__('New Customer Reviews');
        if (Mage::registry('categoryreviews')->getId()) {
            $header = Mage::helper('categoryreviews')->__('Edit Customer Reviews for Category');
        }
        return $header;
    }
}
