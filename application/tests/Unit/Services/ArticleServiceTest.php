<?php declare(strict_types=1);

namespace App\Tests\Unit\Services;

use App\Model\ArticleModel;
use App\Services\ArticleService;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class ArticleServiceTest extends TestCase
{
    private ArticleService $articleService;
    private ArticleModel $articleModelMock;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->articleModelMock = $this->createMock(ArticleModel::class);
        $this->articleService = new ArticleService($this->articleModelMock);
    }

    /**
     * @testdox Create article
     */
    public function testCreateArticle(): void
    {
        $this->articleModelMock
            ->expects($this->once())
            ->method('insert')
            ->with([
                'title' => 'title',
                'category_id' => 1,
                'content' => 'content',
            ]);

        $this->articleService->createArticle('title', 1, 'content');
    }

    /**
     * @testdox Find article
     * @throws Exception
     */
    public function testFindArticleById(): void
    {
        $mockObject = $this->createMock(ActiveRow::class);

        $this->articleModelMock
            ->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($mockObject);

        $result = $this->articleService->findArticleById(1);

        $this->assertEquals($mockObject, $result);
    }

    /**
     * @testdox Edit article
     * @throws Exception
     */
    public function testEditArticle(): void
    {
        $this->articleModelMock
            ->method('update')
            ->with(
                id: 1,
                data: [
                    'title' => 'title',
                    'category_id' => 1,
                    'content' => 'content',
                ])
            ->willReturn(true);

        $result = $this->articleService
            ->editArticle(1, 'title', 1, 'content');

        $this->assertTrue($result);
    }

    /**
     * @testdox Delete article
     * @throws Exception
     */
    public function testDeleteArticle(): void
    {
        $mockObject = $this->createMock(ActiveRow::class);
        $this->articleModelMock
            ->method('findById')
            ->with(2)
            ->willReturn($mockObject);

        $this->articleModelMock
            ->method('delete')
            ->willReturn(1);

        $result = $this->articleService->deleteArticle(2);

        $this->assertTrue($result);
    }


    /**
     * @testdox Get all articles
     * @throws Exception
     */
    public function testGetAllArticles(): void
    {
        $mockObject = $this->createMock(Selection::class);

        $this->articleModelMock
            ->method('findAll')
            ->willReturn($mockObject);

        $this->assertEquals($mockObject, $this->articleService->getAllArticles());
    }

    /**
     * @testdox Get all articles by category
     * @throws Exception
     */
    public function testGetArticlesByCategoryId()
    {
        $mockObject = $this->createMock(Selection::class);
        $this->articleModelMock
            ->method('findAllByCategoryId')
            ->willReturn($mockObject);

        $this->assertEquals(
            $mockObject,
            $this->articleService->getArticlesByCategoryId(1)
        );
    }
}
