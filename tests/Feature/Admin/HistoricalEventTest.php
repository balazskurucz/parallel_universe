<?php

namespace Tests\Feature\Admin;

use App\Models\HistoricalEvent;
use App\Models\ParallelUniverse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HistoricalEventTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_authenticated_admin_can_view_events_index_page()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();
        $event = HistoricalEvent::factory()->create(['parallel_universe_id' => $universe->id]);

        $response = $this->actingAs($user)->get(route('admin.events.index'));

        $response->assertStatus(200);
        $response->assertSee($event->title);
    }

    public function test_authenticated_admin_can_access_events_create_page()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.events.create'));

        $response->assertStatus(200);
        $response->assertSee($universe->name);
    }

    public function test_authenticated_admin_can_create_historical_event()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();
        $file = UploadedFile::fake()->image('event.jpg');

        $data = [
            'parallel_universe_id' => $universe->id,
            'title' => 'Test Event',
            'event_year' => 2023,
            'short_description' => 'Test short description',
            'long_description' => 'Test long description',
            'image' => $file,
            'video_url' => 'https://example.com/video',
        ];

        $response = $this->actingAs($user)->post(route('admin.events.store'), $data);

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('historical_events', [
            'parallel_universe_id' => $universe->id,
            'title' => 'Test Event',
            'event_year' => 2023,
            'short_description' => 'Test short description',
            'long_description' => 'Test long description',
            'video_url' => 'https://example.com/video',
        ]);
        Storage::disk('public')->assertExists('events/' . $file->hashName());
    }

    public function test_authenticated_admin_can_view_single_event()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();
        $event = HistoricalEvent::factory()->create(['parallel_universe_id' => $universe->id]);

        $response = $this->actingAs($user)->get(route('admin.events.show', $event));

        $response->assertStatus(200);
        $response->assertSee($event->title);
    }

    public function test_authenticated_admin_can_update_historical_event()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();
        $event = HistoricalEvent::factory()->create(['parallel_universe_id' => $universe->id]);

        $data = [
            'parallel_universe_id' => $universe->id,
            'title' => 'Updated Event',
            'event_year' => 2024,
            'short_description' => 'Updated short description',
            'long_description' => 'Updated long description',
            'video_url' => 'https://example.com/updated-video',
        ];

        $response = $this->actingAs($user)->put(route('admin.events.update', $event), $data);

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('historical_events', [
            'id' => $event->id,
            'title' => 'Updated Event',
            'event_year' => 2024,
            'short_description' => 'Updated short description',
            'long_description' => 'Updated long description',
            'video_url' => 'https://example.com/updated-video',
        ]);
    }

    public function test_authenticated_admin_can_delete_historical_event()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();
        $event = HistoricalEvent::factory()->create(['parallel_universe_id' => $universe->id]);

        $response = $this->actingAs($user)->delete(route('admin.events.destroy', $event));

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseMissing('historical_events', ['id' => $event->id]);
    }

    public function test_unauthenticated_user_is_redirected_from_events_admin_pages()
    {
        $universe = ParallelUniverse::factory()->create();
        $event = HistoricalEvent::factory()->create(['parallel_universe_id' => $universe->id]);

        $this->get(route('admin.events.index'))->assertRedirect(route('login'));
        $this->get(route('admin.events.create'))->assertRedirect(route('login'));
        $this->get(route('admin.events.show', $event))->assertRedirect(route('login'));
        $this->get(route('admin.events.edit', $event))->assertRedirect(route('login'));
    }
}
