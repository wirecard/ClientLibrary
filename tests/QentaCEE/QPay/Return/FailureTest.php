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
use PHPUnit\Framework\TestCase;

class QentaCEE_QPay_Return_FailureTest extends TestCase
{

    /**
     * @var QentaCEE_QPay_Return_Failure
     */
    protected $object;

    //qpay
    protected $_returnData = Array(
        'paymentState'    => 'FAILURE',
        'message'         => 'Language is missing.',
        'consumerMessage' => 'Language is missing.'
    );

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new QentaCEE\QPay\Returns\Failure($this->_returnData);
    }

    public function testValidate()
    {
        $this->assertTrue($this->object->validate());
    }

    public function testGetErrors()
    {
        foreach ($this->object->getErrors() as $error) {
            $this->assertEquals('Language is missing.', $error->getMessage());
            $this->assertEquals('Language is missing.', $error->getConsumerMessage());
        }
        $this->addToAssertionCount(1);
    }
}

