<?php declare(strict_types=1);

namespace YireoTraining\ExampleHyvaCheckoutShippingField\Setup\Patch\Data;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResourceModel;

class AddExample1ShippingAddressAttribute implements DataPatchInterface
{
    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private EavSetupFactory $eavSetupFactory,
        private Config $eavConfig,
        private AttributeResourceModel $attributeResourceModel
    ) {
    }

    public function apply()
    {
        for ($i = 1; $i < 5; $i++) {
            $this->addEavAttribute('customer_address', $i);
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

    private function addEavAttribute(string $entityType, int $increment)
    {
        $attributeCode = 'example' . $increment;
        $attributeLabel = 'Example ' . $increment;

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            $entityType,
            $attributeCode,
            [
                'input' => 'text',
                'is_visible_in_grid' => false,
                'visible' => true,
                'user_defined' => true,
                'is_filterable_in_grid' => false,
                'system' => false,
                'label' => $attributeLabel,
                'position' => 10,
                'type' => 'varchar',
                'is_used_in_grid' => false,
                'required' => false,
            ]
        );

        $attribute = $this->eavConfig->getAttribute($entityType, $attributeCode);
        $attribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer',
                'adminhtml_checkout',
                'adminhtml_customer_address',
                'customer_account_edit',
                'customer_address_edit',
                'customer_register_address',
                'checkout_register'
            ]
        );

        $this->attributeResourceModel->save($attribute);

        $eavSetup->addAttributeToGroup(
            $entityType,
            AddressMetadataInterface::ATTRIBUTE_SET_ID_ADDRESS,
            AddressMetadataInterface::ATTRIBUTE_SET_ID_ADDRESS,
            $attributeCode,
            null
        );
    }
}
