<?php
/**
 * Space48_ProductAvailability
 *
 * @category    Space48
 * @package     Space48_ProductAvailability
 * @Date        03/2017
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      @diazwatson
 */

namespace Space48\ProductAvailability\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{

    const PRODUCTAVAILABILITY_SYSCONFIG_PATH = "space48_productavailability/general/";

    /**
     * @return bool
     */
    public function isDebugMode()
    {
        return $this->getConfig('debug_mode');
    }

    /**
     * @return bool
     */
    public function isEnable()
    {
        return $this->getConfig('enabled');
    }
    /**
     * @param $field string
     *
     * @return string
     */
    private function getConfig($field)
    {
        return (bool) $this->scopeConfig->getValue(
            self::PRODUCTAVAILABILITY_SYSCONFIG_PATH . $field,
            ScopeInterface::SCOPE_STORE
        );
    }
}
