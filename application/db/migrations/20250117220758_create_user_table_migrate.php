<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserTableMigrate extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('username', 'string', ['limit' => 20, 'null' => false]);
        $table->addColumn('password', 'string', ['null' => false]);
        $table->addColumn('permissionLevel', 'integer', ['default' => 1]);
        $table->addIndex(['username'], ['unique' => true]);
        $table->create();
    }

    public function down(): void
    {
        $this->table('users')->drop()->save();
    }
}
