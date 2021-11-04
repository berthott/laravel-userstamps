<?php

namespace berthott\Userstamps\Tests\Feature\AltColumns;

use berthott\Userstamps\Models\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;
    use HasUserstamps;
    use HasFactory;

    const CREATED_BY = 'alt_created_by';
    const UPDATED_BY = 'alt_updated_by';
    const DELETED_BY = 'alt_deleted_by';

    protected $fillable = ['value'];

    protected static function newFactory()
    {
        return EntityFactory::new();
    }
}

class EntityFactory extends Factory
{
    protected $model = Entity::class;

    public function definition()
    {
        return [
            'value' => $this->faker->word(),
        ];
    }
}
