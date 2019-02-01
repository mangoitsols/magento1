<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Prepare form for custom banner group
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombannergroup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Prepare form for custom banner group
     */
    protected function _prepareForm() 
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('custombannergroup_form', array('legend' => Mage::helper('custombanner')->__('Banner Information')));
        $animations = Mage::getSingleton('custombanner/status')->getAnimationArray();
        $preAnimations = Mage::getSingleton('custombanner/status')->getPreAnimationArray();
        $fieldset->addField(
            'group_name', 'text', array(
            'label' => Mage::helper('custombanner')->__('Custombanner Group Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'group_name',
            )
        );
        if (Mage::registry('custombannergroup_data')->getId() == null) {
            $fieldset->addField(
                'group_code', 'text', array(
                'label' => Mage::helper('custombanner')->__('Custombanner Group Code'),
                'class' => 'required-entry',
                'name' => 'group_code',
                'required' => true,
                )
            );
        }
        
        $fieldset->addField(
            'banner_width', 'text', array(
            'label' => Mage::helper('custombanner')->__('Width [in px]'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'banner_width',
            )
        );
        $fieldset->addField(
            'banner_height', 'text', array(
            'label' => Mage::helper('custombanner')->__('Height [in px]'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'banner_height',
            )
        );
        $fieldset->addField(
            'animation_type', 'select', array(
            'label' => Mage::helper('custombanner')->__('Animation type'),
            'name' => 'animation_type',
            'required' => true,
            'values' => array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('custombanner')->__('Pre-defined Animation'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('custombanner')->__('Custom Animation'),
                ),
            ),
            )
        );
        $fieldset->addField(
            'pre_custombanner_effects', 'select', array(
            'label' => Mage::helper('custombanner')->__('Pre-Defined Banner Effects'),
            'name' => 'pre_custombanner_effects',
            'required' => true,
            'values' => $preAnimations
            )
        );
        $fieldset->addField(
            'banner_effects', 'select', array(
            'label' => Mage::helper('custombanner')->__('Custom Banner Effects'),
            'name' => 'banner_effects',
            'required' => true,
            'values' => $animations
            )
        );       
        $fieldset->addField(
            'link_target', 'select', array(
            'label' => Mage::helper('custombanner')->__('Target'),
            'name' => 'link_target',
            'values' => array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('custombanner')->__('New Window'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('custombanner')->__('Same Window'),
                ),
            ),
            )
        );
        $fieldset->addField(
            'status', 'select', array(
            'label' => Mage::helper('custombanner')->__('Status'),
            'class' => 'required-entry',
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('custombanner')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('custombanner')->__('Disabled'),
                ),
            ),
            )
        );
        if (Mage::getSingleton('adminhtml/session')->getBannergroupData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBannergroupData());
            Mage::getSingleton('adminhtml/session')->setBannergroupData(null);
        } elseif (Mage::registry('custombannergroup_data')) {
            $form->setValues(Mage::registry('custombannergroup_data')->getData());
        }

        return parent::_prepareForm();
    }
}
