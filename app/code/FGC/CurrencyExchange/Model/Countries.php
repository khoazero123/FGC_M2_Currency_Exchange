<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace FGC\CurrencyExchange\Model;

/**
 * Options provider for full countries list
 *
 * @api
 *
 * @codeCoverageIgnore
 * @since 100.0.2
 */
class Countries extends \Magento\Directory\Model\Config\Source\Country implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @param bool $isMultiselect
     * @return array
     */
    public function toOptionArray($isMultiselect = false)
    {
        $countries = parent::toOptionArray(true);
        return $countries;
    }
}
