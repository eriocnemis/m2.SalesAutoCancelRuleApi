<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface;

/**
 * Get rule by id interface
 *
 * @api
 */
interface GetRuleByIdInterface
{
    /**
     * Retrieve rule by id
     *
     * @param int $ruleId
     * @return RuleInterface
     * @throws NoSuchEntityException
     */
    public function execute($ruleId): RuleInterface;
}
