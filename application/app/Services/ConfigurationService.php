<?php

namespace App\Services;

class ConfigurationService
{
    public function __construct(
        private \Nette\Database\Explorer $database
        ){
    }

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