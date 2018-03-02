<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model;

use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;

/**
 * Extension attribute loader for AdminPush
 *
 * @api
 */
interface AdminPushExtensionLoaderInterface
{
    /**
     * Load extension attributes
     * @param AdminPushInterface $adminPush
     */
    public function execute(AdminPushInterface $adminPush);
}
