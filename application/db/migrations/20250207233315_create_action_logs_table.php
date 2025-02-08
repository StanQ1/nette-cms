<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateActionLogsTable extends AbstractMigration
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
        $table = $this->table('action_logs');
        $table->addColumn('executor_id', 'integer', ['signed' => false, 'null' => false])
            ->addForeignKey('executor_id', 'users', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION',
            ]);
        $table->addColumn('action', 'string', ['null' => false]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->create();
    }

    public function down(): void
    {
        $this->table('action_logs')->drop()->save();
    }
}
