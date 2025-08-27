<?php

namespace Tests\Feature\Admin;

use App\Models\ParallelUniverse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ParallelUniverseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_authenticated_admin_can_view_index_page()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.universes.index'));

        $response->assertStatus(200);
        $response->assertSee($universe->name);
    }

    public function test_authenticated_admin_can_access_create_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.universes.create'));

        $response->assertStatus(200);
    }

    public function test_authenticated_admin_can_create_universe()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('universe.jpg');

        $data = [
            'name' => 'Test Universe',
            'divergence_point' => 'Test divergence point',
            'description' => 'Test description',
            'cover_image' => $file,
        ];

        $response = $this->actingAs($user)->post(route('admin.universes.store'), $data);

        $response->assertRedirect(route('admin.universes.index'));
        $this->assertDatabaseHas('parallel_universes', [
            'name' => 'Test Universe',
            'divergence_point' => 'Test divergence point',
            'description' => 'Test description',
        ]);
        Storage::disk('public')->assertExists('universes/' . $file->hashName());
    }

    public function test_authenticated_admin_can_view_single_universe()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.universes.show', $universe));

        $response->assertStatus(200);
        $response->assertSee($universe->name);
    }

    public function test_authenticated_admin_can_update_universe()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();

        $data = [
            'name' => 'Updated Universe',
            'divergence_point' => 'Updated divergence point',
            'description' => 'Updated description',
        ];

        $response = $this->actingAs($user)->put(route('admin.universes.update', $universe), $data);

        $response->assertRedirect(route('admin.universes.index'));
        $this->assertDatabaseHas('parallel_universes', [
            'id' => $universe->id,
            'name' => 'Updated Universe',
            'divergence_point' => 'Updated divergence point',
            'description' => 'Updated description',
        ]);
    }

    public function test_authenticated_admin_can_delete_universe()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.universes.destroy', $universe));

        $response->assertRedirect(route('admin.universes.index'));
        $this->assertDatabaseMissing('parallel_universes', ['id' => $universe->id]);
    }

    public function test_unauthenticated_user_is_redirected_from_admin_pages()
    {
        $universe = ParallelUniverse::factory()->create();

        $this->get(route('admin.universes.index'))->assertRedirect(route('login'));
        $this->get(route('admin.universes.create'))->assertRedirect(route('login'));
        $this->get(route('admin.universes.show', $universe))->assertRedirect(route('login'));
        $this->get(route('admin.universes.edit', $universe))->assertRedirect(route('login'));
    }
}
