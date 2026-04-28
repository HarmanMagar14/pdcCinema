<?php

namespace Tests\Feature;

use App\Models\Cinemas;
use App\Models\Halls;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * AdminMovieTest
 * 
 * This test suite verifies the integration of the admin panel movie management features.
 * It tests the AJAX API for fetching halls by cinema and ensures that showtime 
 * information is correctly displayed in the movie list view.
 */
class AdminMovieTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin role if it doesn't exist
        $adminRole = Roles::firstOrCreate(['name' => 'admin']);
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role_id' => $adminRole->id
        ]);
    }

    /** @test */
    public function it_can_fetch_halls_for_a_cinema_via_api()
    {
        $cinema = Cinemas::create([
            'name' => 'Test Cinema',
            'location' => 'Test Location'
        ]);

        $hall1 = Halls::create([
            'cinema_id' => $cinema->id,
            'name' => 'Hall 1',
            'capacity' => 100,
            'projection_type' => '2D'
        ]);

        $hall2 = Halls::create([
            'cinema_id' => $cinema->id,
            'name' => 'Hall 2',
            'capacity' => 150,
            'projection_type' => '3D'
        ]);

        $response = $this->actingAs($this->admin)
            ->getJson("/admin/api/cinemas/{$cinema->id}/halls");

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(['name' => 'Hall 1'])
            ->assertJsonFragment(['name' => 'Hall 2']);
    }

    /** @test */
    public function it_displays_showtime_info_in_movie_list()
    {
        // Create dependencies
        $genre = \App\Models\Genres::create(['name' => 'Action']);
        $cinema = Cinemas::create(['name' => 'Test Cinema', 'location' => 'Loc']);
        $hall = Halls::create(['cinema_id' => $cinema->id, 'name' => 'H1', 'capacity' => 10, 'projection_type' => '2D']);
        
        // Create movie first without showtime
        $movie = \App\Models\Movies::create([
            'title' => 'Test Movie',
            'description' => 'Desc',
            'genre_id' => $genre->id,
            'release_date' => now(),
            'show_time_id' => null,
            'duration' => 120
        ]);

        // Create showtime linked to movie
        $showtime = \App\Models\Showtimes::create([
            'movie_id' => $movie->id,
            'hall_id' => $hall->id,
            'start_time' => now()->addDay(),
            'end_time' => now()->addDay()->addHours(2),
            'price' => 10.00
        ]);

        // Update movie with showtime ID
        $movie->update(['show_time_id' => $showtime->id]);
        
        $response = $this->actingAs($this->admin)
            ->get("/admin/movies");

        $response->assertStatus(200);
        $response->assertSee('Show Time');
        $response->assertSee('Test Movie');
        $response->assertSee('H1 (Test Cinema)');
    }
}
