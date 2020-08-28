<?php 
/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 */
$installer = Mage::getResourceModel('catalog/setup','catalog_setup');
$installer->startSetup();

$installer->updateAttribute('catalog_category', 'gif1', 'backend_model', 'categoryreviews/category_attribute_backend_image');
$installer->updateAttribute('catalog_category', 'gif2', 'backend_model', 'categoryreviews/category_attribute_backend_image');
$installer->updateAttribute('catalog_category', 'gif3', 'backend_model', 'categoryreviews/category_attribute_backend_image');

$installer->endSetup();