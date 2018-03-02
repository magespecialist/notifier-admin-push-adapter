<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\AdminPush\Command;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Delete AdminPush by adminPushId command (Service Provider Interface - SPI)
 *
 * Separate command interface to which Repository proxies initial Delete call, could be considered as SPI - Interfaces
 * that you should extend and implement to customize current behaviour, but NOT expected to be used (called) in the code
 * of business logic directly
 *
 * @see \MSP\NotifierAdminPushAdapterApi\Api\AdminPushRepositoryInterface
 * @api
 */
interface DeleteInterface
{
    /**
     * Delete AdminPush data by given adminPushId
     *
     * @param int $adminPushId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $adminPushId);
}
