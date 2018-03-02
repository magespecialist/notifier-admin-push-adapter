<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\AdminPush\Command;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Clear AdminPush queue command (Service Provider Interface - SPI)
 *
 * Separate command interface to which Repository proxies initial Clear call, could be considered as SPI - Interfaces
 * that you should extend and implement to customize current behaviour, but NOT expected to be used (called) in the code
 * of business logic directly
 *
 * @see \MSP\NotifierAdminPushAdapterApi\Api\AdminPushRepositoryInterface
 * @api
 */
interface ClearInterface
{
    /**
     * Delete AdminPush data by given adminPushId
     *
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute();
}
