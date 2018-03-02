<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model;

use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushExtensionFactory;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;

class AdminPushExtensionLoader implements AdminPushExtensionLoaderInterface
{
    /**
     * @var AdminPushExtensionFactory
     */
    private $extensionFactory;

    /**
     * Extension loader constructor.
     * @param AdminPushExtensionFactory $extensionFactory
     * @SuppressWarnings(PHPMD.LongVariables)
     */
    public function __construct(
        AdminPushExtensionFactory $extensionFactory
    ) {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(AdminPushInterface $adminPush)
    {
        if ($adminPush->getExtensionAttributes() === null) {
            $extension = $this->extensionFactory->create();
            $adminPush->setExtensionAttributes($extension);
        }
    }
}
