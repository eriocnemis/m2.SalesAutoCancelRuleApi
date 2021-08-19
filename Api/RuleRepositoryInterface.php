<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleSearchResultInterface;

/**
 * Rules repository interface
 *
 * Repository considered as an implementation of Facade pattern which provides a simplified
 * interface for proper work of WebApi request parser.
 *
 * It's not recommended to use(Only WebApi).
 *
 * @api
 */
interface RuleRepositoryInterface
{
    /**
     * Retrieve rule by id
     *
     * @param int $ruleId
     * @return \Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($ruleId): RuleInterface;

    /**
     * Retrieve list of rules
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): RuleSearchResultInterface;

    /**
     * Validate rule
     *
     * @param RuleInterface $rule
     * @return bool
     * @throws \Magento\Framework\Validation\ValidationException
     */
    public function validate(RuleInterface $rule): bool;

    /**
     * Save rule
     *
     * @param RuleInterface $rule
     * @return \Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Validation\ValidationException
     */
    public function save(RuleInterface $rule): RuleInterface;

    /**
     * Delete by id
     *
     * @param int $ruleId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete($ruleId): bool;
}
