<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\AdapterEngine;

use MSP\Notifier\Model\AdapterEngine\AdapterEngineInterface;
use MSP\Notifier\Model\SerializerInterface;
use MSP\NotifierAdminPushAdapterApi\Api\AdminPushRepositoryInterface;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterfaceFactory;

class AdminPush implements AdapterEngineInterface
{
    const ADAPTER_CODE = 'admin_push';

    const PARAM_USERS = 'users';
    const PARAM_MODE = 'mode';
    const PARAM_ICON = 'icon';
    const PARAM_TIMEOUT = 'timeout';

    /**
     * @var AdminPushInterfaceFactory
     */
    private $adminPushInterfaceFactory;

    /**
     * @var AdminPushRepositoryInterface
     */
    private $adminPushRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * AdminPush constructor.
     * @param AdminPushInterfaceFactory $adminPushInterfaceFactory
     * @param AdminPushRepositoryInterface $adminPushRepository
     * @param SerializerInterface $serializer
     * @SuppressWarnings(PHPMD.LongVariables)
     */
    public function __construct(
        AdminPushInterfaceFactory $adminPushInterfaceFactory,
        AdminPushRepositoryInterface $adminPushRepository,
        SerializerInterface $serializer
    ) {
        $this->adminPushInterfaceFactory = $adminPushInterfaceFactory;
        $this->adminPushRepository = $adminPushRepository;
        $this->serializer = $serializer;
    }

    /**
     * Execute engine and return true on success. Throw exception on failure.
     * @param string $message
     * @param array $params
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function execute(string $message, array $params = []): bool
    {
        if (!isset($params[self::PARAM_USERS])) {
            throw new \InvalidArgumentException('' . __('Missing users parameters'));
        }

        $users = $params[self::PARAM_USERS];

        foreach ($users as $user) {
            /** @var AdminPushInterface $adminPush */
            $adminPush = $this->adminPushInterfaceFactory->create();

            $adminPush->setMessage($message);
            $adminPush->setCreatedAt(date('Y-m-d H:i:s'));
            $adminPush->setUserName($user);
            $adminPush->setParamsJson($this->serializer->serialize($params));

            $this->adminPushRepository->save($adminPush);
        }

        return true;
    }
}
