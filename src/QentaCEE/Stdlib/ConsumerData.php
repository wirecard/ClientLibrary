<?php
/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Qenta Payment CEE GmbH
 * (abbreviated to Qenta CEE) and are explicitly not part of the Qenta CEE range of
 * products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License Version 2 (GPLv2) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Qenta CEE does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Qenta CEE does not guarantee their full
 * functionality neither does Qenta CEE assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Qenta CEE does not guarantee the full functionality
 * for customized shop systems or installed plugins of other vendors of plugins within the same
 * shop system.
 *
 * Customers are responsible for testing the plugin's functionality before starting productive
 * operation.
 *
 * By installing the plugin into the shop system the customer agrees to these terms of use.
 * Please do not use the plugin if you do not agree to these terms of use!
 */


namespace QentaCEE\Stdlib;
use QentaCEE\Stdlib\ConsumerData\Address;
class ConsumerData
{
    /**
     *
     * @var string[]
     */
    protected $_consumerData = Array();

    /**
     *
     * @var string
     */
    protected static $IP_ADDRESS = 'IpAddress';

    /**
     *
     * @var string
     */
    protected static $USER_AGENT = 'UserAgent';

    /**
     *
     * @var string
     */
    protected static $PREFIX = 'consumer';

    /**
     *
     * @var string
     */
    protected static $EMAIL = 'Email';

    /**
     *
     * @var string
     */
    protected static $BIRTH_DATE = 'BirthDate';

    /**
     * @var string
     */
    protected static $COMPANY_NAME = 'companyName';

    /**
     * @var string
     */
    protected static $COMPANY_VAT_ID = 'companyVatId';

    /**
     * @var string
     */
    protected static $COMPANY_TRADE_REGISTRY_NUMBER = 'companyTradeRegistryNumber';

    /**
     *
     * @var string
     */
    protected static $TAX_IDENTIFICATION_NUMBER = 'TaxIdentificationNumber';

    /**
     *
     * @var string
     */
    protected static $DRIVERS_LICENSE_NUMBER = 'DriversLicenseNumber';

    /**
     *
     * @var string
     */
    protected static $DRIVERS_LICENSE_COUNTRY = 'DriversLicenseCountry';

    /**
     *
     * @var string
     */
    protected static $DRIVERS_LICENSE_STATE = 'DriversLicenseState';

    /**
     *
     * @var string
     */
    protected static $BIRTH_DATE_FORMAT = 'Y-m-d';

    /**
     * setter for the mail address of the consumer
     *
     * @param string $mailAddress
     *
     * @return ConsumerData
     */
    public function setEmail($mailAddress)
    {
        $this->_setField(self::$EMAIL, $mailAddress);

        return $this;
    }

    /**
     * setter for the birthdate of the consumer
     *
     * @param \DateTime $birthDate
     *
     * @return ConsumerData
     */
    public function setBirthDate(\DateTime $birthDate)
    {
        $this->_setField(self::$BIRTH_DATE, $birthDate->format(self::$BIRTH_DATE_FORMAT));

        return $this;
    }

    /**
     * setter for the tax identification number of the consumer
     *
     * @param string $taxIdentificationNumber
     *
     * @return ConsumerData
     */
    public function setTaxIdentificationNumber($taxIdentificationNumber)
    {
        $this->_setField(self::$TAX_IDENTIFICATION_NUMBER, $taxIdentificationNumber);

        return $this;
    }

    /**
     * setter for the drivers license number of the consumer
     *
     * @param string $driversLicenseNumber
     *
     * @return ConsumerData
     */
    public function setDriversLicenseNumber($driversLicenseNumber)
    {
        $this->_setField(self::$DRIVERS_LICENSE_NUMBER, $driversLicenseNumber);

        return $this;
    }

    /**
     * setter for the drivers license country of the consumer
     *
     * @param string $driversLicenseCountry
     *
     * @return ConsumerData
     */
    public function setDriversLicenseCountry($driversLicenseCountry)
    {
        $this->_setField(self::$DRIVERS_LICENSE_COUNTRY, $driversLicenseCountry);

        return $this;
    }

    /**
     * setter for the drivers license state of the consumer
     *
     * @param string $driversLicenseState
     *
     * @return ConsumerData
     */
    public function setDriversLicenseState($driversLicenseState)
    {
        $this->_setField(self::$DRIVERS_LICENSE_STATE, $driversLicenseState);

        return $this;
    }

    /**
     * @param string $companyName
     *
     * @return ConsumerData
     */
    public function setCompanyName($companyName)
    {
        $this->_setField(self::$COMPANY_NAME, $companyName);

        return $this;
    }

    /**
     * @param string $companyVatId
     *
     * @return ConsumerData
     */
    public function setCompanyVatId($companyVatId)
    {
        $this->_setField(self::$COMPANY_VAT_ID, $companyVatId);

        return $this;
    }

    /**
     * @param string $companyTradeRegistryNumber
     *
     * @return ConsumerData
     */
    public function setCompanyTradeRegistryNumber($companyTradeRegistryNumber)
    {
        $this->_setField(self::$COMPANY_TRADE_REGISTRY_NUMBER, $companyTradeRegistryNumber);

        return $this;
    }

    /**
     * adds addressinformation to the consumerdata.
     * used {@link ConsumerData::getData()}
     *
     * @param QentaCEE\Stdlib\ConsumerData\Address $address
     *
     * @return ConsumerData
     */
    public function addAddressInformation(Address $address)
    {
        $consumerData        = array_merge($this->_consumerData, $address->getData());
        $this->_consumerData = $consumerData;

        return $this;
    }

    /**
     * setter for the consumer IP-Address
     *
     * @param string $consumerIpAddress
     *
     * @return ConsumerData
     */
    public function setIpAddress($consumerIpAddress)
    {
        $this->_setField(self::$IP_ADDRESS, $consumerIpAddress);

        return $this;
    }

    /**
     * setter for the consumer user-agent
     *
     * @param string $consumerUserAgent
     *
     * @return ConsumerData
     */
    public function setUserAgent($consumerUserAgent)
    {
        $this->_setField(self::$USER_AGENT, $consumerUserAgent);

        return $this;
    }

    /**
     * Getter for all consumerData
     *
     * @return string[]
     */
    public function getData()
    {
        return $this->_consumerData;
    }

    /**
     * Static getter for consumerUserAgentField
     *
     * @return string
     */
    public static function getConsumerUserAgentFieldName()
    {
        return self::$PREFIX . self::$USER_AGENT;
    }

    /**
     * Static getter for consumerIpField
     *
     * @return string
     */
    public static function getConsumerIpAddressFieldName()
    {
        return self::$PREFIX . self::$IP_ADDRESS;
    }

    /**
     * setter for consumerdata fields
     *
     * @param string $name
     * @param string $value
     *
     * @access private
     */
    protected function _setField($name, $value)
    {
        // e.g. consumerBillingFirstname
        $this->_consumerData[self::$PREFIX . $name] = (string) $value;
    }
}