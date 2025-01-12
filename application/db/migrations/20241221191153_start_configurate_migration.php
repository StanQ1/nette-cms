<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class StartConfigurateMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */

    public function up(): void
    {
        $table = $this->table('cms-config');
        $table
            ->addColumn('configuration__key', 'text', ['limit' => MysqlAdapter::TEXT_TINY])
            ->addColumn('configuration__value', 'text', ['limit' => MysqlAdapter::TEXT_TINY])
            ->create();
        
        $default_configuration = [
            [
                'configuration__key' => 'is_ready_to_use',
                'configuration__value' => '0',
            ],
            [
                'configuration__key' => 'project_name',
                'configuration__value' => 'NetteCMS',
            ],
            [
                'configuration__key' => 'admin_username',
                'configuration__value' => 'cmshero',
            ],
            [
                'configuration__key' => 'admin_password',
                'configuration__value' => 'heropassword',
            ]
        ];

        $table->insert($default_configuration)->save();
    }

    public function down(): void
    {
        $this->table('cms-config')->drop()->save();
    }
}
