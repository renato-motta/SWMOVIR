<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalle de Movimiento</title>
    <style>
        body{font-family: sans-serif; font-size: 12px; margin: 10px;}
        .title{ text-align:center; font-size:18px; font-weight: bold; margin-bottom: 20px;}
        table{width: 100%; border-collapse: collapse; margin-top: 10px;}
        th,td {border :1px solid #ccc; padding: 6px 8px; text-align:left;}
        th { background-color: #f0f0f0;}
        .section{margin-top: 20px;}
    </style>
</head>
<body>
    <div class="title">Detalle de Movimiento #{{$model->serie}}-{{str_pad($model->correlative,4,'0', STR_PAD_LEFT)}}</div>
        <div>
            <strong>Fecha:</strong>{{\Carbon\Carbon::parse($model->date)->format('d/m/Y')}}<br>
            <strong>Tipo de movimmiento:</strong>{{$model->type == 1 ? 'Ingreso' : 'Salida'}}<br>
            <strong>Almacén:</strong>{{$model->warehouse->name}}<br>
            <strong>Motivo:</strong>{{$model->reason->name}}<br>
            <strong>Observacion:</strong>{{$model->observation ?? '-'}}
        </div>

        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model->products as $i => $product)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->pivot->quantity}}</td>
                            <td>S/ {{number_format($product->pivot->price,2)}}</td>
                            {{-- <td>S/ {{number_format($product->pivot->subtotal,2)}}</td> --}}
                            <td>S/ {{number_format($product->pivot->quantity * $product->pivot->price, 2)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    <div class="section" style="text-align: right;">
        <strong>Total: S/ {{number_format($model->total,2)}}</strong>
    </div>
    
</body>
</html>