<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\AdminPush\Command;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class Delete implements DeleteInterface
{
    /**
     * @var AdminPush
     */
    private $resource;

    /**
     * @var GetInterface
     */
    private $commandGet;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param AdminPush $resource
     * @param GetInterface $commandGet
     * @param LoggerInterface $logger
     */
    public function __construct(
        AdminPush $resource,
        GetInterface $commandGet,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->commandGet = $commandGet;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(int $adminPushId)
    {
        /** @var \MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface $adminPush */
        try {
            $adminPush = $this->commandGet->execute($adminPushId);
        } catch (NoSuchEntityException $e) {
            return;
        }

        try {
            $this->resource->delete($adminPush);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__('Could not delete AdminPush'), $e);
        }
    }
}
