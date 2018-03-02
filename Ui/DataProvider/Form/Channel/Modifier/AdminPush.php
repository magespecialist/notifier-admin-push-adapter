<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Ui\DataProvider\Form\Channel\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;
use MSP\Notifier\Model\Channel\ModifierInterface;
use MSP\NotifierAdminPushAdapter\Model\Source\AdminUser;
use MSP\NotifierAdminPushAdapter\Model\Source\Icon;
use MSP\NotifierAdminPushAdapter\Model\Source\NotificationMode;

class AdminPush extends AbstractModifier implements ModifierInterface
{
    /**
     * @var AdminUser
     */
    private $adminUser;

    /**
     * @var NotificationMode
     */
    private $notificationMode;

    /**
     * @var Icon
     */
    private $icon;

    /**
     * AdminPush constructor.
     * @param AdminUser $adminUser
     * @param NotificationMode $notificationMode
     * @param Icon $icon
     */
    public function __construct(
        AdminUser $adminUser,
        NotificationMode $notificationMode,
        Icon $icon
    ) {
        $this->adminUser = $adminUser;
        $this->notificationMode = $notificationMode;
        $this->icon = $icon;
    }

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function modifyMeta(array $meta): array
    {
        $meta['configuration'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Fieldset::NAME,
                        'label' => __('Admin Push Notification'),
                        'collapsible' => false,
                    ],
                ],
            ],
            'children' => [
                'users' => [
                    'arguments' => [
                        'data' => [
                            'options' => $this->adminUser->toOptionArray(),
                            'config' => [
                                'componentType' => Field::NAME,
                                'label' => __('Users'),
                                'notice' => '' . __('List of users that will receive notifications from this channel'),
                                'dataType' => 'text',
                                'formElement' => 'select',
                                'sortOrder' => 10,
                                'dataScope' => 'general.configuration.users',
                                'component' => 'Magento_Ui/js/form/element/ui-select',
                                'elementTmpl' => 'ui/grid/filters/elements/ui-select',
                                'filterOptions' => true,
                                'showCheckbox' => true,
                                'chipsEnabled' => true,
                                'disableLabel' => true,
                                'levelsVisibility' => true,
                                'multiple' => true,
                                'listens' => [
                                    'newOption' => 'toggleOptionSelected',
                                ],
                                'validation' => [
                                    'required-entry' => true,
                                ],
                            ],
                        ],
                    ],
                ],

                'mode' => [
                    'arguments' => [
                        'data' => [
                            'options' => $this->notificationMode->toOptionArray(),
                            'config' => [
                                'componentType' => Field::NAME,
                                'label' => __('Notification mode'),
                                'dataType' => 'text',
                                'formElement' => 'select',
                                'elementTmpl' => 'MSP_NotifierAdminPushAdapter/form/wide-select',
                                'sortOrder' => 20,
                                'dataScope' => 'general.configuration.mode',
                                'validation' => [
                                    'required-entry' => true,
                                ],
                            ],
                        ],
                    ],
                ],

                'icon' => [
                    'arguments' => [
                        'data' => [
                            'options' => $this->icon->toOptionArray(),
                            'config' => [
                                'componentType' => Field::NAME,
                                'label' => __('Notification icon'),
                                'dataType' => 'text',
                                'formElement' => 'select',
                                'elementTmpl' => 'MSP_NotifierAdminPushAdapter/form/wide-select',
                                'sortOrder' => 20,
                                'dataScope' => 'general.configuration.icon',
                                'validation' => [
                                    'required-entry' => true,
                                ],
                            ],
                        ],
                    ],
                ],

                'timeout' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Field::NAME,
                                'label' => __('Dismiss Notification After'),
                                'default' => 0,
                                'notice' => __('Number of seconds. Set 0 to disable.'),
                                'dataType' => 'text',
                                'formElement' => 'input',
                                'sortOrder' => 30,
                                'dataScope' => 'general.configuration.timeout',
                                'validation' => [
                                    'required-entry' => true,
                                    'validate-digits' => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $meta;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data): array
    {
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function getAdapterCode(): string
    {
        return \MSP\NotifierAdminPushAdapter\Model\AdapterEngine\AdminPush::ADAPTER_CODE;
    }
}
