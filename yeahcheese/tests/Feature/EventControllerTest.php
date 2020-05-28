<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
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
        // ログインユーザを指定 '/events'
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testEventShow()
    {
        // /events/show?auth_key={}
        $response = $this->get('/');

        $response->assertStatus(200);
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
