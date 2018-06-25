<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\AdminPush;

/**
 * Clean unsent push notifications
 *
 * @api
 */
class CleanUnsentMessages
{
    const PUSH_NOTIFICATION_PERSISTENCE = 3600;

    /**
     * @var \MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush\CleanUnsentMessages
     */
    private $cleanUnsentMessages;

    /**
     * CleanUnsentMessages constructor.
     * @param \MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush\CleanUnsentMessages $cleanUnsentMessages
     */
    public function __construct(
        \MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush\CleanUnsentMessages $cleanUnsentMessages
    ) {
        $this->cleanUnsentMessages = $cleanUnsentMessages;
    }

    /**
     * Clean old unsent push notifications
     */
    public function execute()
    {
        $this->cleanUnsentMessages->execute(self::PUSH_NOTIFICATION_PERSISTENCE);
    }
}
