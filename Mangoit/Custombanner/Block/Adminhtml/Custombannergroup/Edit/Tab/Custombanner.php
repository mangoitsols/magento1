<?php
/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 * Block to add grid for custom banner group
 */
class Mangoit_Custombanner_Block_Adminhtml_Custombannergroup_Edit_Tab_Custombanner extends Mangoit_Custombanner_Block_Adminhtml_Widget_Grid
{

    /**
     * Constructor class
     */
    public function __construct() 
    {
        parent::__construct();
        $this->setId('bannerLeftGrid');
        $this->setDefaultSort('banner_id');
        $this->setUseAjax(true);
    }

    /**
     * Get Banner group data
     */
    public function getBannergroupData() 
    {
        return Mage::registry('custombannergroup_data');
    }

    /**
     * Prepare custom banner group collection
     */
    protected function _prepareCollection() 
    {
        $collection = Mage::getModel('custombanner/custombanner')->getCollection();
        $collection->getSelect()->order('banner_id');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add column filter in custom banner group collection
     */
    protected function _addColumnFilterToCollection($column) 
    {
        if ($this->getCollection()) {
            if ($column->getId() == 'banner_triggers') {
                $bannerIds = $this->_getSelectedBanners();
                if (empty($bannerIds)) {
                    $bannerIds = 0;
                }

                if ($column->getFilter()->getValue()) {
                    $this->getCollection()->addFieldToFilter('banner_id', array('in' => $bannerIds));
                } else {
                    if ($bannerIds) {
                        $this->getCollection()->addFieldToFilter('banner_id', array('nin' => $bannerIds));
                    }
                }
            } else {
                parent::_addColumnFilterToCollection($column);
            }
        }
        
        return $this;;
    }

    /**
     * Prepare custom banner group grid columns
     */
    protected function _prepareColumns() 
    {
        $this->addColumn(
            'banner_triggers', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'values' => $this->_getSelectedBanners(),
            'align' => 'center',
            'index' => 'banner_id'
            )
        );
        $this->addColumn(
            'banner_id', array(
            'header' => Mage::helper('catalog')->__('ID'),
            'sortable' => true,
            'width' => '50',
            'align' => 'center',
            'index' => 'banner_id'
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
            'header' => Mage::helper('catalog')->__('Title'),
            'index' => 'title',
            'align' => 'left',
            )
        );
        $this->addColumn(
            'link', array(
            'header' => Mage::helper('custombanner')->__('Link'),
            'width' => '200px',
            'index' => 'link',
            )
        );
        $this->addColumn(
            'banner_type', array(
            'header' => Mage::helper('custombanner')->__('Type'),
            'width' => '100px',
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
        return parent::_prepareColumns();
    }

    /**
     * Get grid url
     */
    public function getGridUrl() 
    {
        return $this->getUrl('*/*/bannergrid', array('_current' => true));
    }

    /**
     * Get Selected banner in specific custom banner group
     */ 
    protected function _getSelectedBanners() 
    {
        $banners = $this->getRequest()->getPost('selected_custombanners');
        if (isset($banners) && $banners != '') {
            $banners = explode(',', $this->getBannergroupData()->getBannerIds());
            return (count($banners) > 0 ? $banners : 0);
        }

        return $banners;
    }
}