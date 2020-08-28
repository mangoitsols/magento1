<?php 
/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 */

$installer = Mage::getResourceModel('catalog/setup','catalog_setup');
$installer->startSetup();

$installer->updateAttribute('catalog_category', 'gif_description1', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_category', 'gif_description1', 'is_html_allowed_on_front', 1);
$installer->updateAttribute('catalog_category', 'gif_description2', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_category', 'gif_description2', 'is_html_allowed_on_front', 1);
$installer->updateAttribute('catalog_category', 'gif_description3', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_category', 'gif_description3', 'is_html_allowed_on_front', 1);
$installer->updateAttribute('catalog_category', 'cover_description1', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_category', 'cover_description1', 'is_html_allowed_on_front', 1);
$installer->updateAttribute('catalog_category', 'cover_description2', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_category', 'cover_description2', 'is_html_allowed_on_front', 1);
$installer->updateAttribute('catalog_category', 'weatherproof_content', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_category', 'weatherproof_content', 'is_html_allowed_on_front', 1);
$installer->updateAttribute('catalog_category', 'best_seller_outdoor_content', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_category', 'best_seller_outdoor_content', 'is_html_allowed_on_front', 1);
$installer->updateAttribute('catalog_category', 'best_seller_outdoor_features', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_category', 'best_seller_outdoor_features', 'is_html_allowed_on_front', 1);
$installer->updateAttribute('catalog_category', 'best_seller_indoor_content', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_category', 'best_seller_indoor_content', 'is_html_allowed_on_front', 1);

$installer->endSetup();