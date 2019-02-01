<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 */
class Mangoit_Custombanner_Block_Adminhtml_Widget_Grid_Column_Renderer_Banner extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }

    protected function _getValue(Varien_Object $row)
    {
        $dored = false;
        $out = '';
        if ($getter = $this->getColumn()->getGetter()) {
            $val = $row->$getter();
        }

        $val = $row->getData($this->getColumn()->getIndex());
        $url = Mage::helper('custombanner')->getImageUrl($val);
        $size = Mage::helper('custombanner')->getImageThumbSize($val);
        $file_extis = Mage::helper('custombanner')->getFileExists($val);
        $popLink = "popWin('$url','image','width=800,height=600,resizable=yes,scrollbars=yes')";
        if (is_array($size) && $file_extis) {
            $out = '<a href="javascript:;" onclick="'.$popLink.'"><img src="'.$url.'" width="'.$size['width'].'" height="'.$size['height'].'" style="border: 2px solid #CCCCCC;"/></a>'; 
        }

        return $out;
    }
}
