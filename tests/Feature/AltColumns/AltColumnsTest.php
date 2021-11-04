<?php

namespace berthott\Userstamps\Tests\Feature\AltColumns;

use Illuminate\Support\Facades\Schema;

class AltColumnsTest extends TestCase
{
    public function test_table_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('entities', ['alt_created_by', 'alt_updated_by', 'alt_deleted_by']));
    }

    public function test_alt_created_and_deleted(): void
    {
        $this->actingAs($this->user1);
        $entity = Entity::factory()->create();
        $this->assertEquals($entity->alt_created_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['alt_created_by' => $this->user1->id]);
        $this->assertEquals($entity->alt_updated_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['alt_updated_by' => $this->user1->id]);
        $this->assertEquals($entity->alt_deleted_by, null);
        $this->assertDatabaseHas('entities', ['alt_deleted_by' => null]);

        $entity->delete();
        $this->assertEquals($entity->alt_created_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['alt_created_by' => $this->user1->id]);
        $this->assertEquals($entity->alt_updated_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['alt_updated_by' => $this->user1->id]);
        $this->assertEquals($entity->alt_deleted_by, $this->user1->id);
        $this->assertDatabaseHas('entities', ['alt_deleted_by' => $this->user1->id]);
    }
}
