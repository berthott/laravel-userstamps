<?php

namespace berthott\Userstamps\Tests\Feature\DisabledColumns;

use Illuminate\Support\Facades\Schema;

class DisabledColumnsTest extends TestCase
{
    public function test_table_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('entities', ['created_by', 'updated_by', 'deleted_by']));
    }

    public function test_disabled_columns(): void
    {
        $this->actingAs($this->user1);
        $entity = Entity::factory()->create();
        $this->assertEquals($entity->created_by, null);
        $this->assertDatabaseHas('entities', ['created_by' => null]);
        $this->assertEquals($entity->updated_by, null);
        $this->assertDatabaseHas('entities', ['updated_by' => null]);
        $this->assertEquals($entity->deleted_by, null);
        $this->assertDatabaseHas('entities', ['deleted_by' => null]);

        $this->actingAs($this->user2);
        $entity->update(['value' => 'newTestValue']);
        $entity->save();
        $this->assertEquals($entity->created_by, null);
        $this->assertDatabaseHas('entities', ['created_by' => null]);
        $this->assertEquals($entity->updated_by, null);
        $this->assertDatabaseHas('entities', ['updated_by' => null]);


        $this->actingAs($this->user1);
        $entity->delete();
        $this->assertEquals($entity->created_by, null);
        $this->assertDatabaseHas('entities', ['created_by' => null]);
        $this->assertEquals($entity->updated_by, null);
        $this->assertDatabaseHas('entities', ['updated_by' => null]);
        $this->assertEquals($entity->deleted_by, null);
        $this->assertDatabaseHas('entities', ['deleted_by' => null]);

        $entity->restore();
        $this->assertEquals($entity->created_by, null);
        $this->assertDatabaseHas('entities', ['created_by' => null]);
        $this->assertEquals($entity->updated_by, null);
        $this->assertDatabaseHas('entities', ['updated_by' => null]);
        $this->assertEquals($entity->deleted_by, null);
        $this->assertDatabaseHas('entities', ['deleted_by' => null]);
    }
}
