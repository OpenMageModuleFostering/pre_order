<?php

$this->startSetup();
$this->addAttribute('catalog_product', 'pre_order', array(
    'group' => 'General',
    'type' => 'int', // can be int, varchar, decimal, text, datetime
    'backend' => '', // If you're making an image attribute you'll need to add : catalog/category_attribute_backend_image
    'frontend_input' => '',
    'frontend' => '',
    'label' => 'Is Pre Order',
    'input' => 'boolean', //text, textarea, select, file, image, multiselect
    'class' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL, // Scope can be SCOPE_STORE, SCOPE_GLOBAL or SCOPE_WEBSITE
    'visible' => true,
    'frontend_class' => '',
    'required' => false, // or true
    'user_defined' => true, // or false
    'used_in_product_listing' => '1',
    'default' => '',
    'apply_to' => 'simple,configurable,virtual,bundle,downloadable',
));
$this->addAttribute('catalog_product', 'pre_order_note', array(
    'group' => 'General',
    'type' => 'varchar', // can be int, varchar, decimal, text, datetime
    'backend' => '', // If you're making an image attribute you'll need to add : catalog/category_attribute_backend_image
    'frontend_input' => '',
    'frontend' => '',
    'label' => 'Pre Order Note',
    'input' => 'text', //text, textarea, select, file, image, multiselect
    'class' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL, // Scope can be SCOPE_STORE, SCOPE_GLOBAL or SCOPE_WEBSITE
    'visible' => true,
    'frontend_class' => '',
    'required' => false, // or true
    'user_defined' => true, // or false
    'used_in_product_listing' => '1',
    'default' => '',
    'apply_to' => 'simple,configurable,virtual,bundle,downloadable',
));
$this->endSetup();

$installer = new Mage_Sales_Model_Resource_Setup('core_setup');
/**
 * Add 'custom_attribute' attribute for entities
 */
$entities = array(
    'quote',
    'quote_item',
    'order',
    'order_item'
);
$entitiesnew = array(
    'quote_item',
    'order_item'
);
$options = array(
    'type'     => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
    'visible'  => true,
    'required' => false,
    'default' => 0
);
$options2 = array(
    'type'     => Varien_Db_Ddl_Table::TYPE_VARCHAR,
    'visible'  => true,
    'required' => false
);
foreach ($entities as $entity) {
    $installer->addAttribute($entity, 'pre_order', $options);   
}
foreach ($entitiesnew as $entitynew) {
     $installer->addAttribute($entitynew, 'pre_order_note', $options2);
}
$installer->endSetup();
?>