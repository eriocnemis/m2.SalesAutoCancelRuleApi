<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Api;

use Magento\Framework\Validation\ValidationException;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface;

/**
 * Validate rule data interface
 *
 * @api
 */
interface ValidateRuleInterface
{
    /**
     * Validate rule
     *
     * @param RuleInterface $rule
     * @return bool
     * @throws ValidationException
     */
    public function execute(RuleInterface $rule): bool;
}
