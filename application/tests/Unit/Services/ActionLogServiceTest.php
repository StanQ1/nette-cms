<?php

namespace App\Tests\Unit\Services;

use App\Services\ActionLogService;
use Nette\Database\Explorer;
use Nette\Database\Table\Selection;
use Nette\Database\Table\ActiveRow;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class ActionLogServiceTest extends TestCase
{
    private Selection $tableMock;
    private ActionLogService $service;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $databaseMock = $this->createMock(Explorer::class);
        $this->tableMock = $this->createMock(Selection::class);

        $databaseMock->method('table')->willReturn($this->tableMock);

        $this->service = new ActionLogService($databaseMock);
    }

    public function testGetPageOfLatestActionLogs()
    {
        $index = 10;
        $count = 50;

        $this->tableMock->method('count')->willReturn($count);
        $result = $this->service->getPageOfLatestActionLogs($index);

        $this->assertIsArray($result);
    }

    /**
     * @throws Exception
     */
    public function testCreateActionLog()
    {
        $executorId = 1;
        $action = 'SecretUser created article';
        $activeRowMock = $this->createMock(ActiveRow::class);

        $this->tableMock->expects($this->once())
            ->method('insert')
            ->with(['executor_id' => $executorId, 'action' => $action])
            ->willReturn($activeRowMock);

        $result = $this->service->createActionLog($executorId, $action);

        $this->assertSame($activeRowMock, $result);
    }
}
