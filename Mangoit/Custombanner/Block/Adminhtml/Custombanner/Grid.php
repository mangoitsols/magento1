<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombanner_Grid extends Mangoit_Custombanner_Block_Adminhtml_Widget_Grid
{

    /**
     * Constructor class
     */
    public function __construct() 
    {
        parent::__construct();
        $this->setId('bannerGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepare custom banner collection
     */
    protected function _prepareCollection() 
    {
        $collection = Mage::getModel('custombanner/custombanner')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare column in custom banner grid
     */
    protected function _prepareColumns() 
    {
        $this->addColumn(
            'banner_id', array(
            'header' => Mage::helper('custombanner')->__('ID'),
            'align' => 'center',
            'width' => '30px',
            'index' => 'banner_id',
            )
        );
        $this->addColumn(
            'filename', array(
            'header' => Mage::helper('custombanner')->__('Image'),
            'align' => 'center',
            'index' => 'filename',
            'type' => 'custombanner',
            'escape' => true,
            'sortable' => false,
            'width' => '150px',
            )
        );
        $this->addColumn(
            'title', array(
            'header' => Mage::helper('custombanner')->__('Title'),
            'index' => 'title',
            )
        );
        $this->addColumn(
            'link', array(
            'header' => Mage::helper('custombanner')->__('Web Url'),
            'width' => '150px',
            'index' => 'link',
            )
        );        
        $this->addColumn(
            'banner_type', array(
            'header' => Mage::helper('custombanner')->__('Type'),
            'width' => '80px',
            'index' => 'banner_type',
            'type' => 'options',
            'options' => array(
                0 => 'Image',
                1 => 'Html',
            ),
            )
        );
        $this->addColumn(
            'sort_order', array(
            'header' => Mage::helper('custombanner')->__('Sort Order'),
            'width' => '80px',
            'index' => 'sort_order',
            'align' => 'center',
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
                    'width' => '80',
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
      * Function to delete and change status of the banner
      */
    protected function _prepareMassaction() 
    {
        $this->setMassactionIdField('banner_id');
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
     * Add row url
     */
    public function getRowUrl($row) 
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    
    /*
    * Get grid url
    */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/bannergrid', array());
    }
}
