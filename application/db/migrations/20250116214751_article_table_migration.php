<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ArticleTableMigration extends AbstractMigration
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
        $table = $this->table('articles');
        $table->addColumn('category_id', 'integer');
        $table->addColumn('title', 'string');
        $table->addColumn('content', 'text');
        $table->addColumn('published_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->create();
    }

    public function down(): void
    {
        $this->table('articles')->drop()->save();
    }
}
