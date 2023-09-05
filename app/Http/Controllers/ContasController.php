<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;

class ContasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contas = Conta::all();
        return response()->json($contas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $conta = new Conta;

        $conta->username = $request->username;
        $conta->saldo = $request->saldo;

        $conta->save();

        return response('', 201)
            ->header('Content-Type', 'application/json');

    }

    /**
     * Display the specified resource.
     */
    public function show(Conta $conta, int $id)
    {
        $conta = Conta::find($id);

        if (!$conta) {
            throw new \App\Exceptions\ContaException('Conta não encontrada');
        }

        return response()->json($conta);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $conta = Conta::find($request->id);

        $conta->username = $request->username;
        $conta->saldo += $request->saldo;

        $conta->save();

        return response('', 204)
            ->header('Content-Type', 'application/json');

    }
}
