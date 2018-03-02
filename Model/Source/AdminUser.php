<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\User\Model\ResourceModel\User\CollectionFactory;

class AdminUser implements ArrayInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * AdminUser constructor.
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $res = [];

        /** @var \Magento\User\Model\ResourceModel\User\Collection $users */
        $users = $this->collectionFactory->create();

        foreach ($users as $user) {
            /** @var \Magento\User\Model\User $user */
            $res[] = [
                'value' => $user->getUserName(),
                'label' => $user->getUserName() . ': ' . $user->getName(),
            ];
        }

        return $res;
    }
}
