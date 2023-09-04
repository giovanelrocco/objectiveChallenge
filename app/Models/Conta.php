<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    public function updateSaldoConta(int $id_conta, float $valor)
    {
        $conta = Conta::find($id_conta);
        if (!$conta) {
            throw new \App\Exceptions\ContaException('Conta não encontrada');

        }
        $conta->saldo -= $valor;
        if ($conta->saldo < 0) {
            throw new \App\Exceptions\ContaException('Saldo insuficiente');

        }
        $conta->save();
    }
}
