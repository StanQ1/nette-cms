<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserLevelsTable extends AbstractMigration
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
        $table = $this->table('user_levels');
        $table->addColumn('name', 'string');
        $table->addColumn('permission_level', 'integer');
        $table->create();

        $default_configuration = [
            [
                'name' => 'guest',
                'permission_level' => 0,
            ],
            [
                'name' => 'user',
                'permission_level' => 1,
            ],
            [
                'name' => 'admin',
                'permission_level' => 2,
            ],
        ];

        $table->insert($default_configuration)->save();
    }

    public function down(): void
    {
        $this->table('user_levels')->drop()->save();
    }
}
