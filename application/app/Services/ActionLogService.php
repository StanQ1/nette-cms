<?php

namespace App\Services;

use App\Core\BaseModel;
use Nette\Database\Table\ActiveRow;

class ActionLogService extends BaseModel
{
    private string $table = 'action_logs';

    public function getPageOfLatestActionLogs(int $index = 0): array
    {
        $rows = $this->database->table($this->table)->count('id');

        if ($rows > $index && $index > 0) {
            return iterator_to_array($this->database->table($this->table)->limit($index, $rows - $index));
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