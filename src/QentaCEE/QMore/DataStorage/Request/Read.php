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

namespace QentaCEE\QMore\DataStorage\Request;
use QentaCEE\Stdlib\Client\ClientAbstract;
use QentaCEE\QMore\DataStorage\Exception\InvalidArgumentException;
use QentaCEE\Stdlib\FingerprintOrder;
use QentaCEE\QMore\Module;
use QentaCEE\Stdlib\Config;

class Read extends ClientAbstract
{
    /**
     * Storage ID field name
     *
     * @var string
     */
    const STORAGE_ID = "storageId";

    /**
     *
     * @var int
     */
    protected $_fingerprintOrderType = 1;

    /**
     * Constructor
     *
     * @param array $aConfig
     *
     * @throws InvalidArgumentException
     */
    public function __construct($aConfig = null)
    {
        $this->_fingerprintOrder = new FingerprintOrder();

        //if no config was sent fallback to default config file
        if (is_null($aConfig)) {
            $aConfig = Module::getConfig();
        }

        if (isset( $aConfig['QentaCEEQMoreConfig'] )) {
            //we only need the QentaCEEQMoreConfig here
            $aConfig = $aConfig['QentaCEEQMoreConfig'];
        }

        //let's store configuration details in internal objects
        $this->oUserConfig   = new Config($aConfig);
        $this->oClientConfig = new Config(Module::getClientConfig());

        //now let's check if the CUSTOMER_ID, SHOP_ID, LANGUAGE and SECRET exist in $this->oUserConfig object that we created from config array
        $sCustomerId = isset( $this->oUserConfig->CUSTOMER_ID ) ? trim($this->oUserConfig->CUSTOMER_ID) : null;
        $sShopId     = isset( $this->oUserConfig->SHOP_ID ) ? trim($this->oUserConfig->SHOP_ID) : null;
        $sLanguage   = isset( $this->oUserConfig->LANGUAGE ) ? trim($this->oUserConfig->LANGUAGE) : null;
        $sSecret     = isset( $this->oUserConfig->SECRET ) ? trim($this->oUserConfig->SECRET) : null;


        //If not throw the InvalidArgumentException exception!
        if (empty( $sCustomerId ) || is_null($sCustomerId)) {
            throw new InvalidArgumentException(sprintf('CUSTOMER_ID passed to %s is invalid.',
                __METHOD__));
        }

        if (empty( $sLanguage ) || is_null($sLanguage)) {
            throw new InvalidArgumentException(sprintf('LANGUAGE passed to %s is invalid.',
                __METHOD__));
        }

        if (empty( $sSecret ) || is_null($sSecret)) {
            throw new InvalidArgumentException(sprintf('SECRET passed to %s is invalid.',
                __METHOD__));
        }

        //everything ok! let's set the fields
        $this->_setField(self::CUSTOMER_ID, $sCustomerId);
        $this->_setField(self::SHOP_ID, $sShopId);
        $this->_setField(self::LANGUAGE, $sLanguage);
        $this->_setSecret($sSecret);
    }

    /**
     *
     * @param mixed $storageId
     *
     * @return QentaCEE\QMore\DataStorage\Response\Read
     */
    public function read($storageId)
    {
        $this->_setField(self::STORAGE_ID, $storageId);

        $this->_fingerprintOrder->setOrder(Array(
            self::CUSTOMER_ID,
            self::SHOP_ID,
            self::STORAGE_ID,
            self::SECRET
        ));

        return new \QentaCEE\QMore\DataStorage\Response\Read($this->_send());
    }

    /**
     * @see QentaCEE\Stdlib\Client\ClientAbstract::_getRequestUrl()
     * @return string
     */
    protected function _getRequestUrl()
    {
        return $this->oClientConfig->DATA_STORAGE_URL . '/read';
    }

    /**
     * Returns the user agent string
     *
     * @return string
     */
    protected function _getUserAgent()
    {
        return "{$this->oClientConfig->MODULE_NAME};{$this->oClientConfig->MODULE_VERSION}";
    }
}