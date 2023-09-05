<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transacoes extends Model
{
    const METODO_PAGAMENTO_CREDITO = "C";
    const METODO_PAGAMENTO_DEBITO = "D";
    const METODO_PAGAMENTO_PIX = "P";

    const TAXA_METODO_PAGAMENTO_CREDITO = 0.05;
    const TAXA_METODO_PAGAMENTO_DEBITO = 0.03;
    const TAXA_METODO_PAGAMENTO_PIX = 0;

    use HasFactory;

    public static function saveTransacao(Transacoes $transacao)
    {
        try {
            DB::beginTransaction();

            $conta = new Conta;
            $saldo_debitar = $transacao->calcularSaldoDebitar($transacao->forma_pagamento, $transacao->valor);
            $conta->updateSaldoConta($transacao->conta_id, $saldo_debitar);
            $transacao->save();

            DB::commit();

            return $transacao;

        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            throw new \App\Exceptions\TransacoesException('Erro ao salvar a informação');

        }
    }

    public function calcularSaldoDebitar(string $forma_pagamento, float $valor_transacao): float
    {
        $saldo_debitar = $valor_transacao;
        switch ($forma_pagamento) {
            case Transacoes::METODO_PAGAMENTO_CREDITO:
                $saldo_debitar += $valor_transacao * Transacoes::TAXA_METODO_PAGAMENTO_CREDITO;
                break;
            case Transacoes::METODO_PAGAMENTO_DEBITO:
                $saldo_debitar += $valor_transacao * Transacoes::TAXA_METODO_PAGAMENTO_DEBITO;
                break;
            case Transacoes::METODO_PAGAMENTO_PIX:
                $saldo_debitar = $valor_transacao;
                break;

            default:
                throw new \App\Exceptions\TransacoesException('Método de pagamento não encontrado');
                break;
        }

        return $saldo_debitar;
    }
}
