<?php

namespace berthott\Userstamps\Tests\Feature\Basic;

use Illuminate\Support\Facades\Schema;

class BasicTest extends TestCase
{
    public function test_table_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('entities', ['created_by', 'updated_by']));
        $this->assertFalse(Schema::hasColumns('entities', ['deleted_by']));
    }

    public function test_created(): void
    {
        $this->actingAs($this->user1);
        $entity = Entity::factory()->create();
        $this->assertEquals($entity->created_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['created_by' => $this->user1->id]);
        $this->assertEquals($entity->updated_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['updated_by' => $this->user1->id]);
    }

    public function test_updated(): void
    {
        $this->actingAs($this->user1);
        $entity = Entity::factory()->create();
        $this->assertEquals($entity->created_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['created_by' => $this->user1->id]);
        $this->assertEquals($entity->updated_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['updated_by' => $this->user1->id]);

        $this->actingAs($this->user2);
        $entity->update(['value' => 'newTestValue']);
        $entity->save();
        $this->assertEquals($entity->created_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['created_by' => $this->user1->id]);
        $this->assertEquals($entity->updated_by, $this->user2->id);
        $this->assertDatabaseHas('entities', ['updated_by' => $this->user2->id]);
    }
}
