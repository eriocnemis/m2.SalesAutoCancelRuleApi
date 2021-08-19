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
 * Get rule by id provider with NoSuchEntityException test
 */
class NoSuchEntityExceptionTest extends WebapiAbstract
{
    /**
     * Resource path of rest api
     */
    private const RESOURCE_PATH = '/V1/eriocnemis/salesAutoCancelRule';

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
    private const SERVICE_OPERATION = 'get';

    /**
     * Expected response message
     */
    private const EXPECTED_MESSAGE = 'Rule with id "%value" does not exist.';

    /**
     * Test get rule by id API with NoSuchEntityException
     *
     * @return void
     * @test
     * @throws \Exception
     */
    public function execute()
    {
        $notExistingId = -1;
        $serviceInfo = $this->getServiceInfo($notExistingId);

        try {
            (constant('TESTS_WEB_API_ADAPTER') === self::ADAPTER_REST)
                ? $this->_webApiCall($serviceInfo)
                : $this->_webApiCall($serviceInfo, ['ruleId' => $notExistingId]);
            $this->fail('Expected throwing exception');
        } catch (\SoapFault $e) {
            $this->assertSoapException($notExistingId, $e);
        } catch (\Exception $e) {
            if (constant('TESTS_WEB_API_ADAPTER') === self::ADAPTER_REST) {
                $this->assertRestException($notExistingId, $e);
            } else {
                throw $e;
            }
        }
    }

    /**
     * Retrieve service info
     *
     * @param int $ruleId
     * @return mixed[]
     */
    private function getServiceInfo($ruleId)
    {
        return [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '/' . $ruleId,
                'httpMethod' => Request::HTTP_METHOD_GET
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'serviceVersion' => self::SERVICE_VERSION,
                'operation' => self::SERVICE_NAME . self::SERVICE_OPERATION
            ]
        ];
    }

    /**
     * Assert rest exception
     *
     * @param int $ruleId
     * @param \Exception $e
     * @return void
     */
    private function assertRestException($ruleId, $e)
    {
        $errorData = $this->processRestExceptionResult($e);

        self::assertEquals(self::EXPECTED_MESSAGE, $errorData['message']);
        self::assertEquals($ruleId, $errorData['parameters']['value']);
        self::assertEquals(Exception::HTTP_NOT_FOUND, $e->getCode());
    }

    /**
     * Assert soap exception
     *
     * @param int $ruleId
     * @param \SoapFault $e
     * @return void
     */
    private function assertSoapException($ruleId, $e)
    {
        $this->assertInstanceOf('SoapFault', $e);
        $this->checkSoapFault($e, self::EXPECTED_MESSAGE, 'env:Sender', ['value' => $ruleId]);
    }
}
