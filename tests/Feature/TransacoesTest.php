<?php

namespace Tests\Feature;

use App\Models\Transacoes;
use Tests\TestCase;

class TransacoesTest extends TestCase
{
    public function test_api_transacoes_is_showing(): void
    {
        $transacao = Transacoes::factory()->create();

        $response = $this
            ->get('/api/transacoes');

        $response->assertStatus(200);
        // $response->assertJsonFragment($transacao);
    }

    public function test_api_transacao_is_showing(): void
    {
        $transacao = Transacoes::factory()->create();

        $response = $this
            ->get('/api/transacao');

        $response->assertStatus(200);
        // $response->assertJsonFragment($transacao);
    }

    public function test_api_transacao_is_creating(): void
    {
        $transacao = [
            'conta_id' => 1,
            'forma_pagamento' => 'D',
            'valor' => 600.00,

        ];

        $response = $this
            ->put('/api/transacao', $transacao);

        $response->assertStatus(200);
        // $response->username == $transacao['username'];
        // $response->saldo == $transacao['saldo'];
        // $response->assertJsonFragment($transacao);
    }

    // public function test_api_transacao_is_updating(): void
    // {
    //     $transacao = Transacoes::factory()->create();

    //     $transacao_update = [
    //         'username' => fake()->name(),
    //         'saldo' => 50.00,
    //     ];

    //     $response = $this
    //         ->patch('/api/transacao/' . $transacao->id, $transacao_update);

    //     $response->assertStatus(200);
    //     // $response->username == $transacao['username'];
    //     // $response->saldo == 1100.00;
    //     // $response->assertJsonFragment($transacao);
    // }
}
