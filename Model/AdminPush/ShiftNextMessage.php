<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\AdminPush;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Exception\NoSuchEntityException;
use MSP\NotifierAdminPushAdapter\Model\AdminPush\Command\GetNextMessageInterface;
use MSP\NotifierAdminPushAdapterApi\Api\AdminPushRepositoryInterface;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;

/**
 * Message provider interface
 * This class is not stateless
 *
 * @api
 */
class ShiftNextMessage
{
    /**
     * @var int
     */
    private $lastMessageId = 0;

    /**
     * @var GetNextMessageInterface
     */
    private $getNextMessage;

    /**
     * @var Session
     */
    private $session;
    /**
     * @var AdminPushRepositoryInterface
     */
    private $adminPushRepository;

    /**
     * ShiftNextMessage constructor.
     * @param GetNextMessageInterface $getNextMessage
     * @param AdminPushRepositoryInterface $adminPushRepository
     * @param Session $session
     */
    public function __construct(
        GetNextMessageInterface $getNextMessage,
        AdminPushRepositoryInterface $adminPushRepository,
        Session $session
    ) {
        $this->getNextMessage = $getNextMessage;
        $this->session = $session;
        $this->adminPushRepository = $adminPushRepository;
    }

    /**
     * Get next message and remove from queue
     * @return AdminPushInterface|null
     */
    public function execute()
    {
        $userName = $this->session->getUser()->getUserName();
        $fromDate = (int) $this->session->getLoginTime();

        try {
            $adminPush = $this->getNextMessage->execute($userName, $fromDate, $this->lastMessageId);
            $this->adminPushRepository->deleteById((int) $adminPush->getId());
        } catch (NoSuchEntityException $e) {
            return null;
        }

        $this->lastMessageId = (int) $adminPush->getId();
        return $adminPush;
    }
}
