<?php

namespace FGC\CurrencyExchange\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface {
    /**
    * {@inheritdoc}
    * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
    */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
          /**
          * Create table 'fgc_currencies'
          */
          $table = $setup->getConnection()
              ->newTable($setup->getTable('fgc_currencies'))
              ->addColumn(
                  'country_code',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  4,
                  ['unsigned' => true, 'nullable' => false, 'primary' => true],
                  'Currency Code'
              )
              ->addColumn(
                  'currency_rate',
                  \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                  null,
                  ['nullable' => false, 'default' => 1],
                    'Currency Rate'
              )
              ->addColumn(
                  'country_image',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  255,
                  ['nullable' => true],
                    'Country Image'
              )
              ->addColumn(
                  'country_name',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  255,
                  ['nullable' => true],
                    'Country Name'
              )->setComment("Currencies table");
          $setup->getConnection()->createTable($table);
      }
}