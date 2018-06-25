<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\Source;

use Magento\Framework\Option\ArrayInterface;
use MSP\NotifierAdminPushAdapterApi\Api\IconRepositoryInterface;

class Icon implements ArrayInterface
{
    /**
     * @var IconRepositoryInterface
     */
    private $iconRepository;

    /**
     * AdminUser constructor.
     * @param IconRepositoryInterface $iconRepository
     */
    public function __construct(
        IconRepositoryInterface $iconRepository
    ) {
        $this->iconRepository = $iconRepository;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $res = [];

        $icons = $this->iconRepository->getList();

        foreach ($icons as $iconId => $iconInfo) {
            $res[] = [
                'value' => $iconId,
                'label' => $iconInfo['label'],
            ];
        }

        return $res;
    }
}
