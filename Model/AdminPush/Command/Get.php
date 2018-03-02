<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
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
class Get implements GetInterface
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
     * @param AdminPush $resource
     * @param AdminPushInterfaceFactory $factory
     */
    public function __construct(
        AdminPush $resource,
        AdminPushInterfaceFactory $factory
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function execute(int $adminPushId): AdminPushInterface
    {
        /** @var AdminPushInterface $adminPush */
        $adminPush = $this->factory->create();
        $this->resource->load(
            $adminPush,
            $adminPushId,
            AdminPushInterface::ID
        );

        if (null === $adminPush->getId()) {
            throw new NoSuchEntityException(__('AdminPush with id "%value" does not exist.', [
                'value' => $adminPushId
            ]));
        }

        return $adminPush;
    }
}
