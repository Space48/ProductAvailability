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

namespace Space48\ProductAvailability\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     *
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.0', '<')) {
            /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            foreach ($this->getNewAttributes() as $attribute) {
                $eavSetup->addAttribute(
                    Product::ENTITY,
                    $attribute['attribute_code'],
                    [
                        'type'                    => $attribute['type'],
                        'label'                   => $attribute['label'],
                        'input'                   => $attribute['input'],
                        'backend'                 => $attribute['backend'],
                        'required'                => false,
                        'global'                  => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'frontend'                => $attribute['frontend'],
                        'class'                   => '',
                        'source'                  => '',
                        'visible'                 => true,
                        'user_defined'            => false,
                        'default'                 => null,
                        'searchable'              => false,
                        'filterable'              => false,
                        'comparable'              => false,
                        'visible_on_front'        => false,
                        'used_in_product_listing' => true,
                        'is_used_in_grid'         => true,
                        'is_visible_in_grid'      => false,
                        'is_filterable_in_grid'   => false,
                        'unique'                  => false,
                        'apply_to'                => ''

                    ]
                );
            }
        }
    }

    /**
     * @return array
     */
    private function getNewAttributes()
    {
        $attributes = [
            [
                'attribute_code' => 'available_from_x',
                'type'           => Table::TYPE_DATETIME,
                'label'          => 'Available From Date',
                'input'          => 'date',
                'backend'        => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
                'frontend'       => 'Magento\Eav\Model\Entity\Attribute\Frontend\Datetime'
            ],
            [
                'attribute_code' => 'available_to_promise',
                'type'           => Table::TYPE_TEXT,
                'label'          => 'Available To Promise',
                'input'          => 'text',
                'backend'        => '',
                'frontend'       => ''
            ],
        ];

        return $attributes;
    }
}
