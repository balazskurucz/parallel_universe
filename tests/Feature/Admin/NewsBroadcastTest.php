<?php

namespace Tests\Feature\Admin;

use App\Models\NewsBroadcast;
use App\Models\ParallelUniverse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsBroadcastTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_authenticated_admin_can_view_news_index_page()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();
        $news = NewsBroadcast::factory()->create(['parallel_universe_id' => $universe->id]);

        $response = $this->actingAs($user)->get(route('admin.news.index'));

        $response->assertStatus(200);
        $response->assertSee($news->headline);
    }

    public function test_authenticated_admin_can_access_news_create_page()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.news.create'));

        $response->assertStatus(200);
        $response->assertSee($universe->name);
    }

    public function test_news_create_page_contains_wysiwyg_editor()
    {
        $user = User::factory()->create();
        ParallelUniverse::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.news.create'));

        $response->assertStatus(200);
        $response->assertSee('x-data="wysiwyg', false);
        $response->assertSee('x-ref="editor"', false);
        $response->assertSee('name="long_description"', false);
    }

    public function test_authenticated_admin_can_create_news_broadcast()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();
        $file = UploadedFile::fake()->image('news.jpg');

        $data = [
            'parallel_universe_id' => $universe->id,
            'headline' => 'Test News Headline',
            'broadcast_date' => '2023-12-01',
            'short_description' => 'Test short description',
            'long_description' => 'Test long description',
            'image' => $file,
            'video_url' => 'https://example.com/video',
        ];

        $response = $this->actingAs($user)->post(route('admin.news.store'), $data);

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news_broadcasts', [
            'parallel_universe_id' => $universe->id,
            'headline' => 'Test News Headline',
            'broadcast_date' => '2023-12-01',
            'short_description' => 'Test short description',
            'long_description' => 'Test long description',
            'video_url' => 'https://example.com/video',
        ]);
        Storage::disk('public')->assertExists('news/'.$file->hashName());
    }

    public function test_authenticated_admin_can_view_single_news()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();
        $news = NewsBroadcast::factory()->create(['parallel_universe_id' => $universe->id]);

        $response = $this->actingAs($user)->get(route('admin.news.show', $news));

        $response->assertStatus(200);
        $response->assertSee($news->headline);
    }

    public function test_authenticated_admin_can_update_news_broadcast()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();
        $news = NewsBroadcast::factory()->create(['parallel_universe_id' => $universe->id]);

        $data = [
            'parallel_universe_id' => $universe->id,
            'headline' => 'Updated News Headline',
            'broadcast_date' => '2024-01-01',
            'short_description' => 'Updated short description',
            'long_description' => 'Updated long description',
            'video_url' => 'https://example.com/updated-video',
        ];

        $response = $this->actingAs($user)->put(route('admin.news.update', $news), $data);

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news_broadcasts', [
            'id' => $news->id,
            'headline' => 'Updated News Headline',
            'broadcast_date' => '2024-01-01',
            'short_description' => 'Updated short description',
            'long_description' => 'Updated long description',
            'video_url' => 'https://example.com/updated-video',
        ]);
    }

    public function test_authenticated_admin_can_delete_news_broadcast()
    {
        $user = User::factory()->create();
        $universe = ParallelUniverse::factory()->create();
        $news = NewsBroadcast::factory()->create(['parallel_universe_id' => $universe->id]);

        $response = $this->actingAs($user)->delete(route('admin.news.destroy', $news));

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseMissing('news_broadcasts', ['id' => $news->id]);
    }

    public function test_unauthenticated_user_is_redirected_from_news_admin_pages()
    {
        $universe = ParallelUniverse::factory()->create();
        $news = NewsBroadcast::factory()->create(['parallel_universe_id' => $universe->id]);

        $this->get(route('admin.news.index'))->assertRedirect(route('login'));
        $this->get(route('admin.news.create'))->assertRedirect(route('login'));
        $this->get(route('admin.news.show', $news))->assertRedirect(route('login'));
        $this->get(route('admin.news.edit', $news))->assertRedirect(route('login'));
    }
}
