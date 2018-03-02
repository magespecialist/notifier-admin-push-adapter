<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\AdminPush\Command;

use Magento\Framework\Exception\CouldNotDeleteException;
use MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class Clear implements ClearInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var \MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush\Clear
     */
    private $clear;

    /**
     * @param \MSP\NotifierAdminPushAdapter\Model\ResourceModel\AdminPush\Clear $clear
     * @param LoggerInterface $logger
     */
    public function __construct(
        AdminPush\Clear $clear,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->clear = $clear;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        try {
            $this->clear->execute();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__('Could not clear AdminPush'), $e);
        }
    }
}
