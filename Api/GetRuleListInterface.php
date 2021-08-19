<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleSearchResultInterface;

/**
 * Find rules by search criteria interface
 *
 * @api
 */
interface GetRuleListInterface
{
    /**
     * Retrieve list of rules
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return RuleSearchResultInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): RuleSearchResultInterface;
}
