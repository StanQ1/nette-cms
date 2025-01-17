<?php

namespace App\Services;

use App\Core\BaseModel;

class ConfigurationService extends BaseModel
{
    public function getConfigurationValue(string $key)
    {
        return $this->database->table('cms-config')
            ->where('configuration__key', $key)
            ->fetch()->configuration__value; 
    }

    public function setConfigurationValue(string $key, $data): void
    {
        $this->database->table('cms-config')->where('configuration__key', $key)
            ->update([
                'configuration__value' => $data,
            ]);
    }

    public function getAppIsReadyState(): bool
    {
        return (bool) $this->database->table('cms-config')
            ->where('configuration__key', 'is_ready_to_use')
            ->fetch()->configuration__value;        
    }
}