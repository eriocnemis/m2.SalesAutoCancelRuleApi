<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Test\Api;

use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Validate rule provider test
 */
class ValidateTest extends WebapiAbstract
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
     * @var mixed[]
     */
    private $data = [
        'name' => 'Test',
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

        $result = false;
        $response = $this->_webApiCall($serviceInfo, $requestData);
        if (is_bool($response)) {
            $result = (bool)$response;
        }
        $this->assertTrue($result);
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
}
