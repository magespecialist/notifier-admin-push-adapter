<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\AdminPush\Command;

use Magento\Framework\Exception\NoSuchEntityException;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;

/**
 * Get next AdminPush message (Service Provider Interface - SPI)
 *
 * Separate command interface to which Repository proxies get next message call, could be considered as SPI - Interfaces
 * that you should extend and implement to customize current behaviour, but NOT expected to be used (called) in the code
 * of business logic directly
 *
 * @see \MSP\NotifierAdminPushAdapterApi\Api\AdminPushRepositoryInterface
 * @api
 */
interface GetNextMessageInterface
{
    /**
     * Save AdminPush data
     *
     * @param string $userName
     * @param int $fromDate
     * @param int $fromId
     * @return AdminPushInterface
     * @throws NoSuchEntityException
     */
    public function execute(string $userName, int $fromDate = 0, int $fromId = 0): AdminPushInterface;
}
