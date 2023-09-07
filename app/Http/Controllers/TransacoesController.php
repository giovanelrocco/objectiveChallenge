<?php

namespace App\Http\Controllers;

use App\Models\Transacoes;
use Illuminate\Http\Request;

class TransacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transacoes = Transacoes::all();
        return response()->json($transacoes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transacao = new Transacoes;

        $transacao->forma_pagamento = $request->forma_pagamento;
        $transacao->conta_id = $request->conta_id;
        $transacao->valor = $request->valor;

        $response = Transacoes::saveTransacao($transacao);

        return response('', 201)
            ->header('Content-Type', 'application/json');

    }

    /**
     * Display the specified resource.
     */
    public function show(Transacoes $transacoes, int $id)
    {
        $transacao = Transacoes::find($id);

        if (!$transacao) {
            throw new \App\Exceptions\TransacoesException('Conta não encontrada');

        }

        return response()->json($transacao);

    }

}
