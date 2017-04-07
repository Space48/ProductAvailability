<?php
/**
 * Mode.php
 *
 * @Date        04/2017
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      @diazwatson
 */

namespace Space48\ProductAvailability\Model\Config\Source\Category;

use Magento\Framework\Option\ArrayInterface;

class Mode implements ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Custom')], ['value' => 0, 'label' => __('Default')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [0 => __('Default'), 1 => __('Custom')];
    }
}