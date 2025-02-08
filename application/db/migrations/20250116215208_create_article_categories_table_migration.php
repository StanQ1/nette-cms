<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateArticleCategoriesTableMigration extends AbstractMigration
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
        $table = $this->table('article_categories');
        $table->addColumn('category_name', 'string');
        $table->create();

        $table->insert([
            'category_name' => 'Unsorted',
        ])->save();
    }

    public function down(): void
    {
        $this->table('article_categories')->drop()->save();
    }
}
