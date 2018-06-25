<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\Source;

use Magento\Framework\Option\ArrayInterface;

class NotificationMode implements ArrayInterface
{
    const MODE_BROWSER = 'browser';
    const MODE_SYSTEM = 'system';
    const MODE_BROWSER_SYSTEM = 'browser,system';

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::MODE_BROWSER,
                'label' => '' . __('Browser Notification'),
            ], [
                'value' => self::MODE_SYSTEM,
                'label' => '' . __('System Notification'),
            ], [
                'value' => self::MODE_BROWSER_SYSTEM,
                'label' => '' . __('Browser + System Notification'),
            ]
        ];
    }
}
