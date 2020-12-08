<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="utf-8"/>
    <title>Lista de Vendas</title>
    <style>
        html{
            box-sizing: border-box;
        }
        *,*::after,*::before{
            box-sizing: inherit;
        }
        table{
            border-collapse: collapse;
        }

        td,th,tr{
            border:1px solid black;
            border-spacing: 0;
            width:800px;
            padding: 10px;
        }

        h5{
            color: black;
            font-size: 10px;
            text-align: center;
            width: 400px;
            border: solid 5px black;
        }
    </style>
</head>
<body>
    <h5>Relatório de vendas</h5>
    <table>
        <thead>
            <tr>
                <th>Data da venda :</th>
                <th>Nome do Cliente : </th>
                <th>Total da venda :</th>
            </tr>

            
        </thead>
        <tbody>
            @foreach($vendas as $venda)
            <tr>
                <td>
                    {{ $venda->dataVenda }}
                </td>
                <td>
                     {{ $venda->clients->name }}
                </td>
                <td>
                    {{ $venda->total }}
                </td>
               
               @foreach($venda->details_sales as $detalhes)
               <tr>{{$detalhes->price}}</tr>
                    @foreach($detalhes->products as $produto)
                    <b>{{$produto->name}}</b>
                    @endforeach
               <tr>{{$detalhes->amount}}</tr>
               <tr>{{$detalhes->subtotal}}</tr>
               @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
