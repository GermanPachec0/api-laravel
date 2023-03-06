<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    /**
     * A basic feature test example.
     */
    public function stores_post(): void
    {
    
        $user = User::create('App\Models\User');
        $data = [
            'title'=> fake()->sentence($nbWords=6,$variableNbWords=true),
            'author_id' => $user-> id ,
            'content' =>fake()->text($maxNbChars = 200)
          ];

        $response = $this->json('POST', $this->baseUrl."posts",$data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts',$data);

        $post = Post::all()->first();

        $response->assertJson([
            'data' => [
                'id'=> $post->id,
                'title'=>$post->title
            ]
        ]);
    }

    public function deletes_post(){
        $user =User::create();
        $post = Post::create('App\Models\Post');

        $this->json("DELETE",$this->baseUrl."posts/{$post->id}")->assertStatus(204);
        $this->assertNull(Post::find($post->id));

    }

    public function update_post(){
        $data =  [
            'title'=> fake()->sentence($nbWords=6,$variableNbWords=true),
           
            'content' =>fake()->text($maxNbChars = 200)
          ];

        $post = Post::create('App\Models\Post');

       $response = $this->json('PUT', $this->baseUrl."posts/{$post->id}",$data)->assertStatus(200);

       $post = $post->fresh();
        $this->assertEquals($post->title,$data['title']);
        $this->assertEquals($post->content,$data['content']);

    }

    public function shows_post(){
        $user = User::create('App\Models\User');
        $post = Post::create('App\Models\Post');

        $response = $this->json('GET',$this->baseUrl. "posts/{$post->id}");
        $response->assertStatus(200);
        
        $response->assertJson([
            'data'=>[
                'id' => $post->id,
                'title' => $post->title
            ]
        ]);

    }

   
}
