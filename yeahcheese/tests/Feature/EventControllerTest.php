<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Event;
use App\Picture;
use App\User;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHome()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('ようこそ')
            ->assertSee('YeahCheese');
    }

    public function testEventList()
    {
        $event = factory(Event::class)->create();
        $user = User::where('id', $event->user_id)->first();

        $response = $this->actingAs($user)
            ->get('events');
        
        $response->assertStatus(200)
            ->assertSee($event->title)
            ->assertSee($event->release_date)
            ->assertSee($event->end_date)
            ->assertSee($event->auth_key);
    }

    public function testEventShow()
    {
        $event = Event::find(1);
        $picture = $event->pictures()->first();

        $response = $this->get('/events/show?auth_key=' . $event->auth_key);

        $response->assertStatus(200);

        $response->assertSee($event->title)
                 ->assertSee($event->release_date)
                 ->assertSee($event->end_date)
                 ->assertSee($picture->path);

    }

    public function testEventShowWithoutAuthKey()
    {
        $response = $this->get('events/show');

        $response->assertStatus(302)
                 ->assertRedirect('events/search');
    }

    public function testEventShowWithInvalidAuthKey()
    {
        $response = $this->get('/events/show?auth_key=dummyauthkey');

        $response->assertStatus(302)
                 ->assertRedirect('events/search');
    }


    public function testEventSearch()
    {
        $response = $this->get('events/search');

        $response->assertStatus(200);
    }

    public function testEventCreate()
    {
        // event/create
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testEventEdit()
    {
        // /events/edit/{id}
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
