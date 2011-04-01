<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * LiteCommerce
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@litecommerce.com so we can send you a copy immediately.
 * 
 * PHP version 5.3.0
 *
 * @category  LiteCommerce
 * @author    Creative Development LLC <info@cdev.ru> 
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   GIT: $Id$
 * @link      http://www.litecommerce.com/
 * @see       ____file_see____
 * @since     3.0.0
 */

namespace XLite\View\Form\Checkout;

/**
 * Checkout update profile form
 * 
 * @see   ____class_see____
 * @since 3.0.0
 */
class UpdateProfile extends \XLite\View\Form\Checkout\ACheckout
{
    /**
     * Get default form action 
     * 
     * @return string
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected function getDefaultAction()
    {
        return 'update_profile';
    }

    /**
     * Get validator
     *
     * @return \XLite\Core\Validator\HashArray
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected function getValidator()
    {
        $validator = parent::getValidator();

        $validator->addPair(
            'email',
            new \XLite\Core\Validator\String\Email,
            \XLite\Core\Validator\Pair\APair::SOFT
        );
        $validator->addPair(
            'create_profile',
            new \XLite\Core\Validator\String\Switcher(),
            \XLite\Core\Validator\Pair\APair::SOFT
        );
        $validator->addPair(
            'same_address',
            new \XLite\Core\Validator\String\Switcher(),
            \XLite\Core\Validator\Pair\APair::SOFT
        );

        $onlyCalculate = (bool)\XLite\Core\Request::getInstance()->only_calculate;
        $mode = $onlyCalculate
            ? \XLite\Core\Validator\Pair\APair::SOFT
            : \XLite\Core\Validator\Pair\APair::STRICT;
        $nonEmpty = !$onlyCalculate;

        // Shipping address
        $shippingAddress = $validator->addPair(
            'shippingAddress',
            new \XLite\Core\Validator\HashArray,
            \XLite\Core\Validator\Pair\APair::SOFT
        );
        $shippingAddress->addPair('name', new \XLite\Core\Validator\String($nonEmpty), $mode);
        $shippingAddress->addPair('street', new \XLite\Core\Validator\String($nonEmpty), $mode);
        $shippingAddress->addPair('city', new \XLite\Core\Validator\String($nonEmpty), $mode);
        $shippingAddress->addPair('zipcode', new \XLite\Core\Validator\String(true));
        $shippingAddress->addPair('phone', new \XLite\Core\Validator\String(), $mode);
        $shippingAddress->addPair(new \XLite\Core\Validator\Pair\CountryState());
        $shippingAddress->addPair(
            'save_as_new',
            new \XLite\Core\Validator\String\Switcher(),
            \XLite\Core\Validator\Pair\APair::SOFT
        );

        // Billing address
        $billingAddress = $validator->addPair(
            'billingAddress',
            new \XLite\Core\Validator\HashArray,
            \XLite\Core\Validator\Pair\APair::SOFT
        );
        $billingAddress->addPair('name', new \XLite\Core\Validator\String(true));
        $billingAddress->addPair('street', new \XLite\Core\Validator\String(true));
        $billingAddress->addPair('city', new \XLite\Core\Validator\String(true));
        $billingAddress->addPair('zipcode', new \XLite\Core\Validator\String(true));
        $billingAddress->addPair('phone', new \XLite\Core\Validator\String());
        $billingAddress->addPair(new \XLite\Core\Validator\Pair\CountryState());
        $billingAddress->addPair(
            'save_as_new',
            new \XLite\Core\Validator\String\Switcher(),
            \XLite\Core\Validator\Pair\APair::SOFT
        );

        return $validator;
    }
}
