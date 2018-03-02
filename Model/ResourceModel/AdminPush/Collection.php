<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = \MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface::ID;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            \MSP\NotifierAdminPushAdapter\Model\AdminPush::class,
            \MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush::class
        );
    }
}
