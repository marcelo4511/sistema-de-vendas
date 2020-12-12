<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
            padding: 10px;
            width: 150px;
            text-align: center;
            align-items: center;
        }

        h5{
            color: black;
            font-size: 20px;
            text-align: center;
            width: 700px;
            padding: 5px;
            border: solid 5px black;
        }
    </style>
</head>
<body>

    <h5>Relatório da venda do cliente :  <b class="blue">{{$vendas['clients']->name}}</b></h5>
    <table class="table">
        <thead>
            <tr>
                <th  scope="col">Nome do Produto </th>
                <th scope="col">QTD</th>
                <th scope="col" >Preço do produto</th>
                <th scope="col">Total</th>
            </tr>

            
        </thead>
        <tbody table>
            @foreach($vendas['details_sales'] as $venda)
            <tr>
                <td>
                     {{ $venda['products']->name }}
                </td>
                <td>
                   {{$venda->descount}}
                </td>
            
                <td>
                    R$ {{  number_format($venda['price'],2,',','.') }}
                </td>
                <td>
                    R$ {{  number_format($venda['subtotal'],2,',','.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    Total dessa venda : <b class="blue"> R$ {{  number_format($vendas['total'],2,',','.') }}</b>
</body>

</html>

