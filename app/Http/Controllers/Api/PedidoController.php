<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pedido::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'pizza' => 'required',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
        ]);
        $pedido = Pedido::create($validated);
        return response()->json($pedido, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::findOrFail($id);
        return response()->json($pedido);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $validated = $request->validate([
            'cliente' => 'sometimes|required',
            'telefono' => 'sometimes|required',
            'direccion' => 'sometimes|required',
            'pizza' => 'sometimes|required',
            'cantidad' => 'sometimes|required|integer',
            'precio' => 'sometimes|required|numeric',
            'estado' => 'sometimes|required|in:pendiente,preparando,entregado',
        ]);
        $pedido->update($validated);
        return response()->json($pedido);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();
        return response()->json(null, 204);
    }
}
