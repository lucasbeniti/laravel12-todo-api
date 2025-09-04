<?php

use App\Models\User;

it('não permite acessar tarefas sem autenticação', function () {
    $this->getJson('/api/tasks')->assertStatus(401);
});

it('permite usuário autenticado criar tarefa', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $response = $this->withToken($token)->postJson('/api/tasks', [
        'title' => 'Minha primeira tarefa',
    ]);

    $response->assertStatus(201)
        ->assertJsonFragment(['title' => 'Minha primeira tarefa']);
});
