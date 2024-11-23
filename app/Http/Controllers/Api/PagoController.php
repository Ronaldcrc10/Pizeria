<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pago::with(['cliente', 'pedido'])->get();
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
            'cliente_id' => 'required|exists:clientes,id',
            'pedido_id' => 'required|exists:pedidos,id',
            'monto' => 'required|numeric',
            'metodo_pago' => 'required|in:efectivo,tarjeta,paypal',
        ]);

        $pago = Pago::create($validated);
        return response()->json($pago, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pago = Pago::with(['cliente', 'pedido'])->findOrFail($id);
        return response()->json($pago);
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
        $pago = Pago::findOrFail($id);

        $validated = $request->validate([
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'pedido_id' => 'sometimes|required|exists:pedidos,id',
            'monto' => 'sometimes|required|numeric',
            'metodo_pago' => 'sometimes|required|in:efectivo,tarjeta,paypal',
        ]);

        $pago->update($validated);
        return response()->json($pago);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();
        return response()->json(null, 204);
    }
}
