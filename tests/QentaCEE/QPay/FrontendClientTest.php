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
 * QentaCEE_QPayFrontendClient test case.
 */
use PHPUnit\Framework\TestCase;
use QentaCEE\Stdlib\Basket;
use QentaCEE\QPay\Response\Initiation;
class QentaCEE_QPay_FrontendClientTest extends TestCase
{
    /**
     *
     * @var array
     */
    protected $aUserConfig;

    /**
     *
     * @var array
     */
    protected $aClientConfig;

    /**
     *
     * @var QentaCEE_QPay_FrontendClient
     */
    private $object;

    /**
     * @var array
     */
    protected $aExpectedRequestData;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->object               = new QentaCEE\QPay\FrontendClient();
        $this->aUserConfig          = QentaCEE\QPay\Module::getConfig();
        $this->aClientConfig        = QentaCEE\QPay\Module::getClientConfig();
        $this->aExpectedRequestData = array(
            QentaCEE\QPay\FrontendClient::CUSTOMER_ID => $this->aUserConfig['QentaCEEQPayConfig']['CUSTOMER_ID'],
            QentaCEE\QPay\FrontendClient::SHOP_ID => $this->aUserConfig['QentaCEEQPayConfig']['SHOP_ID'],
            QentaCEE\QPay\FrontendClient::LANGUAGE => $this->aUserConfig['QentaCEEQPayConfig']['LANGUAGE'],
        );
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        $this->object        = null;
        $this->aUserConfig   = null;
        $this->aClientConfig = null;
        parent::tearDown();
    }

    /**
     * @dataProvider provider
     */
    public function testConstructorArrayParam($aConfig)
    {
        $this->object = new QentaCEE\QPay\FrontendClient($aConfig);
        $this->assertEquals($this->aUserConfig['QentaCEEQPayConfig']['CUSTOMER_ID'],
            $this->object->getUserConfig()->get('CUSTOMER_ID'));
        $this->assertEquals($this->aUserConfig['QentaCEEQPayConfig']['SHOP_ID'],
            $this->object->getUserConfig()->get('SHOP_ID'));
        $this->assertEquals($this->aUserConfig['QentaCEEQPayConfig']['LANGUAGE'],
            $this->object->getUserConfig()->get('LANGUAGE'));
        $this->assertEquals($this->aUserConfig['QentaCEEQPayConfig']['SECRET'],
            $this->object->getUserConfig()->get('SECRET'));
    }

    /**
     * Tests QentaCEE_QPay_FrontendClient->setConfirmUrl()
     */
    public function testSetConfirmUrl()
    {
        $confirmUrl = 'http://foo.bar.com/tests/confirm.php';
        $this->object->setConfirmUrl($confirmUrl);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::CONFIRM_URL => $confirmUrl));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    /**
     * Tests QentaCEE_QPay_FrontendClient->setWindowName()
     */
    public function testSetWindowName()
    {
        $windowName = 'phpUnitWindow';
        $this->object->setWindowName($windowName);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::WINDOW_NAME => $windowName));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    /**
     * Tests QentaCEE_QPay_FrontendClient->setDuplicateRequestCheck()
     */
    public function testSetDuplicateRequestCheck()
    {
        $duplicateRequestCheck = 'yes';
        $this->object->setDuplicateRequestCheck($duplicateRequestCheck);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::DUPLICATE_REQUEST_CHECK => $duplicateRequestCheck));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->setCustomerStatement()
     */
    public function testSetCustomerStatement()
    {
        $customerStatement = 'cStatement';
        $this->object->setCustomerStatement($customerStatement);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::CUSTOMER_STATEMENT => $customerStatement));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->setOrderReference()
     */
    public function testSetOrderReference()
    {
        $orderReference = '123333';
        $this->object->setOrderReference($orderReference);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::ORDER_REFERENCE => $orderReference));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->setAutoDeposit()
     */
    public function testSetAutoDeposit()
    {
        $autoDeposit = 'yes';
        $this->object->setAutoDeposit($autoDeposit);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::AUTO_DEPOSIT => $autoDeposit));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->setMaxRetries()
     */
    public function testSetMaxRetries()
    {
        $maxRetries = '12';
        $this->object->setMaxRetries($maxRetries);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::MAX_RETRIES => $maxRetries));
        $this->assertEquals($expected, $this->object->getRequestData());

    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->createConsumerMerchantCrmId()
     */
    public function testCreateConsumerMerchantCrmId()
    {
        $email = 'email@address.com';
        $this->object->createConsumerMerchantCrmId($email);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::CONSUMER_MERCHANT_CRM_ID => md5($email)));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->createConsumerMerchantCrmId()
     */
    public function testSetShippingProfile()
    {
        $shippingProfile = 'SP_00001';
        $this->object->setShippingProfile($shippingProfile);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::SHIPPING_PROFILE => 'SP_00001'
        ));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->setMaxRetries()
     */
    public function testSetOrderNumber()
    {
        $orderNumber = '123321';
        $this->object->setOrderNumber($orderNumber);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::ORDER_NUMBER => $orderNumber));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->setConfirmMail()
     */
    public function testSetConfirmMail()
    {
        $confirmMail = 'test@example.com';
        $this->object->setConfirmMail($confirmMail);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::CONFIRM_MAIL => $confirmMail));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->setBasket()
     */
    public function testSetBasket()
    {
        $mock = $this->getMockBuilder(Basket::class)
            ->getMock();

        $mock->expects($this->once())
            ->method('getData')
            ->will($this->returnValue(array()));

        $this->object->setBasket($mock);
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->initiate()
     */
    public function testInitiate()
    {
        $consumerData = new QentaCEE\Stdlib\ConsumerData();
        $consumerData->setIpAddress('10.1.0.11');
        $consumerData->setUserAgent('phpUnit');

        $oResponse = $this->object->setAmount(100)
                                  ->setCurrency('eur')
                                  ->setPaymentType(QentaCEE\QPay\PaymentType::PAYPAL)
                                  ->setOrderDescription(__METHOD__)
                                  ->setSuccessUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setCancelUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setFailureUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setServiceUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setConfirmUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setConsumerData($consumerData)
                                  ->initiate();

        $this->assertInstanceOf(Initiation::class, $oResponse);
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertFalse($oResponse->getError());
        $this->assertFalse($oResponse->hasFailed());
        $this->assertStringStartsWith('https://', $oResponse->getRedirectUrl());
    }

    public function testClientFailedResponse()
    {
        $this -> expectException(QentaCEE\Stdlib\Exception\InvalidResponseException::class);
        $oResponse = new QentaCEE\QPay\Response\Initiation(new stdClass());
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->__construct()
     *
     * @dataProvider provider
     *
     * @param string $aConfig
     */
    public function testMissingConfigValueInConfigArray($aConfig)
    {
        $this -> expectException(QentaCEE\QPay\Exception\InvalidArgumentException::class);
        $aConfig['QentaCEEQPayConfig']['CUSTOMER_ID'] = null;
        $this->object                                    = new QentaCEE\QPay\FrontendClient($aConfig);

    }

    public function testFailedInitiate()
    {
        $this -> expectException(QentaCEE\QPay\Exception\InvalidArgumentException::class);
        $oResponse = $this->object->initiate();
    }

    public function testGetReponseBeforeInitialize()
    {
        $this -> expectException(Exception::class);
        $oResponse = $this->object->getResponse();
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->getResponse()
     */
    public function testGetResponse()
    {
        $consumerData = new QentaCEE\Stdlib\ConsumerData();
        $consumerData->setIpAddress('10.1.0.11');
        $consumerData->setUserAgent('phpUnit');

        $oResponse = $this->object->setAmount(100)
                                  ->setCurrency('eur')
                                  ->setPaymentType(QentaCEE\QPay\PaymentType::PAYPAL)
                                  ->setOrderDescription(__METHOD__)
                                  ->setSuccessUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setCancelUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setFailureUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setServiceUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setConfirmUrl('http://foo.bar.com/tests/confirm.php')
                                  ->setConsumerData($consumerData)
                                  ->initiate();

        $oResponse = $this->object->getResponse();

        
        $this->assertInstanceOf(Initiation::class, $oResponse);
        $this->assertEquals($oResponse->getStatus(), 0);
        $this->assertFalse($oResponse->getError());
        $this->assertFalse($oResponse->hasFailed());
        $this->assertStringStartsWith('https://', $oResponse->getRedirectUrl());
    }

    public function testConstructorWithInvalidParam()
    {
        $this -> expectException(Exception::class);
        $this->object = null;

        try {
            $this->object = new QentaCEE\QPay\FrontendClient(array());
        } catch (Exception $e) {
            $this->assertStringStartsWith('CUSTOMER_ID passed', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider provider
     */
    public function testConstructorWhenLanguageParamIsEmpty($aConfig)
    {
        $this -> expectException(QentaCEE\QPay\Exception\InvalidArgumentException::class);
        $aConfig['QentaCEEQPayConfig']['LANGUAGE'] = null;

        try {
            $this->object = new QentaCEE\QPay\FrontendClient($aConfig);
        } catch (QentaCEE\QPay\Exception\InvalidArgumentException $e) {
            $this->assertStringStartsWith('LANGUAGE passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @dataProvider provider
     */
    public function testConstructorWhenSecretParamIsEmpty($aConfig)
    {
        $this -> expectException(QentaCEE\QPay\Exception\InvalidArgumentException::class);
        $aConfig['QentaCEEQPayConfig']['SECRET'] = null;

        try {
            $this->object = new QentaCEE\QPay\FrontendClient($aConfig);
        } catch (QentaCEE\QPay\Exception\InvalidArgumentException $e) {
            $this->assertStringStartsWith('SECRET passed to', $e->getMessage());
            throw $e;
        }
    }

    /**
     * Tests QentaCEE\QPay\FrontendClient->getResponse()
     */
    public function testSetPluginVersion()
    {
        $sPluginVersion = $this->object->generatePluginVersion('phpunit', '1.0.0', 'phpunit', '1.0.0',
            Array('phpunit' => '3.5.15'));
        $this->object->setPluginVersion($sPluginVersion);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::PLUGIN_VERSION => $sPluginVersion));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    public function testSetFinancialInstitution()
    {
        $sFinancialInstitution = 'BA-CA';
        $this->object->setFinancialInstitution($sFinancialInstitution);

        $expected = array_merge($this->aExpectedRequestData, array(
            QentaCEE\QPay\FrontendClient::FINANCIAL_INSTITUTION => $sFinancialInstitution));
        $this->assertEquals($expected, $this->object->getRequestData());
    }

    public function testDisplayTextAndImageUrl()
    {
        $this->object->setDisplayText('display text')->setImageUrl('https://www.google.com/intl/en_ALL/images/logos/images_logo_lg.gif');
        $this->addToAssertionCount(1);
    }


    public function provider()
    {
        return Array(
            Array(
                Array(
                    'QentaCEEQPayConfig' => Array(
                        'CUSTOMER_ID' => 'D200001',
                        'SHOP_ID'     => '',
                        'SECRET'      => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
                        'LANGUAGE'    => 'en'
                    )
                )
            )
        );
    }

}
