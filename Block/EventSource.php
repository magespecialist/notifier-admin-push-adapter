<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Block;

use Magento\Backend\Block\Template;

class EventSource extends Template
{
    public function getJsLayout()
    {
        $this->jsLayout['components']['msp-notifier-admin-push-adapter-event-source']['url'] =
            $this->getUrl('msp_notifier_admin_push/adminpush/index');

        return parent::getJsLayout();
    }
}
