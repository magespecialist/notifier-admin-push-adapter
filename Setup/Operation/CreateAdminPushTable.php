<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Setup\Operation;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;

class CreateAdminPushTable
{
    const TABLE_NAME_ADMIN_PUSH = 'msp_notifier_admin_push';

    /**
     * @param SchemaSetupInterface $setup
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function execute(SchemaSetupInterface $setup)
    {
        $adminPushTable = $setup->getConnection()->newTable(
            $setup->getTable(self::TABLE_NAME_ADMIN_PUSH)
        )->setComment(
            'MSP Notifier Core Adapters Admin Push'
        );

        $adminPushTable = $this->addFields($adminPushTable);
        $adminPushTable = $this->addIndexes($setup, $adminPushTable);

        $setup->getConnection()->createTable($adminPushTable);
    }

    /**
     * Add fields
     * @param Table $channelTable
     * @return Table
     * @throws \Zend_Db_Exception
     */
    private function addFields(Table $channelTable): Table
    {
        $channelTable
            ->addColumn(
                'admin_push_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ],
                'Admin Push ID'
            )->addColumn(
                'created_at',
                Table::TYPE_DATETIME,
                null,
                [
                    'nullable' => false,
                ],
                'Created At'
            )
            ->addColumn(
                'user_name',
                Table::TYPE_TEXT,
                null,
                [
                    'nullable' => false,
                ],
                'To user'
            )
            ->addColumn(
                'message',
                Table::TYPE_TEXT,
                null,
                [
                    'nullable' => false,
                ],
                'Message'
            )
            ->addColumn(
                'params_json',
                Table::TYPE_TEXT,
                null,
                [
                    'nullable' => false,
                ],
                'Extra params'
            );

        return $channelTable;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param Table $table
     * @return Table
     * @throws \Zend_Db_Exception
     */
    private function addIndexes(SchemaSetupInterface $setup, Table $table): Table
    {
        $table->addIndex(
            $setup->getIdxName(
                self::TABLE_NAME_ADMIN_PUSH,
                ['user_name'],
                AdapterInterface::INDEX_TYPE_INDEX
            ),
            [['name' => 'user_name', 'size' => 128]],
            ['type' => AdapterInterface::INDEX_TYPE_INDEX]
        );

        return $table;
    }
}
