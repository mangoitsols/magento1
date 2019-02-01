<?php

/** 
 * @category   Mangoit
 * @package    Mangoit_Custombanner 
 */

class Mangoit_Custombanner_Block_Adminhtml_Widget_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function addColumn($columnId, $column) 
    {
        if (is_array($column)) {
            $this->_columns[$columnId] = $this->getLayout()->createBlock('custombanner/adminhtml_widget_grid_column')
                ->setData($column)
                ->setGrid($this);
        } else {
            Mage::throwException(Mage::helper('custombanner')->__('Wrong column format'));
        }

        $this->_columns[$columnId]->setId($columnId);
        $this->_lastColumnId = $columnId;
        return $this;
    }
}
