<?php

namespace Space48\ProductAvailability\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\Event\Observer;
use Space48\ProductAvailability\Block\Catalog\Product\View\Type\Simple as ProductAvailability;
use Magento\Framework\Registry;
use Magento\Catalog\Model\Session;

class QuickViewData implements ObserverInterface
{
    private $jsonHelper;
    private $productAvailability;
    private $catalogSession;

    public function __construct(
        JsonHelper $jsonHelper,
        ProductAvailability $productAvailability,
        Registry $registry,
        Session $catalogSession
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->productAvailability = $productAvailability;
        $this->catalogSession = $catalogSession;
    }

    public function execute(Observer $observer)
    {
        $specialQuickViewData = $this->catalogSession->getSpecialQuickViewData();
        $product = $observer->getEvent()->getProduct();

        $newSpecialData = [
            'availability_msg'      => $this->productAvailability->getAvailability($product)
        ];

        $this->catalogSession->setSpecialQuickViewData(array_merge($newSpecialData, $specialQuickViewData));
    }
}
