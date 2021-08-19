<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Test\Api;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterfaceFactory;
use Eriocnemis\SalesAutoCancelRuleApi\Api\RuleRepositoryInterface;

/**
 * Get rule list provider test
 */
class GetListTest extends WebapiAbstract
{
    /**
     * Resource path of rest api
     */
    private const RESOURCE_PATH = '/V1/eriocnemis/salesAutoCancelRule/search';

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
    private const SERVICE_OPERATION = 'getList';

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
     * This method is called before a test is executed
     *
     * @return void
     */
    protected function setUp()
    {
        $objectManager = Bootstrap::getObjectManager();

        $this->ruleFactory = $objectManager->create(RuleInterfaceFactory::class);
        $this->ruleRepository = $objectManager->create(RuleRepositoryInterface::class);
        $this->dataObjectHelper = $objectManager->create(DataObjectHelper::class);

        parent::setUp();
    }

    /**
     * This method is called after a test is executed
     */
    protected function tearDown()
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
            $searchCriteria = $this->getSearchCriteria();
            $serviceInfo = $this->getServiceInfo($searchCriteria);

            $response = $this->_webApiCall($serviceInfo, $searchCriteria);

            if (is_array($response)) {
                $this->assertArrayHasKey('search_criteria', $response);
                $this->assertArrayHasKey('total_count', $response);
                $this->assertArrayHasKey('items', $response);

                $this->assertEquals($searchCriteria['searchCriteria'], $response['search_criteria']);
                $this->assertTrue($response['total_count'] == 1);
                $this->assertCount(1, $response['items']);

                $this->assertNotNull($response['items'][0]['id']);
                $this->assertEquals($this->getFixtureData(), $response['items'][0]);
            } else {
                $this->fail('Wrong response data format');
            }
        }
    }

    /**
     * Retrieve service info
     *
     * @param mixed[] $searchCriteria
     * @return mixed[]
     */
    private function getServiceInfo($searchCriteria)
    {
        return [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?' . http_build_query($searchCriteria),
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
     * Retrieve search criteria
     *
     * @return mixed[]
     */
    private function getSearchCriteria()
    {
        return [
            'searchCriteria' => [
                'filter_groups' => [
                    [
                        'filters' => [
                            [
                                'field' => 'rule_id',
                                'value' => $this->rule ? $this->rule->getId() : null,
                                'condition_type' => 'eq',
                            ]
                        ]
                    ]
                ],
                'current_page' => 1,
                'page_size' => 2,
            ]
        ];
    }
}
