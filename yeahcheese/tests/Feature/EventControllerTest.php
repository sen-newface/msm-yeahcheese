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

    }

    public function testEventShow()
    {

    }

    public function testEventSearch()
    {

    }

    public function testEventCreate()
    {
        
    }

    public function testEventEdit()
    {
        
    }
}
