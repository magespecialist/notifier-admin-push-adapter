<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use MSP\NotifierAdminPushAdapter\Model\AdminPush\Command\ClearInterface;
use MSP\NotifierAdminPushAdapter\Model\AdminPush\Command\DeleteInterface;
use MSP\NotifierAdminPushAdapter\Model\AdminPush\Command\GetInterface;
use MSP\NotifierAdminPushAdapter\Model\AdminPush\Command\GetListInterface;
use MSP\NotifierAdminPushAdapter\Model\AdminPush\Command\SaveInterface;
use MSP\NotifierAdminPushAdapterApi\Api\AdminPushRepositoryInterface;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AdminPushRepository implements AdminPushRepositoryInterface
{
    /**
     * @var SaveInterface
     */
    private $commandSave;

    /**
     * @var GetInterface
     */
    private $commandGet;

    /**
     * @var DeleteInterface
     */
    private $commandDeleteById;

    /**
     * @var GetListInterface
     */
    private $commandGetList;

    /**
     * @var \MSP\NotifierAdminPushAdapter\Model\AdminPush\Command\ClearInterface
     */
    private $commandClear;

    /**
     * @param SaveInterface $commandSave
     * @param GetInterface $commandGet
     * @param DeleteInterface $commandDeleteById
     * @param GetListInterface $commandGetList
     * @param ClearInterface $commandClear
     */
    public function __construct(
        SaveInterface $commandSave,
        GetInterface $commandGet,
        DeleteInterface $commandDeleteById,
        GetListInterface $commandGetList,
        ClearInterface $commandClear
    ) {
        $this->commandSave = $commandSave;
        $this->commandGet = $commandGet;
        $this->commandDeleteById = $commandDeleteById;
        $this->commandGetList = $commandGetList;
        $this->commandClear = $commandClear;
    }

    /**
     * @inheritdoc
     */
    public function save(\MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface $adminPush): int
    {
        return $this->commandSave->execute($adminPush);
    }

    /**
     * @inheritdoc
     */
    public function get(int $adminPushId): \MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface
    {
        return $this->commandGet->execute($adminPushId);
    }

    /**
     * @inheritdoc
     */
    public function deleteById(int $adminPushId)
    {
        $this->commandDeleteById->execute($adminPushId);
    }

    /**
     * @inheritdoc
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria = null
    ): \MSP\NotifierAdminPushAdapterApi\Api\AdminPushSearchResultsInterface {
        return $this->commandGetList->execute($searchCriteria);
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        $this->commandClear->execute();
    }
}
