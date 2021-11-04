<?php

namespace berthott\Userstamps\Tests\Feature\SoftDeletes;

use Illuminate\Support\Facades\Schema;

class SoftDeletesTest extends TestCase
{
    public function test_table_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('entities', ['created_by', 'updated_by', 'deleted_by']));
    }

    public function test_deleted_and_resored(): void
    {
        $this->actingAs($this->user1);
        $entity = Entity::factory()->create();
        $this->assertEquals($entity->created_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['created_by' => $this->user1->id]);
        $this->assertEquals($entity->updated_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['updated_by' => $this->user1->id]);
        $this->assertEquals($entity->deleted_by, null);
        $this->assertDatabaseHas('entities', ['deleted_by' => null]);

        $entity->delete();
        $this->assertEquals($entity->created_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['created_by' => $this->user1->id]);
        $this->assertEquals($entity->updated_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['updated_by' => $this->user1->id]);
        $this->assertEquals($entity->deleted_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['deleted_by' => $this->user1->id]);

        $entity->restore();
        $this->assertEquals($entity->created_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['created_by' => $this->user1->id]);
        $this->assertEquals($entity->updated_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['updated_by' => $this->user1->id]);
        $this->assertEquals($entity->deleted_by, null);
        $this->assertDatabaseHas('entities', ['deleted_by' => null]);
    }
}
