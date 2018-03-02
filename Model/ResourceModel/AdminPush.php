<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class AdminPush extends AbstractDb
{
    const TABLE_NAME = 'msp_notifier_admin_push';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            self::TABLE_NAME,
            AdminPushInterface::ID
        );
    }
}
