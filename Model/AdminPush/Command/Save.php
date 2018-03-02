<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\AdminPush\Command;

use Magento\Framework\Exception\CouldNotSaveException;
use MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class Save implements SaveInterface
{
    /**
     * @var AdminPush
     */
    private $resource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param AdminPush $resource
     * @param LoggerInterface $logger
     */
    public function __construct(
        AdminPush $resource,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(AdminPushInterface $adminPush): int
    {
        try {
            $this->resource->save($adminPush);
            return (int) $adminPush->getId();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('Could not save AdminPush'), $e);
        }
    }
}
