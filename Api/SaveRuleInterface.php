<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;
use Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface;

/**
 * Save rule data interface
 *
 * @api
 */
interface SaveRuleInterface
{
    /**
     * Save rule
     *
     * @param RuleInterface $rule
     * @return RuleInterface
     * @throws CouldNotSaveException
     * @throws ValidationException
     */
    public function execute(RuleInterface $rule): RuleInterface;
}
