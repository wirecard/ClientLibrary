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

/**
 * QentaCEE_QPay_Response_Toolkit_GetOrderDetails test case.
 */
use PHPUnit\Framework\TestCase;
use QentaCEE\QPay\ToolkitClient;
use QentaCEE\QPay\Response\Toolkit\Order;

class QentaCEE_QPay_Response_Toolkit_OrderTest extends TestCase
{
    protected $_secret = 'B8AKTPWBRMNBV455FG6M2DANE99WU2';
    protected $_customerId = 'D200001';
    protected $_shopId = '';
    protected $_language = 'en';
    protected $_toolkitPassword = 'jcv45z';
    protected $_orderNumber = 5472113;

    /**
     * @var Order
     */
    private $object;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $customerId      = $this->_customerId;
        $shopId          = $this->_shopId;
        $secret          = $this->_secret;
        $language        = $this->_language;
        $toolkitPassword = $this->_toolkitPassword;

        $oToolkitClient = new ToolkitClient(Array(
            'CUSTOMER_ID'      => $customerId,
            'SHOP_ID'          => $shopId,
            'SECRET'           => $secret,
            'LANGUAGE'         => $language,
            'TOOLKIT_PASSWORD' => $toolkitPassword
        ));

        $this->object = $oToolkitClient->getOrderDetails($this->_orderNumber)->getOrder();
    }

    public function testGetMerchantNumber()
    {
        $this->assertEquals(1, $this->object->getMerchantNumber());
    }

    public function testGetOrderNumber()
    {
        $this->assertEquals($this->_orderNumber, $this->object->getOrderNumber());
    }

    public function testGetPaymentType()
    {
        $this->assertEquals('PSC', $this->object->getPaymentType());
    }

    public function testGetAmount()
    {
        $this->assertEquals('1.00', $this->object->getAmount());
    }

    public function testGetBrand()
    {
        $this->assertEquals('paysafecard', $this->object->getBrand());
    }


    public function testGetCurrency()
    {
        $this->assertEquals('EUR', $this->object->getCurrency());
    }


    public function testGetOrderDescription()
    {
        $this->assertEquals('Margit Hinterknofler, K-Nr: 86941', $this->object->getOrderDescription());
    }

    public function testGetAcquirer()
    {
        $this->assertEquals('', $this->object->getAcquirer());
    }

    public function testGetContractNumber()
    {
        $this->assertEquals('', $this->object->getContractNumber());
    }

    public function testGetOperationsAllowed()
    {
        $this->assertEquals(Array(), $this->object->getOperationsAllowed());
    }

    public function testGetOrderReference()
    {
        $this->assertEquals('OR-5472113', $this->object->getOrderReference());
    }

    public function testGetCustomerStatement()
    {
        $this->assertEquals('Danke für den Einkauf!', $this->object->getCustomerStatement());
    }

    public function testGetOrderText()
    {
        $this->assertEquals('', $this->object->getOrderText());
    }

    public function testGetTimeCreated()
    {
        $this->assertInstanceOf(DateTime::class, $this->object->getTimeCreated());
    }

    public function testGetTimeModified()
    {
        $this->assertInstanceOf(DateTime::class, $this->object->getTimeModified());
    }

    public function testGetState()
    {
        $this->assertEquals('ORDERED', $this->object->getState());
    }

    public function testGetSourceOrderNumber()
    {
        $this->assertEquals('', $this->object->getSourceOrderNumber());
    }

    public function testGetPayments()
    {
        $payments = $this->object->getPayments();
        $this->assertTrue($payments->valid());
        $payments->next();
        $this->assertFalse($payments->valid());
    }

    public function testGetCredits()
    {
        $credits = $this->object->getCredits();
        $this->assertFalse($credits->valid());
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        $this->object = null;

        parent::tearDown();
    }
}

