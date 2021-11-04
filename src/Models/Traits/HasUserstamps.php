<?php

namespace berthott\Userstamps\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasUserstamps
{
    public static function bootHasUserstamps()
    {
        static::creating(function (Model $model) {
            static::updateUserstamp($model, static::getCreatedByColumn(), Auth::id());
            static::updateUserstamp($model, static::getUpdatedByColumn(), Auth::id());
        });
        static::saving(function (Model $model) {
            static::updateUserstamp($model, static::getUpdatedByColumn(), Auth::id());
        });
        static::updating(function (Model $model) {
            static::updateUserstamp($model, static::getUpdatedByColumn(), Auth::id());
        });
        if (static::usingSoftDeletes()) {
            static::deleting(function (Model $model) {
                static::updateUserstamp($model, static::getDeletedByColumn(), Auth::id());
                $model->saveQuietly();
            });
            static::restoring(function (Model $model) {
                static::updateUserstamp($model, static::getDeletedByColumn(), null);
            });
        }
    }
    
    public function creator()
    {
        return $this->belongsTo($this->getUserClass(), $this->getCreatedByColumn());
    }

    public function editor()
    {
        return $this->belongsTo($this->getUserClass(), $this->getUpdatedByColumn());
    }

    public function destroyer()
    {
        return $this->belongsTo($this->getUserClass(), $this->getDeletedByColumn());
    }

    protected function getCreatedByColumn(): string
    {
        return defined('static::CREATED_BY') ? static::CREATED_BY : 'created_by';
    }

    protected function getUpdatedByColumn(): string
    {
        return defined('static::UPDATED_BY') ? static::UPDATED_BY : 'updated_by';
    }

    protected function getDeletedByColumn(): string
    {
        return defined('static::DELETED_BY') ? static::DELETED_BY : 'deleted_by';
    }

    protected static function usingSoftDeletes(): bool
    {
        static $usingSoftDeletes;

        if (is_null($usingSoftDeletes)) {
            return $usingSoftDeletes = in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive(get_called_class()));
        }

        return $usingSoftDeletes;
    }

    protected function getUserClass(): string
    {
        return config('auth.providers.users.model');
    }

    protected static function updateUserstamp(Model &$model, string $column, mixed $value)
    {
        if (!is_null($column) && !$model->isDirty($column)) {
            $model->{$column} = $value;
        }
    }
}
