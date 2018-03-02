<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushExtensionInterface;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class AdminPush extends AbstractExtensibleModel implements
    AdminPushInterface
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\AdminPush::class);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($value)
    {
        return $this->setData(self::CREATED_AT, $value);
    }

    /**
     * @inheritdoc
     */
    public function getUserName()
    {
        return $this->getData(self::USER_NAME);
    }

    /**
     * @inheritdoc
     */
    public function setUserName($value)
    {
        return $this->setData(self::USER_NAME, $value);
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @inheritdoc
     */
    public function setMessage($value)
    {
        return $this->setData(self::MESSAGE, $value);
    }

    /**
     * @inheritdoc
     */
    public function getParamsJson()
    {
        return $this->getData(self::PARAMS_JSON);
    }

    /**
     * @inheritdoc
     */
    public function setParamsJson($value)
    {
        return $this->setData(self::PARAMS_JSON, $value);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(
        AdminPushExtensionInterface $extensionAttributes
    ) {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
