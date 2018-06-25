<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush;

use Magento\Framework\App\ResourceConnection;
use MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush;

class Clear
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
     * @throws \DomainException
     */
    public function execute()
    {
        $connection = $this->resourceConnection->getConnection();
        $connection->delete($connection->getTableName(AdminPush::TABLE_NAME));
    }
}
