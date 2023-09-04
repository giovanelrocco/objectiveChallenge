<?php

namespace Tests\Feature;

use App\Models\Conta;
use App\Models\Transacoes;
use PHPUnit\Framework\assertTrue;
use Tests\TestCase;

class TransacoesTest extends TestCase
{
    public function test_api_transacoes_is_showing(): void
    {
        $conta = Conta::factory()->create();
        $transacao = Transacoes::factory()->create(['conta_id' => $conta->id]);

        $response = $this
            ->get('/api/transacoes');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $transacao->id, 'conta_id' => $conta->id]);

    }

    public function test_api_transacao_is_showing(): void
    {
        $conta = Conta::factory()->create();
        $transacao = Transacoes::factory()->create(['conta_id' => $conta->id]);

        $response = $this
            ->get('/api/transacao');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $transacao->id, 'conta_id' => $conta->id]);

    }

    public function test_api_transacao_is_creating(): void
    {
        $conta = Conta::factory()->create(['saldo' => 600]);
        $valor = fake()->randomFloat(4, 0, 490);

        $transacao = [
            'conta_id' => $conta->id,
            'forma_pagamento' => 'D',
            'valor' => $valor,
        ];

        $response = $this
            ->put('/api/transacao', $transacao);

        $response->assertStatus(201);
        $conta_updated = Conta::find($conta->id);
        $this->assertTrue($conta_updated->saldo == 600 - $valor);
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
