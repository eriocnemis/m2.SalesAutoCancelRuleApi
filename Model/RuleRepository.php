<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleSearchResultInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\RuleRepositoryInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\GetRuleByIdInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\GetRuleListInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\ValidateRuleInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\SaveRuleInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\DeleteRuleByIdInterface;

/**
 * Rules repository facade
 *
 * Repository considered as an implementation of Facade pattern which provides a simplified
 * interface for proper work of WebApi request parser.
 *
 * It's not recommended to use(Only WebApi).
 *
 * @api
 */
class RuleRepository implements RuleRepositoryInterface
{
    /**
     * @var GetRuleByIdInterface
     */
    private $getRuleById;

    /**
     * @var GetRuleListInterface
     */
    private $getRuleList;

    /**
     * @var ValidateRuleInterface
     */
    private $validateRule;

    /**
     * @var SaveRuleInterface
     */
    private $saveRule;

    /**
     * @var DeleteRuleByIdInterface
     */
    private $deleteRule;

    /**
     * Initialize facade
     *
     * @param GetRuleByIdInterface $getRuleById
     * @param GetRuleListInterface $getRuleList
     * @param ValidateRuleInterface $validateRule
     * @param DeleteRuleByIdInterface $deleteRule
     * @param SaveRuleInterface $saveRule
     */
    public function __construct(
        GetRuleByIdInterface $getRuleById,
        GetRuleListInterface $getRuleList,
        ValidateRuleInterface $validateRule,
        DeleteRuleByIdInterface $deleteRule,
        SaveRuleInterface $saveRule
    ) {
        $this->getRuleById = $getRuleById;
        $this->getRuleList = $getRuleList;
        $this->validateRule = $validateRule;
        $this->deleteRule = $deleteRule;
        $this->saveRule = $saveRule;
    }

    /**
     * Retrieve rule by id
     *
     * @param int $ruleId
     * @return \Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($ruleId): RuleInterface
    {
        return $this->getRuleById->execute($ruleId);
    }

    /**
     * Retrieve list of rules
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): RuleSearchResultInterface
    {
        return $this->getRuleList->execute($searchCriteria);
    }

    /**
     * Validate rule
     *
     * @param RuleInterface $rule
     * @return bool
     * @throws \Magento\Framework\Validation\ValidationException
     */
    public function validate(RuleInterface $rule): bool
    {
        return $this->validateRule->execute($rule);
    }

    /**
     * Save rule
     *
     * @param RuleInterface $rule
     * @return \Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Validation\ValidationException
     */
    public function save(RuleInterface $rule): RuleInterface
    {
        return $this->saveRule->execute($rule);
    }

    /**
     * Delete by id
     *
     * @param int $ruleId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete($ruleId): bool
    {
        return $this->deleteRule->execute($ruleId);
    }
}
