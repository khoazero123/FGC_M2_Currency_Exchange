<?php
namespace FGC\CurrencyExchange\Model\ResourceModel\TodoItem;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('FGC\CurrencyExchange\Model\TodoItem','FGC\CurrencyExchange\Model\ResourceModel\TodoItem');
    }
}