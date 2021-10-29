<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Test\Api;

use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Validate rule provider test
 */
class ValidationExceptionTest extends WebapiAbstract
{
    /**
     * Resource path of rest api
     */
    private const RESOURCE_PATH = '/V1/eriocnemis/salesAutoCancelRule/validate';

    /**
     * Soap service name
     */
    private const SERVICE_NAME = 'eriocnemisSalesAutoCancelRuleApiRuleRepositoryV1';

    /**
     * Soap service version
     */
    private const SERVICE_VERSION = 'V1';

    /**
     * Soap service operation
     */
    private const SERVICE_OPERATION = 'validate';

    /**
     * Expected response message
     */
    private const EXPECTED_MESSAGE = 'Validation Failed';

    /**
     * @var mixed[]
     */
    private $data = [
        'name' => '',
        'duration_unit' => 24,
        'duration' => 2,
        'customer_notified' => 0,
        'visible_on_front' => 1,
        'status' => 0,
        'store_ids' => [1],
        'customer_group_ids' => [0, 1, 2, 3],
        'methods_access' => 0,
        'payment_method' => [
            'cashondelivery',
            'checkmo'
        ]
    ];

    /**
     * Test get rule by id API
     *
     * @return void
     * @test
     */
    public function execute()
    {
        $serviceInfo = $this->getServiceInfo();
        $requestData = ['rule' => $this->getFixtureData()];

        try {
            $this->_webApiCall($serviceInfo, $requestData);
            $this->fail('Expected throwing exception');
        } catch (\SoapFault $e) {
            $this->assertSoapException($e);
        } catch (\Exception $e) {
            if (constant('TESTS_WEB_API_ADAPTER') === self::ADAPTER_REST) {
                $this->assertRestException($e);
            } else {
                throw $e;
            }
        }
    }

    /**
     * Retrieve service info
     *
     * @return mixed[]
     */
    private function getServiceInfo()
    {
        return [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod' => Request::HTTP_METHOD_POST
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'serviceVersion' => self::SERVICE_VERSION,
                'operation' => self::SERVICE_NAME . self::SERVICE_OPERATION
            ]
        ];
    }

    /**
     * Retrieve fixture data of the rule
     *
     * @return mixed[]
     */
    private function getFixtureData()
    {
        return $this->data;
    }

    /**
     * Assert rest exception
     *
     * @param \Exception $e
     * @return void
     */
    private function assertRestException($e)
    {
        $errorData = $this->processRestExceptionResult($e);

        self::assertEquals(self::EXPECTED_MESSAGE, $errorData['message']);
        self::assertEquals(Exception::HTTP_BAD_REQUEST, $e->getCode());
    }

    /**
     * Assert soap exception
     *
     * @param \SoapFault $e
     * @return void
     */
    private function assertSoapException($e)
    {
        $this->assertInstanceOf('SoapFault', $e);
        $this->checkSoapFault($e, self::EXPECTED_MESSAGE, 'env:Sender');
    }
}
