<?php

namespace Tests\Feature;

use App\Models\Conta;
use App\Models\Transacoes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransacoesTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_transacoes_show_empty_list(): void
    {
        $response = $this
            ->get('/api/transacoes');

        $response->assertStatus(200);
        $response->assertJsonCount(0);

    }

    public function test_api_transacoes_show_list_with_content(): void
    {
        $conta = Conta::factory()->create();
        $transacao = Transacoes::factory()->create(['conta_id' => $conta->id]);

        $response = $this
            ->get('/api/transacoes');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $transacao->id, 'conta_id' => $conta->id]);

    }

    public function test_api_transacao_show_list_with_content(): void
    {
        $conta = Conta::factory()->create();
        $transacao = Transacoes::factory()->create(['conta_id' => $conta->id]);

        $response = $this
            ->get('/api/transacao');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $transacao->id, 'conta_id' => $conta->id]);

    }

    public function test_api_transacao_show_not_found(): void
    {
        $response = $this
            ->get('/api/transacao/' . fake()->numberBetween(1000, 2000));

        $response->assertStatus(404);

    }

    public function test_api_transacao_credito_create(): void
    {
        $conta = Conta::factory()->create(['saldo' => 600.00]);
        $valor = fake()->randomFloat(2, 0, 490);

        $transacao = [
            'conta_id' => $conta->id,
            'forma_pagamento' => Transacoes::METODO_PAGAMENTO_CREDITO,
            'valor' => $valor,
        ];

        $response = $this
            ->put('/api/transacao', $transacao);

        $response->assertStatus(201);

        $conta_updated = Conta::find($conta->id);

        $valor_debitar = $valor * (1 + Transacoes::TAXA_METODO_PAGAMENTO_CREDITO);
        $saldo_atualizado = round($conta->saldo - $valor_debitar, 4);

        $this->assertTrue($conta_updated->saldo == $saldo_atualizado);
    }

    public function test_api_transacao_pix_create(): void
    {
        $conta = Conta::factory()->create(['saldo' => 600.00]);
        $valor = fake()->randomFloat(2, 0, 490);

        $transacao = [
            'conta_id' => $conta->id,
            'forma_pagamento' => Transacoes::METODO_PAGAMENTO_PIX,
            'valor' => $valor,
        ];

        $response = $this
            ->put('/api/transacao', $transacao);

        $response->assertStatus(201);
        $conta_updated = Conta::find($conta->id);

        $valor_debitar = $valor * (1 + Transacoes::TAXA_METODO_PAGAMENTO_PIX);
        $saldo_atualizado = round($conta->saldo - $valor_debitar, 4);

        $this->assertTrue($conta_updated->saldo == $saldo_atualizado);
    }

    public function test_api_transacao_debito_create(): void
    {
        $conta = Conta::factory()->create(['saldo' => 600.00]);
        $valor = fake()->randomFloat(2, 0, 490);

        $transacao = [
            'conta_id' => $conta->id,
            'forma_pagamento' => Transacoes::METODO_PAGAMENTO_DEBITO,
            'valor' => $valor,
        ];

        $response = $this
            ->put('/api/transacao', $transacao);

        $response->assertStatus(201);

        $conta_updated = Conta::find($conta->id);

        $valor_debitar = $valor * (1 + Transacoes::TAXA_METODO_PAGAMENTO_DEBITO);
        $saldo_atualizado = round($conta->saldo - $valor_debitar, 4);

        $this->assertTrue($conta_updated->saldo == $saldo_atualizado);
    }

    public function test_api_transacao_show_by_id(): void
    {
        $conta = Conta::factory()->create();
        $transacao = Transacoes::factory()->create(['conta_id' => $conta->id]);

        $response = $this
            ->get('/api/transacao/' . $transacao->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(["conta_id" => $conta->id]);
        $response->assertJsonFragment(["forma_pagamento" => $transacao->forma_pagamento]);
        $response->assertJsonFragment(["id" => $transacao->id]);

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
