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
    const METODO_PAGAMENTO_ESTORNO = "E";

    const TAXA_METODO_PAGAMENTO_CREDITO = 0.05;
    const TAXA_METODO_PAGAMENTO_DEBITO = 0.03;
    const TAXA_METODO_PAGAMENTO_PIX = 0;
    const TAXA_METODO_PAGAMENTO_ESTORNO = 0;

    const TIPO_OPERACAO_CREDITO = "C";
    const TIPO_OPERACAO_DEBITO = "D";

    use HasFactory;

    public static function saveTransacao(Transacoes $transacao)
    {
        try {
            DB::beginTransaction();

            $conta = new Conta;
            $saldo = $transacao->calcularSaldoDebitar();
            $tipo_operacao = $transacao->verificarTipoOperacao();
            $conta->updateSaldoConta($transacao->conta_id, $saldo, $tipo_operacao);
            $transacao->taxa_percentual = $transacao->buscarTaxaPercentual($transacao->forma_pagamento);
            $transacao->valor_total = $saldo;
            $transacao->save();

            DB::commit();

            return $transacao;

        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            throw new \App\Exceptions\TransacoesException('Erro ao salvar a informação');

        }
    }

    public function verificarTipoOperacao(): string
    {
        switch ($this->forma_pagamento) {
            case Transacoes::METODO_PAGAMENTO_CREDITO:
            case Transacoes::METODO_PAGAMENTO_DEBITO:
            case Transacoes::METODO_PAGAMENTO_PIX:
                return Transacoes::TIPO_OPERACAO_DEBITO;
                break;
            case Transacoes::METODO_PAGAMENTO_ESTORNO:
                return Transacoes::TIPO_OPERACAO_CREDITO;
                break;
            default:
                throw new \App\Exceptions\TransacoesException('Método de pagamento não encontrado 2');
                break;
        }
    }

    public function calcularSaldoDebitar(): float
    {
        $saldo = $this->valor;
        switch ($this->forma_pagamento) {
            case Transacoes::METODO_PAGAMENTO_CREDITO:
                $saldo += $this->valor * Transacoes::TAXA_METODO_PAGAMENTO_CREDITO;
                break;
            case Transacoes::METODO_PAGAMENTO_DEBITO:
                $saldo += $this->valor * Transacoes::TAXA_METODO_PAGAMENTO_DEBITO;
                break;
            case Transacoes::METODO_PAGAMENTO_PIX:
                $saldo = $this->valor;
                break;
            case Transacoes::METODO_PAGAMENTO_ESTORNO:
                $saldo = $this->valor;
                break;
            default:
                throw new \App\Exceptions\TransacoesException('Método de pagamento não encontrado 1');
                break;
        }

        return $saldo;
    }

    public function buscarTaxaPercentual(string $forma_pagamento): float
    {
        switch ($forma_pagamento) {
            case Transacoes::METODO_PAGAMENTO_CREDITO:
                $taxa_percentual = Transacoes::TAXA_METODO_PAGAMENTO_CREDITO;
                break;
            case Transacoes::METODO_PAGAMENTO_DEBITO:
                $taxa_percentual = Transacoes::TAXA_METODO_PAGAMENTO_DEBITO;
                break;
            case Transacoes::METODO_PAGAMENTO_PIX:
            case Transacoes::METODO_PAGAMENTO_ESTORNO:
                $taxa_percentual = Transacoes::TAXA_METODO_PAGAMENTO_PIX;
                break;

            default:
                throw new \App\Exceptions\TransacoesException('Método de pagamento não encontrado');
                break;
        }

        return $taxa_percentual;
    }
}
