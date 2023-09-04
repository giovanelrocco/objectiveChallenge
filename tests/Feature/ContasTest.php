<?php

namespace Tests\Feature;

use App\Models\Conta;
use Tests\TestCase;

class ContasTest extends TestCase
{
    public function test_api_contas_is_showing(): void
    {
        $conta = Conta::factory()->create();

        $response = $this
            ->get('/api/contas');

        $response->assertStatus(200);
        // $response->assertJsonFragment($conta);
    }

    public function test_api_conta_is_showing(): void
    {
        $conta = Conta::factory()->create();

        $response = $this
            ->get('/api/conta');

        $response->assertStatus(200);
        // $response->assertJsonFragment($conta);
    }

    public function test_api_conta_is_creating(): void
    {
        $conta = [
            'username' => fake()->name(),
            'saldo' => 600.00,
        ];

        $response = $this
            ->put('/api/conta', $conta);

        $response->assertStatus(200);
        // $response->username == $conta['username'];
        // $response->saldo == $conta['saldo'];
        // $response->assertJsonFragment($conta);
    }

    public function test_api_conta_is_updating(): void
    {
        $conta = Conta::factory()->create();

        $conta_update = [
            'username' => fake()->name(),
            'saldo' => 50.00,
        ];

        $response = $this
            ->patch('/api/conta/' . $conta->id, $conta_update);

        $response->assertStatus(200);
        // $response->username == $conta['username'];
        // $response->saldo == 1100.00;
        // $response->assertJsonFragment($conta);
    }
}
