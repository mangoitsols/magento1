<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Custom banner group grid
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombannergroup_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Constructor class
     */
    public function __construct() 
    {
        parent::__construct();
        $this->setId('custombannergroupGrid');
        $this->setDefaultSort('group_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepare custom banner group collection
     */
    protected function _prepareCollection() 
    {
        $model = Mage::getModel('custombanner/custombannergroup')->getCollection();
        $model->addFieldToSelect('banner_effects', 'banner_effect');
        $model->addFieldToSelect('group_id');
        $model->addFieldToSelect('group_name');
        $model->addFieldToSelect('group_code');
        $model->addFieldToSelect('banner_width');
        $model->addFieldToSelect('banner_height');
        $model->addFieldToSelect('animation_type');
        $model->addFieldToSelect('banner_effects');
        $model->addFieldToSelect('pre_custombanner_effects');
        $model->addFieldToSelect('banner_ids');
        $model->addFieldToSelect('show_title');
        $model->addFieldToSelect('show_content');
        $model->addFieldToSelect('link_target');
        $model->addFieldToSelect('status');
        $model->addFieldToSelect('created_time');
        $model->addFieldToSelect('update_time');
        $this->setCollection($model);
        return parent::_prepareCollection();
    }

    /**
     * Prepare column for custom banner group
     */
    protected function _prepareColumns() 
    {
        $this->addColumn(
            'group_id', array(
            'header' => Mage::helper('custombanner')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'group_id',
            )
        );
        $this->addColumn(
            'group_name', array(
            'header' => Mage::helper('custombanner')->__('Group name'),
            'index' => 'group_name',
            )
        );
        $this->addColumn(
            'group_code', array(
            'header' => Mage::helper('custombanner')->__('Group code'),
            'width' => '100px',
            'index' => 'group_code',
            )
        );
        $this->addColumn(
            'banner_width', array(
            'header' => Mage::helper('custombanner')->__('Width'),
            'width' => '100px',
            'align' => 'center',
            'index' => 'banner_width',
            )
        );
        $this->addColumn(
            'banner_height', array(
            'header' => Mage::helper('custombanner')->__('Height'),
            'width' => '100px',
            'align' => 'center',
            'index' => 'banner_height',
            )
        );
        $this->addColumn(
            'animation_type', array(
            'header' => Mage::helper('custombanner')->__('Animation Type'),
            'width' => '100px',
            'align' => 'center',
            'index' => 'animation_type',
            'type' => 'options',
            'options' => array(
                0 => 'Pre-defined',
                1 => 'Custom',
            ),
            )
        );
        $this->addColumn(
            'banner_effect', array(
            'header' => Mage::helper('custombanner')->__('Effect'),
            'width' => '150px',
            'align' => 'left',
            'index' => 'banner_effect',
            )
        );
        $this->addColumn(
            'banner_ids', array(
            'header' => Mage::helper('custombanner')->__('Banners'),
            'width' => '50px',
            'index' => 'banner_ids',
            )
        );
        
        $this->addColumn(
            'status', array(
            'header' => Mage::helper('custombanner')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
            )
        );
        $this->addColumn(
            'action',
            array(
                    'header' => Mage::helper('custombanner')->__('Action'),
                    'width' => '50',
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array(
                        array(
                            'caption' => Mage::helper('custombanner')->__('Edit'),
                            'url' => array('base' => '*/*/edit'),
                            'field' => 'id'
                        )
                    ),
                    'filter' => false,
                    'sortable' => false,
                    'index' => 'stores',
                    'is_system' => true,
            )
        );
        return parent::_prepareColumns();
    }

    /**
     * Action to change and delete custom banner group
     */
    protected function _prepareMassaction() 
    {
        $this->setMassactionIdField('group_id');
        $this->getMassactionBlock()->setFormFieldName('custombanner');
        $this->getMassactionBlock()->addItem(
            'delete', array(
            'label' => Mage::helper('custombanner')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('custombanner')->__('Are you sure?')
            )
        );
        $statuses = Mage::getSingleton('custombanner/status')->getOptionArray();
        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem(
            'status', array(
            'label' => Mage::helper('custombanner')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('custombanner')->__('Status'),
                    'values' => $statuses
                )
            )
            )
        );
        return $this;
    }
    
    /**
     * Get row url
     */
    public function getRowUrl($row) 
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    
    /**
     * Get grid url
     */
    public function getGridUrl() 
    {
        return $this->getUrl('*/*/bannergrid', array());
    }
}
