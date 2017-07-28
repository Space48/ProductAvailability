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
namespace Space48\ProductAvailability\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Space48\ProductAvailability\Block\Catalog\Product\View\Type\Simple as ProductAvailability;
use Magento\Catalog\Model\Session;

class QuickViewData implements ObserverInterface
{

    private $productAvailability;
    private $catalogSession;

    /**
     * QuickViewData constructor.
     *
     * @param ProductAvailability $productAvailability
     * @param Session             $catalogSession
     */
    public function __construct(
        ProductAvailability $productAvailability,
        Session $catalogSession
    ) {
        $this->productAvailability = $productAvailability;
        $this->catalogSession = $catalogSession;
    }

    public function execute(Observer $observer)
    {
        $specialQuickViewData = $this->catalogSession->getSpecialQuickViewData();
        $product = $observer->getEvent()->getProduct();

        $availability = $this->productAvailability->getAvailability($product);

        $newSpecialData = [
            'availability_msg' => $availability['label']
        ];

        $this->catalogSession->setSpecialQuickViewData(array_merge($newSpecialData, $specialQuickViewData));
    }
}
