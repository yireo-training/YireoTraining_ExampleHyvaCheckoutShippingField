<?php declare(strict_types=1);

namespace YireoTraining\ExampleHyvaCheckoutShippingField\Setup\Patch\Schema;

use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Setup\Module\SetupFactory;

class AddExample1ShippingAddressAttribute implements SchemaPatchInterface
{
    private EavSetupFactory $eavSetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param Config $eavConfig
     * @param Attribute $attributeResource
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        for ($i = 1; $i < 5; $i++) {
            $this->addAttributeToTable('quote_address', $i);
            $this->addAttributeToTable('sales_order_address', $i);
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    private function addAttributeToTable(string $tableName, int $increment)
    {
        $attributeName = 'example' . $increment;
        $attributeLabel = 'Example ' . $increment;

        $setup = $this->eavSetupFactory->create()->getSetup();
        $setup->getConnection()->addColumn(
            $setup->getTable($tableName),
            $attributeName,
            [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'comment' => $attributeLabel,
            ]
        );
    }
}
