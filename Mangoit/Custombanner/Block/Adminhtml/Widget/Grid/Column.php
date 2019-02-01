<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 */
class Mangoit_Custombanner_Block_Adminhtml_Widget_Grid_Column extends Mage_Adminhtml_Block_Widget_Grid_Column
{
    protected function _getRendererByType()
    {
        switch (strtolower($this->getType())) {
        case 'custombanner':
            $rendererClass = 'custombanner/adminhtml_widget_grid_column_renderer_banner';
            break;
        default:
            $rendererClass = parent::_getRendererByType();
            break;
        }

        return $rendererClass;
    }

    protected function _getFilterByType()
    {
        switch (strtolower($this->getType())) {
        case 'custombanner':
            $filterClass = 'custombanner/adminhtml_widget_grid_column_filter_banner';
            break;
        default:
            $filterClass = parent::_getFilterByType();
            break;
        }

        return $filterClass;
    }
}
