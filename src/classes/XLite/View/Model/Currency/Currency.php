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
 * @link      http://www.litecommerce.com/
 * @see       ____file_see____
 * @since     1.0.0
 */

namespace XLite\View\Model\Address;

/**
 * Currency model widget
 *
 * @see   ____class_see____
 * @since 1.0.0
 */
class Currency extends \XLite\View\Model\AModel
{
    /**
     * Schema of the address section
     * TODO: move to the module where this field is required:
     *   'address_type' => array(
     *       self::SCHEMA_CLASS    => '\XLite\View\FormField\Select\AddressType',
     *       self::SCHEMA_LABEL    => 'Address type',
     *       self::SCHEMA_REQUIRED => true,
     *   ),
     *
     * @var   array
     * @see   ____var_see____
     * @since 1.0.0
     */
    protected $addressSchema = array(
        'title' => array(
            self::SCHEMA_CLASS    => '\XLite\View\FormField\Select\Title',
            self::SCHEMA_LABEL    => 'Title',
            self::SCHEMA_REQUIRED => false,
            \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-title',
        ),
        'firstname' => array(
            self::SCHEMA_CLASS    => '\XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Firstname',
            self::SCHEMA_REQUIRED => true,
            \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-firstname',
        ),
        'lastname' => array(
            self::SCHEMA_CLASS    => '\XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Lastname',
            self::SCHEMA_REQUIRED => true,
            \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-lastname',
        ),
        'street' => array(
            self::SCHEMA_CLASS    => '\XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Address',
            self::SCHEMA_REQUIRED => true,
            \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-street',
        ),
        'country_code' => array(
            self::SCHEMA_CLASS => '\XLite\View\FormField\Select\Country',
            self::SCHEMA_LABEL => 'Country',
            self::SCHEMA_REQUIRED => true,
            \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-country',
        ),
        'state_id' => array(
            self::SCHEMA_CLASS    => '\XLite\View\FormField\Select\State',
            self::SCHEMA_LABEL    => 'State',
            self::SCHEMA_REQUIRED => true,
            \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-state',
        ),
        'custom_state' => array(
            self::SCHEMA_CLASS    => '\XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'State',
            self::SCHEMA_REQUIRED => false,
            \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-customer-state',
        ),
        'city' => array(
            self::SCHEMA_CLASS    => '\XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'City',
            self::SCHEMA_REQUIRED => true,
            \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-city',
        ),
        'zipcode' => array(
            self::SCHEMA_CLASS    => '\XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Zip code',
            self::SCHEMA_REQUIRED => true,
            \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-zipcode',
        ),
        'phone' => array(
            self::SCHEMA_CLASS    => '\XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Phone',
            self::SCHEMA_REQUIRED => true,
            \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-phone',
        ),
    );

    /**
     * Currency (cache)
     *
     * @var   \XLite\Model\Currency
     * @see   ____var_see____
     * @since 1.0.0
     */
    protected $currency = null;

    /**
     * getAddressSchema
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getAddressSchema()
    {
        $result = array();

        $addressId = $this->getAddressId();

        foreach ($this->addressSchema as $key => $data) {
            $result[$addressId . '_' . $key] = $data;
        }

        return $result;
    }

    /**
     * Return fields list by the corresponding schema
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getFormFieldsForSectionDefault()
    {
        $result = $this->getFieldsBySchema($this->getAddressSchema());

        // For country <-> state syncronization
        $this->setStateSelectorIds($result);

        return $result;
    }

    /**
     * Returns widget head
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getHead()
    {
        return 'Currency management page';
    }

    protected function getRequestCurrencyId()
    {
        return \XLite\Core\Request::getInstance()->currency_id;
    }

    protected function getCurrencyId()
    {
        return $this->getRequestCurrencyId() ?: null;
    }

    /**
     * This object will be used if another one is not pased
     *
     * @return \XLite\Model\Currency
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getDefaultModelObject()
    {
        if (!isset($this->currency)) {

            $this->currency = \XLite\Core\Database::getRepo('XLite\Model\Currency')->find($this->getCurrencyId());
        }

        return $this->currency;
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getFormClass()
    {
        return '\XLite\View\Form\Currency\Currency';
    }

    /**
     * Return text for the "Submit" button
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getSubmitButtonLabel()
    {
        return 'Save changes';
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getFormButtons()
    {
        $result = parent::getFormButtons();

        $result['submit'] = new \XLite\View\Button\Submit(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL => $this->getSubmitButtonLabel(),
                \XLite\View\Button\AButton::PARAM_STYLE => 'action',
            )
        );

        return $result;
    }
}