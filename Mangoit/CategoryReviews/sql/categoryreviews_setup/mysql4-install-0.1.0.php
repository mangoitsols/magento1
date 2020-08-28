<?php
/**
 * @category   Mangoit
 * @package    Mangoit_CategoryReviews
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('category_reviews'))
    ->addColumn('categoryreviews_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Categoryreviews Id')
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Category Id')
    ->addColumn('customer_review', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ), 'Customer Review')
    ->addColumn('review_image', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ), 'Review Image')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ), 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ), 'Updated At')
    ->setComment('Category Reviews');
$installer->getConnection()->createTable($table);
$installer->endSetup();