<?php

namespace App\Models\Concerns;

trait HasAttributeAliases
{
    public function getAttribute($key)
    {
        return parent::getAttribute($this->attributeAliasFor($key));
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute($this->attributeAliasFor($key), $value);
    }

    protected function attributeAliasFor($key)
    {
        $defaultAliases = [
            'created_at' => 'dibuat_pada',
            'updated_at' => 'diperbarui_pada',
            'deleted_at' => 'dihapus_pada',
        ];

        return $this->attributeAliases[$key] ?? $defaultAliases[$key] ?? $key;
    }
}
