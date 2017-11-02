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
                'country_code', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 4,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Country Code'
            )
            ->addColumn(
                'country_name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255,
                ['nullable' => true],
                'Country Name'
              )
              ->addColumn(
                'currency_code', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 4,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Currency Code'
            )
            ->addColumn(
                'currency_name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255,
                ['nullable' => true], 
                'Currency Name'
            )
            ->addColumn(
                'rate', \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT, null,
                ['nullable' => false, 'default' => 1],
                'Currency Rate'
            )->setComment("Currencies table");
          $setup->getConnection()->createTable($table);
      }
}