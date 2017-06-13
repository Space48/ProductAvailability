<?php

namespace Space48\ProductAvailability\Plugin\Model\Product\Type;

use \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection;
use \Magento\GroupedProduct\Model\Product\Type\Grouped as TypeGrouped;


class Grouped
{
    public function afterGetAssociatedProductCollection(TypeGrouped $subject, Collection $result)
    {
        $result->addAttributeToSelect('pre_sell_qty');
        $result->addAttributeToSelect('pre_sell');
        $result->addAttributeToSelect('available_from_x');

        return $result;
    }
}
