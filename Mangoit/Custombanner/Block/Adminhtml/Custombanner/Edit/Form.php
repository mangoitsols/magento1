<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * This is use to prepare form to add/edit banner 
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombanner_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
        return parent::_prepareForm();
    }
}
