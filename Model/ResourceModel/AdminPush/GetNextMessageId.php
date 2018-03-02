<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush;

use Magento\Framework\App\ResourceConnection;
use MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;

class GetNextMessageId
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * CleanUnsentMessages constructor.
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Clean old unsent push notifications
     * @param string $userName
     * @param int $fromDate
     * @param int $fromId
     * @return int
     * @throws \DomainException
     */
    public function execute(string $userName, int $fromDate = 0, int $fromId = 0)
    {
        $connection = $this->resourceConnection->getConnection();
        $qry = $connection->select()->from(
            $connection->getTableName(AdminPush::TABLE_NAME),
            AdminPushInterface::ID
        )
            ->where(AdminPushInterface::USER_NAME . ' = ?', $userName)
            ->where(AdminPushInterface::CREATED_AT . ' > ?', date('Y-m-d H:i:s', $fromDate))
            ->where(AdminPushInterface::ID . ' > ?', $fromId)
            ->order(AdminPushInterface::CREATED_AT . ' ASC')
            ->limit(1);

        return (int) $connection->fetchOne($qry);
    }
}
