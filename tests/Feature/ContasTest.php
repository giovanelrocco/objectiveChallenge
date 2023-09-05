<?php

namespace Tests\Feature;

use App\Models\Conta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContasTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_contas_show_empty_list(): void
    {
        $response = $this
            ->get('/api/contas');

        $response->assertStatus(200);
        $response->assertJsonCount(0);

    }

    public function test_api_contas_show_list_with_content(): void
    {
        $conta = Conta::factory()->create();

        $response = $this
            ->get('/api/contas');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(["username" => $conta->username]);
        $response->assertJsonFragment(["saldo" => $conta->saldo]);

    }

    public function test_api_conta_show_list_with_content(): void
    {
        $conta = Conta::factory()->create();

        $response = $this
            ->get('/api/conta');

        $response->assertStatus(200);
        $response->assertJsonFragment(["username" => $conta->username]);
        $response->assertJsonFragment(["saldo" => $conta->saldo]);

    }

    public function test_api_conta_show_not_found(): void
    {
        $response = $this
            ->get('/api/conta/' . fake()->numberBetween(1000, 2000));

        $response->assertStatus(404);

    }

    public function test_api_conta_show_by_id(): void
    {
        $conta = Conta::factory()->create();

        $response = $this
            ->get('/api/conta/' . $conta->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(["username" => $conta->username]);
        $response->assertJsonFragment(["saldo" => $conta->saldo]);

    }

    public function test_api_conta_create(): void
    {
        $conta = [
            'username' => fake()->name(),
            'saldo' => 600.00,
        ];

        $response = $this
            ->put('/api/conta', $conta);

        $response->assertStatus(201);
        $response->assertContent('');

    }

    public function test_api_conta_update(): void
    {
        $conta = Conta::factory()->create();

        $conta_update = [
            'username' => fake()->name(),
            'saldo' => 50.00,
        ];

        $response = $this
            ->patch('/api/conta/' . $conta->id, $conta_update);

        $response->assertStatus(204);
        $response->assertContent('');

    }
}
