<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transacoes extends Model
{
    use HasFactory;

    public static function saveTransacao(Transacoes $transacao)
    {
        try {
            DB::beginTransaction();

            $conta = new Conta;
            $conta->updateSaldoConta($transacao->conta_id, $transacao->valor);
            $transacao->save();

            DB::commit();

            return $transacao;

        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            throw new \App\Exceptions\TransacoesException('Erro ao salvar a informação');

        }
    }
}
