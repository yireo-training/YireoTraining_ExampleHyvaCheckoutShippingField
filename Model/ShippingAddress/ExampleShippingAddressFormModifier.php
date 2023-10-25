<?php declare(strict_types=1);

namespace YireoTraining\ExampleHyvaCheckoutShippingField\Model\ShippingAddress;

use Hyva\Checkout\Magewire\Checkout\AddressView\MagewireAddressFormInterface;
use Hyva\Checkout\Model\Form\EntityFormInterface;
use Hyva\Checkout\Model\Form\EntityFormModifierInterface;
use Psr\Log\LoggerInterface;

class ExampleShippingAddressFormModifier implements EntityFormModifierInterface
{
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function apply(EntityFormInterface $form): EntityFormInterface
    {
        $form->registerModificationListener(
            'YireoTraining_ExampleHyvaCheckoutShippingField::formShippingUpdated',
            'form:shipping:updated',
            function (EntityFormInterface $form, MagewireAddressFormInterface $addressComponent) {
                $field = $form->getField('example1');
                if (!$field) {
                    return $form;
                }

                $value = $field->getValue();
                $addressComponent->getAddressType()->getQuoteAddress()->setData('example1', $value);

                return $form;
            }
        );

        $form->registerModificationListener(
            'YireoTraining_ExampleHyvaCheckoutShippingField::formInit',
            'form:init',
            function (EntityFormInterface $form) {
                $field = $form->getField('email');
                //$field->setData('class_element', ["relative before:content-['Hello_World'] before:absolute before:top-0 before:left-0"]);
                //$field->setData('class_wrapper', ['bg-indigo-500']);
                //$field->setClassElement(['foobar']);
            }
        );

        return $form;
    }
}
