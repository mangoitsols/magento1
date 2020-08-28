<?php

/**
 * @author Mangoit Team
 * @copyright Copyright (c) 2020 Mangoit
 * @package Mangoit_CategoryReviews
 */
class Mangoit_CategoryReviews_Block_Adminhtml_Categoryreviews_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('categoryreviews_grid');
        $this->setDefaultSort('categoryreviews_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('categoryreviews/categoryreviews')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $hlp = Mage::helper('categoryreviews');
        $this->addColumn(
            'categoryreviews_id', array(
                'header' => $hlp->__('ID'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'categoryreviews_id',
            )
        );

        $this->addColumn(
            'customer_review', array(
                'header' => $hlp->__('Customer Review'),
                'index' => 'customer_review',
            )
        );

        $this->addColumn(
            'review_image', array(
                'header' => $hlp->__('Review Image'),
                'index' => 'review_image',
                'renderer'  => 'categoryreviews/adminhtml_categoryreviews_widget_grid_column_renderer_image',
            )
        );

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('adminhtml/categoryreviews/edit', array('id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('categoryreviews_id');
        $this->getMassactionBlock()->setFormFieldName('categoryreviews');

        $this->getMassactionBlock()->addItem(
            'delete', array(
                'label' => Mage::helper('categoryreviews')->__('Delete'),
                'url' => $this->getUrl('adminhtml/categoryreviews/massDelete'),
                'confirm' => Mage::helper('categoryreviews')->__('Are you sure?')
            )
        );

        return $this;
    }
}
