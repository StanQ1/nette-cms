<?php

namespace App\Services;

use App\Core\BaseModel;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class ActionLogService extends BaseModel
{
    private string $table = 'action_logs';

    public function getPageOfLatestActionLogs(int $index = 0): Selection|ActiveRow|array
    {
        $offset = $this->database->table($this->table)->count();
        if ($offset >= $index) {
            return $this->database->table($this->table)->limit($index, $offset);
        } else {
            return $this->database->table($this->table)->fetchAll();
        }
    }

    public function createActionLog(int $executorId, string $action): ActiveRow
    {
        return $this->database->table($this->table)->insert([
            'executor_id' => $executorId,
            'action' => $action,
        ]);
    }
}