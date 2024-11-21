<?php

namespace computerShop\base;

use computerShop\Database;

abstract class Model
{

    public array $attributes = [];
    public array $errors = [];
    public array $rules = [];
    public string $primaryKey = 'id';

    public function __construct()
    {
        Database::instance();
    }

    public function load($data): bool
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
        return true;
    }

    public function save()
    {
        if ($this->validate()) {
            if (isset($this->attributes[$this->primaryKey]) &&
                !empty($this->attributes[$this->primaryKey])) {
                return $this->update();
            }
            return $this->insert();
        }
        return false;
    }

    protected function validate(): bool
    {
        // Basic validation based on rules
        // Can be extended in child classes
        return true;
    }
}
