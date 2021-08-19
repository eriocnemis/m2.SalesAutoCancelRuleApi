<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\SalesAutoCancelRuleApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Rule interface
 *
 * @api
 */
interface RuleInterface extends ExtensibleDataInterface
{
    /**
     * Rule id field name
     */
    const RULE_ID = 'rule_id';

    /**
     * Name field name
     */
    const NAME = 'name';

    /**
     * Customer notified field name
     */
    const CUSTOMER_NOTIFIED = 'customer_notified';

    /**
     * Visible on front field name
     */
    const VISIBLE_ON_FRONT = 'visible_on_front';

    /**
     * To duration field name
     */
    const DURATION = 'duration';

    /**
     * To duration unit field name
     */
    const DURATION_UNIT = 'duration_unit';

    /**
     * Status field name
     */
    const STATUS = 'status';

    /**
     * Store ids field name
     */
    const STORE_IDS = 'store_ids';

    /**
     * Customer group ids field name
     */
    const CUSTOMER_GROUP_IDS = 'customer_group_ids';

    /**
     * Methods access field name
     */
    const METHODS_ACCESS = 'methods_access';

    /**
     * Payment method field name
     */
    const PAYMENT_METHOD = 'payment_method';

    /**
     * Retrieve rule id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set rule id
     *
     * @param int $ruleId
     * @return $this
     */
    public function setId(int $ruleId): RuleInterface;

    /**
     * Retrieve rule name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set rule name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): RuleInterface;

    /**
     * Retrieve a visible on storefront flag
     *
     * @return int
     */
    public function getVisibleOnFront(): int;

    /**
     * Set the visible on storefront flag
     *
     * @param int $flag
     * @return $this
     */
    public function setVisibleOnFront(int $flag): RuleInterface;

    /**
     * Retrieve a customer notified flag
     *
     * @return int
     */
    public function getCustomerNotified(): int;

    /**
     * Set the customer notified flag
     *
     * @param int $flag
     * @return $this
     */
    public function setCustomerNotified(int $flag): RuleInterface;

    /**
     * Retrieve a duration unit
     *
     * @return int
     */
    public function getDurationUnit(): int;

    /**
     * Set the duration unit
     *
     * @param int $durationUnit
     * @return $this
     */
    public function setDurationUnit(int $durationUnit): RuleInterface;

    /**
     * Retrieve a duration
     *
     * @return int
     */
    public function getDuration(): int;

    /**
     * Set the duration
     *
     * @param int $duration
     * @return $this
     */
    public function setDuration(int $duration): RuleInterface;

    /**
     * Whether the rule is active
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Set whether the rule is active
     *
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status): RuleInterface;

    /**
     * Retrieve a list of stores the rule applies to
     *
     * @return int[]
     */
    public function getStoreIds(): array;

    /**
     * Set the stores the rule applies to
     *
     * @param int[] $storeIds
     * @return $this
     */
    public function setStoreIds(array $storeIds): RuleInterface;

    /**
     * Retrieve a list of customer group ids the rule applies to
     *
     * @return int[]
     */
    public function getCustomerGroupIds(): array;

    /**
     * Set the customer group ids the rule applies to
     *
     * @param int[] $customerGroupIds
     * @return $this
     */
    public function setCustomerGroupIds(array $customerGroupIds): RuleInterface;

    /**
     * Whether the methods access
     *
     * @return int
     */
    public function getMethodsAccess(): int;

    /**
     * Set whether the methods access
     *
     * @param int $access
     * @return $this
     */
    public function setMethodsAccess(int $access): RuleInterface;

    /**
     * Retrieve a list of payment methods the rule applies to
     *
     * @return string[]
     */
    public function getPaymentMethod(): array;

    /**
     * Set the payment methods the rule applies to
     *
     * @param string[] $paymentMethods
     * @return $this
     */
    public function setPaymentMethod(array $paymentMethods): RuleInterface;

    /**
     * Retrieve existing extension attributes object or create a new one
     *
     * @return \Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object
     *
     * @param \Eriocnemis\SalesAutoCancelRuleApi\Api\Data\RuleExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(RuleExtensionInterface $extensionAttributes);
}
