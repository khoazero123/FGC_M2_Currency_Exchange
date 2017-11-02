<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace FGC\CurrencyExchange\Helper;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

// $helper = $this->objectManager->create('Mageplaza\HelloWorld\Helper\Data');
//$this->scopeConfig->getValue('helloworld/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
// $this->scopeConfig->getValue('helloworld/general/display_text', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
class Data extends AbstractHelper {
    protected $storeManager;
    protected $objectManager;

    const XML_PATH_HELLOWORLD = 'helloworld/';
    public function __construct(Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager
    ) {
        $this->objectManager = $objectManager;
        $this->storeManager  = $storeManager;
        parent::__construct($context);
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }


    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HELLOWORLD . $code, $storeId);
    }
}