<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class ArticleSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'category_id' => 1,
                'title' => 'My Routine',
                'content' => 'Hello Everybody! That\'s my first post in blog and today we start to talking about my everyday routine.',
            ],
            [
                'category_id' => 1,
                'title' => 'My Animals',
                'content' => 'I have some animals, which likes to play with my old toys and today I have walked with.',
            ],
            [
                'category_id' => 2,
                'title' => 'CMS Project',
                'content' => 'I started writing my own CMS system on Nette framework with some popular technologies in IT world.',
            ],
        ];

        $categories = [
            [
                'category_name' => 'Lifestyle',
                'category_id' => 1,
            ],
            [
                'category_name' => 'IT',
                'category_id' => 2,
            ]
        ];

        $this->table('articles')->insert($data)->saveData();
        $this->table('article_categories')->insert($categories)->saveData();
    }
}
