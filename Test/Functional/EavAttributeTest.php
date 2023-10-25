<?php declare(strict_types=1);

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Eav\Model\AttributeManagement;
use Magento\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;

class EavAttributeTest extends TestCase
{
    public function testIfEavAttributeIsAvailable()
    {
        $eavAttibuteToTest = 'example1';

        $attributeManagement = ObjectManager::getInstance()->get(AttributeManagement::class);
        $eavAttributes = $attributeManagement->getAttributes(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            AddressMetadataInterface::ATTRIBUTE_SET_ID_ADDRESS
        );

        $found = false;
        foreach ($eavAttributes as $eavAttribute) {
            if ($eavAttribute->getAttributeCode() === $eavAttibuteToTest) {
                $found = true;
                break;
            }
        }

        $this->assertTrue($found, 'Attribute "'.$eavAttibuteToTest.'" is not found');
    }
}
