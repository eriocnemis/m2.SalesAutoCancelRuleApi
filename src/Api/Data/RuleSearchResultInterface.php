<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Rule search results interface
 *
 * @api
 */
interface RuleSearchResultInterface extends SearchResultsInterface
{
    /**
     * Retrieve rules
     *
     * @return \Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface[]
     */
    public function getItems();

    /**
     * Set rules
     *
     * @param \Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
