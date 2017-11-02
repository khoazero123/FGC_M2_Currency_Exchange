<?php
namespace FGC\CurrencyExchange\Model\ResourceModel;
class TodoItem extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('pulsestorm_todocrud_todoitem','pulsestorm_todocrud_todoitem_id');
    }
}