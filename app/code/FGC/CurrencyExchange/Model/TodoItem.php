<?php
namespace FGC\CurrencyExchange\Model;
class TodoItem extends \Magento\Framework\Model\AbstractModel implements TodoItemInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'pulsestorm_todocrud_todoitem';

    protected function _construct()
    {
        $this->_init('FGC\CurrencyExchange\Model\ResourceModel\TodoItem');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}