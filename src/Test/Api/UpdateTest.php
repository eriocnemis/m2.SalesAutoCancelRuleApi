<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Test\Api;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterfaceFactory;
use Eriocnemis\SalesAutoCancelRuleApi\Api\RuleRepositoryInterface;

/**
 * Update rule provider test
 */
class UpdateTest extends WebapiAbstract
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
    private const SERVICE_OPERATION = 'save';

    /**
     * @var RuleInterface|null
     */
    private $rule;

    /**
     * @var RuleInterfaceFactory
     */
    private $ruleFactory;

    /**
     * @var RuleRepositoryInterface
     */
    private $ruleRepository;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;

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
     * @var mixed[]
     */
    private $newData = [
        'name' => 'New Name of Test',
        'duration_unit' => 1,
        'duration' => 5,
        'customer_notified' => 1,
        'visible_on_front' => 0,
        'status' => 0,
        'store_ids' => [1],
        'customer_group_ids' => [0],
        'methods_access' => 0,
        'payment_method' => [
            'checkmo'
        ]
    ];

    /**
     * This method is called before a test is executed
     *
     * @return void
     */
    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();

        $this->ruleFactory = $objectManager->create(RuleInterfaceFactory::class);
        $this->ruleRepository = $objectManager->create(RuleRepositoryInterface::class);
        $this->dataObjectHelper = $objectManager->create(DataObjectHelper::class);
        $this->dataObjectProcessor = $objectManager->create(DataObjectProcessor::class);

        parent::setUp();
    }

    /**
     * This method is called after a test is executed
     */
    protected function tearDown(): void
    {
        if (null !== $this->rule) {
            $this->ruleRepository->delete((int)$this->rule->getId());
            $this->rule = null;
        }
    }

    /**
     * Test get rule by id API
     *
     * @return void
     * @test
     */
    public function execute()
    {
        $this->createTempData();

        if (null !== $this->rule) {
            $fixtureData = $this->getNewFixtureData() + $this->dataObjectProcessor->buildOutputDataArray(
                $this->rule,
                RuleInterface::class
            );

            $serviceInfo = $this->getServiceInfo((int)$this->rule->getId());
            $requestData = ['rule' => $this->getNewFixtureData()];

            $response = $this->_webApiCall($serviceInfo, $requestData);

            $ruleId = null;
            if (is_array($response) && !empty($response['id'])) {
                $ruleId = $response['id'];
            }
            $this->assertNotNull($ruleId);

            $this->rule = $this->ruleRepository->get($ruleId);
            $ruleData = $this->dataObjectProcessor->buildOutputDataArray(
                $this->rule,
                RuleInterface::class
            );

            $this->assertEquals($fixtureData, $ruleData, 'Rule data is invalid.');
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
                'httpMethod' => Request::HTTP_METHOD_PUT
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'serviceVersion' => self::SERVICE_VERSION,
                'operation' => self::SERVICE_NAME . self::SERVICE_OPERATION
            ]
        ];
    }

    /**
     * Add test data to database
     *
     * @return void
     */
    private function createTempData()
    {
        $rule = $this->ruleFactory->create();
        $this->dataObjectHelper->populateWithArray($rule, $this->getFixtureData(), RuleInterface::class);
        $this->rule = $this->ruleRepository->save($rule);

        $this->assertInstanceOf(RuleInterface::class, $this->rule);
    }

    /**
     * Retrieve fixture data of the rule
     *
     * @return mixed[]
     */
    private function getFixtureData()
    {
        if ($this->rule) {
            $this->data['id'] = $this->rule->getId();
        }
        return $this->data;
    }

    /**
     * Retrieve new fixture data of the rule
     *
     * @return mixed[]
     */
    private function getNewFixtureData()
    {
        if ($this->rule) {
            $this->newData['id'] = $this->rule->getId();
        }
        return $this->newData;
    }
}
