<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    public function updateSaldoConta(int $id_conta, float $valor, string $operacao)
    {
        $conta = Conta::find($id_conta);
        if (!$conta) {
            throw new \App\Exceptions\ContaException('Conta não encontrada');

        }
        if ($operacao == Transacoes::TIPO_OPERACAO_DEBITO) {
            $conta->saldo -= $valor;
        } elseif ($operacao == Transacoes::TIPO_OPERACAO_CREDITO) {
            $conta->saldo += $valor;
        } else {
            throw new \App\Exceptions\ContaException('Operação não identificada');
        }

        if ($conta->saldo < 0) {
            throw new \App\Exceptions\ContaException('Saldo insuficiente');

        }
        $conta->save();
    }
}
