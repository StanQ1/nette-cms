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

    public function testEditArticle(): void
    {
        $this->articleModelMock
            ->expects($this->once())
            ->method('update')
            ->with(
                id: 2,
                data: [
                    'title' => 'title',
                    'category_id' => 1,
                    'content' => 'content',
                ])
            ->willReturn(true);

        $result = $this->articleService
            ->editArticle(2, 'title', 1, 'content');

        $this->assertTrue($result);
    }

    /**
     * @throws Exception
     */
    public function testDeleteArticle(): void
    {
        $mockObject = $this->createMock(ActiveRow::class);
        $this->articleModelMock
            ->expects($this->once())
            ->method('findById')
            ->with(2)
            ->willReturn($mockObject);

        $this->articleModelMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn(1);

        $result = $this->articleService->deleteArticle(2);

        $this->assertTrue($result);
    }


    /**
     * @throws Exception
     */
    public function testGetAllArticles(): void
    {
        $mockObject = $this->createMock(Selection::class);

        $this->articleModelMock
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($mockObject);

        $this->assertEquals($mockObject, $this->articleService->getAllArticles());
    }

    /**
     * @throws Exception
     */
    public function testGetArticlesByCategoryId()
    {
        $mockObject = $this->createMock(Selection::class);
        $this->articleModelMock
            ->expects($this->once())
            ->method('findAllByCategoryId')
            ->willReturn($mockObject);

        $this->assertEquals(
            $mockObject,
            $this->articleService->getArticlesByCategoryId(1)
        );
    }
}
