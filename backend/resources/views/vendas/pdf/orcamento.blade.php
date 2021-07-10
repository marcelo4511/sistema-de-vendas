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
            width: 210px;
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
    <h5>Relatório de vendas</h5>
    <table class="table">
        <thead>
            <tr>
                <th  scope="col">Data da venda </th>
                <th  scope="col">Nome do Cliente </th>
                <th  scope="col" >Total da venda</th>
            </tr>

            
        </thead>
        <tbody table>
            @foreach($vendas as $venda)
            <tr>
                <td>
                   {{date('d/m/Y', strtotime($venda->dataVenda))}}
                </td>
                <td>
                     {{ $venda->clients->name }}
                </td>
                <td>
                    R$ {{  number_format($venda['total'],2,',','.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
