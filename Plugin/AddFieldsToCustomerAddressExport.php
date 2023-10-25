<?php declare(strict_types=1);

namespace YireoTraining\ExampleHyvaCheckoutShippingField\Plugin;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Quote\Model\Quote\Address;

class AddFieldsToCustomerAddressExport
{
    public function afterExportCustomerAddress(Address $subject, AddressInterface $addressDataObject)
    {
        $addressDataObject->setCustomAttribute('example1', $subject->getData('example1'));
        return $addressDataObject;
    }
}
