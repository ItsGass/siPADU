<?php

use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::registration());
});

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'nim' => '2210119999',
        'program_studi' => 'Teknik Informatika',
        'no_hp' => '081234567890',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/beranda');

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'nim' => '2210119999',
        'program_studi' => 'Teknik Informatika',
        'role' => 'mahasiswa',
    ]);
});
