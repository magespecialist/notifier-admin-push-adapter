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

class CleanUnsentMessages
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
     * @param int $maxHistory
     * @throws \DomainException
     */
    public function execute(int $maxHistory = 3600)
    {
        $maxHistory = max(0, $maxHistory);

        $connection = $this->resourceConnection->getConnection();
        $connection->delete(
            $connection->getTableName(AdminPush::TABLE_NAME),
            AdminPushInterface::CREATED_AT . ' < ' . $connection->quote(
                date('Y-m-d H:i:s', time() - $maxHistory)
            )
        );
    }
}
