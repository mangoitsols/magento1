<?php

/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 * Custom CategoryReviews Block
 */

class Mangoit_CategoryReviews_Block_Adminhtml_Categoryreviews_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    const ALL_CATEGORIES = 0;

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('adminhtml/categoryreviews/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
            )
        );

        $hlp = Mage::helper('categoryreviews');
        $model = Mage::registry('categoryreviews');

        $fldCat = $form->addFieldset('Categories', array('legend' => $hlp->__('Categories')));

        $fldCat->addField(
            'label',
            'label',
            array(
                'label' => Mage::helper('categoryreviews')->__('Category'),
                'class' => 'required-entry',
                'required' => true,
                'after_element_html' => $this->getLayout()->createBlock('categoryreviews/adminhtml_categoryreviews')->getCategoryListing()->toHtml(),
            )
        );

        $fldCat->addField(
            'category_id',
            'hidden',
            array(
                'label' => Mage::helper('categoryreviews')->__('Category'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'category_id',
            )
        );

        $fldInfo = $form->addFieldset('Review Information', array('legend' => $hlp->__('Review Information')));

        $fldInfo->addType(
            'image',
            Mage::getConfig()->getBlockClassName('categoryreviews/adminhtml_categoryreviews_helper_image'),
        );

        $fldInfo->addField(
            'customer_review',
            'textarea',
            array(
                'label' =>  $hlp->__('Customer Review'),
                'name' => 'customer_review',
                'required' => true,
            )
        );

        $fldInfo->addField(
            'review_image',
            'image',
            array(
                'label' => $hlp->__('Review Image'),
                'name' => 'review_image',
                'required' => true,
                'note' => '(*.jpg, *.png, *.gif)',
            )
        );

        //set form values
        $form->setValues($model->getData());

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
