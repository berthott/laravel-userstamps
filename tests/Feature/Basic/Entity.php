<?php

namespace berthott\Userstamps\Tests\Feature\Basic;

use berthott\Userstamps\Models\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasUserstamps;
    use HasFactory;

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
