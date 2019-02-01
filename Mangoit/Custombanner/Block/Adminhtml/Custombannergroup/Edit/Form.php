<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Block to prepare custom banner group form
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombannergroup_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Prepare form
     */
    protected function _prepareForm() 
    {
        $form = new Varien_Data_Form(
            array(
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
            )
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        $form->addField(
            'in_customcustombannergroup_custombanners', 'hidden', array(
            'name' => 'custombannergroup_custombanners',
            'required' => false,
            )
        );
        return parent::_prepareForm();
    }
}
