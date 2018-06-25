<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model;

use Magento\Framework\Config\Reader\Filesystem as ConfigReader;
use Magento\Framework\Exception\NoSuchEntityException;
use MSP\NotifierAdminPushAdapterApi\Api\IconRepositoryInterface;

class IconRepository implements IconRepositoryInterface
{
    const DEFAULT_ICON = 'default';

    /**
     * @var ConfigReader
     */
    private $configReader;

    /**
     * @var array
     */
    private $icons = null;

    /**
     * TemplateResolver constructor.
     * @param ConfigReader $configReader
     */
    public function __construct(
        ConfigReader $configReader
    ) {
        $this->configReader = $configReader;
    }

    /**
     * @inheritdoc
     */
    public function getList(): array
    {
        if ($this->icons === null) {
            $this->icons = $this->configReader->read();
            foreach ($this->icons as $iconId => &$iconInfo) {
                $iconInfo['id'] = $iconId;
            }
        }

        return $this->icons;
    }

    /**
     * @inheritdoc
     */
    public function get(string $iconId): string
    {
        $icons = $this->getList();

        if (!isset($icons[$iconId])) {
            throw new NoSuchEntityException(__('Icon with id %1 does not exist', $iconId));
        }

        return $icons[$iconId]['file'];
    }
}
