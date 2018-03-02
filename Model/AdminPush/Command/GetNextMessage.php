<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\AdminPush\Command;

use Magento\Framework\Exception\NoSuchEntityException;
use MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterfaceFactory;

/**
 * @inheritdoc
 */
class GetNextMessage implements GetNextMessageInterface
{
    /**
     * @var AdminPush
     */
    private $resource;

    /**
     * @var AdminPushInterfaceFactory
     */
    private $factory;

    /**
     * @var AdminPush\GetNextMessageId
     */
    private $getNextMessageId;

    /**
     * @param AdminPush $resource
     * @param AdminPushInterfaceFactory $factory
     * @param AdminPush\GetNextMessageId $getNextMessageId
     */
    public function __construct(
        AdminPush $resource,
        AdminPushInterfaceFactory $factory,
        AdminPush\GetNextMessageId $getNextMessageId
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
        $this->getNextMessageId = $getNextMessageId;
    }

    /**
     * Save AdminPush data
     *
     * @param string $userName
     * @param int $fromDate
     * @param int $fromId
     * @return AdminPushInterface
     * @throws NoSuchEntityException
     */
    public function execute(string $userName, int $fromDate = 0, int $fromId = 0): AdminPushInterface
    {
        $adminPushId = $this->getNextMessageId->execute($userName, $fromDate, $fromId);
        if (!$adminPushId) {
            throw new NoSuchEntityException(__('No more messages on the queue'));
        }

        /** @var AdminPushInterface $adminPush */
        $adminPush = $this->factory->create();
        $this->resource->load(
            $adminPush,
            $adminPushId,
            AdminPushInterface::ID
        );

        if (null === $adminPush->getId()) { // This should not happen (race condition?)
            throw new NoSuchEntityException(__('No more messages in the queue', [
                'value' => $adminPushId
            ]));
        }

        return $adminPush;
    }
}
