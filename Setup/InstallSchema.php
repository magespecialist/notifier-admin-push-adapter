<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use MSP\NotifierAdminPushAdapter\Setup\Operation\CreateAdminPushTable;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var CreateAdminPushTable
     */
    private $createAdminPushTable;

    public function __construct(
        CreateAdminPushTable $createAdminPushTable
    ) {
        $this->createAdminPushTable = $createAdminPushTable;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->createAdminPushTable->execute($setup);
        $setup->endSetup();
    }
}
