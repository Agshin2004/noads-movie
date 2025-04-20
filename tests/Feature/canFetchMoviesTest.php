<?php

/**
 * CHEATSHEET:
 * Request helpers:
    $this->get($uri)
    $this->post($uri, $data)
    $this->put($uri, $data
    $this->delete($uri)
    $this->patch($uri, $data)
    $this->actingAs($user) — for authenticated requests
 * Response assertions:
    $response->assertStatus(200)
    $response->assertSee('Text')
    $response->assertJson([...])
    $response->assertRedirect('/home')
 * Auth:
    $this->actingAs($user)
    $this->withSession([...])
 * DB helpers:
    $this->assertDatabaseHas('users', [...])
    $this->assertDatabaseMissing('users', [...])
    $this->seed() runs your Laravel database seeders inside a test.
    $this->artisan('migrate')
 * Misc:
    $this->withoutExceptionHandling()
    $this->withHeaders([...])
    $this->withoutMiddleware() disables all middleware for the current test
 */

// Used Pest function based instead of PHPUnit
test('user can view movies', function () {
    // $this accessible because laravel binds it to base test class behind the scenes
    $response = $this->get(route('index'));
    $response->assertStatus(200);
});
