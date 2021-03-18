<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Data;

class PostTest extends TestCase
{
  public function data_store(){
    $data = [
        'name' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'cost' => $this->faker->sentence
    ];
    $this->post(route('data.store'), $data)
        ->assertStatus(201)
        ->assertJson($data);
  }

  public function data_update(){
    $post = factory(Post::class)->create();
    $data = [
        'name' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'cost' => $this->faker->sentence
    ];
    $this->put(route('data.update', $post->id), $data)
        ->assertStatus(200)
        ->assertJson($data);
  }

  public function data_show(){
    $post = factory(Post::class)->create();
    $this->get(route('data.show', $post->id))
        ->assertStatus(200);
  }


  public function data_delete(){
    $post = factory(Post::class)->create();
    $this->delete(route('data.delete', $post->id))
        ->assertStatus(204);
  }

  public function data_index(){
    $data = factory(Post::class, 2)->create()->map(function ($post) {
        return $post->only(['id', 'title', 'content']);
    });
    $this->get(route('data'))
        ->assertStatus(200)
        ->assertJson($data->toArray())
        ->assertJsonStructure([
            '*' => [ 'id', 'title', 'content' ],
        ]);
  }
}