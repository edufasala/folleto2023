<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'codigo' => 'nullable|integer',
            'producto' => 'nullable|string',
            'medida' => 'nullable|string',
            'cantidad' => 'nullable|string',
            'esp' => 'nullable|string',
            'gr' => 'nullable|string',
            'lados' => 'nullable|string',
            'diseno' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'estado' => 'nullable|string',
            'estadoPedido' => 'nullable|string',
            'fecha' => 'nullable|date',
            'fechaEntrega' => 'nullable|date',
            'fechaEspecial' => 'nullable|date',
            'precioProducto' => 'nullable|numeric',
            'precioDiseno' => 'nullable|numeric',

            'especificaciones' => 'nullable|string',
            'terminacion' => 'nullable|string',
            'envio' => 'nullable|string',
            'precioEspecificaciones' => 'nullable|numeric',
            'precioEnvio' => 'nullable|numeric',

            'pago' => 'nullable|integer',
            'metodoPago' => 'nullable|string',
            'comentarioPago' => 'nullable|string',
            'iva' => 'nullable|integer',
            'seFacturo' => 'nullable|string',
            'facturaA' => 'nullable|string',

            'empresa_id' => 'nullable|integer',
            'sucursal' => 'nullable|array',
            'sucursal.id' => 'nullable|integer',
            'facturacion' => 'nullable|array',
            'facturacion.id' => 'nullable|integer',
            'direccion' => 'nullable|array',
            'direccion.id' => 'nullable|integer',
            'person' => 'nullable|array',
            'person.id' => 'nullable|integer',
            'person.name' => 'nullable|string',
            'person.last_name' => 'nullable|string',
            'person.dni' => 'nullable|string',
            'person.phone' => 'nullable|array',
            'person.phone.id' => 'nullable|integer',
            'person.phone.number' => 'nullable|string',
            'person.email' => 'nullable|array',
            'person.email.id' => 'nullable|integer',
            'person.email.email' => 'nullable|string',
        ];
    }
}
