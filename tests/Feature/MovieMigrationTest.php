<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * MovieMigrationTest
 * 
 * This test suite verifies the database schema changes for the movie management system.
 * It ensures that the cinema_date column is removed, the show_time_id foreign key is added,
 * and that the migration can be safely rolled back.
 */
class MovieMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_the_correct_columns_after_migration()
    {
        // The migration should have run as part of RefreshDatabase
        
        $this->assertTrue(Schema::hasTable('movies'));
        $this->assertFalse(Schema::hasColumn('movies', 'cinema_date'), 'Column cinema_date should have been removed');
        // Check foreign key column existence
        $this->assertTrue(Schema::hasColumn('movies', 'show_time_id'), 'Column show_time_id should have been added');
        
        // Check column type - SQLite uses 'integer' for bigint
        $columnType = Schema::getColumnType('movies', 'show_time_id');
        $this->assertContains($columnType, ['bigint', 'integer']);
    }

    /** @test */
    public function it_can_rollback_migration()
    {
        // Run rollback for the last migration
        \Illuminate\Support\Facades\Artisan::call('migrate:rollback', ['--step' => 1]);

        $this->assertTrue(Schema::hasColumn('movies', 'cinema_date'), 'Column cinema_date should have been restored');
        $this->assertFalse(Schema::hasColumn('movies', 'show_time_id'), 'Column show_time_id should have been removed');
        
        // Re-run migration
        \Illuminate\Support\Facades\Artisan::call('migrate');
    }
}
