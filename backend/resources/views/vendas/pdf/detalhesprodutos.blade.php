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
        
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #000;
        text-align: left;
        padding: 8px;
        align-items: center;
        }

        tr:nth-child(even) {
        background-color: #F8F8F8;
        }
        p.a {
        font-family: "Times New Roman", Times, serif;
        }

        p.b {
        font-family: Arial, Helvetica, sans-serif;
        }
        h5{
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            font-size: 20px;
            text-align: center;
            width: 700px;
            padding: 5px;
            background-color: white;
            border: solid 5px blue;
        }
    </style>
</head>
<body>

    <h5>Cliente :  <b class="blue">{{$vendas['clients']->name}}</b></h5>
    <table class="table">
        <thead>
            <tr>
                <th class="align-middle" scope="col" style="font-size: 1em; padding:10px; background:blue ;color:#fff;text-align: center;width:auto;">Nome do Produto </th>
                <th class="align-middle" scope="col" style="font-size: 1em; padding:10px; background:blue ;color:#fff;text-align: center;width:auto;">Imagem do Produto </th>
                <th class="align-middle" scope="col" style="font-size: 1em; padding:10px; background:blue ;color:#fff;text-align: center;width:auto;">QTD</th>
                <th class="align-middle" scope="col" style="font-size: 1em; padding:10px; background:blue ;color:#fff;text-align: center;width:auto;" >Preço do produto</th>
                <th class="align-middle" scope="col" style="font-size: 1em; padding:10px; background:blue ;color:#fff;text-align: center;width:auto;">Total</th>
            </tr>
        </thead>
        <tbody width="70%">
            @foreach($vendas['details_sales'] as $venda)
            <tr>
                <td class="align-middle" width="10%">
                    {{ $venda['products']->name }}
                </td>
                <td class="align-middle text-center" width="10%"><br />
                    <img src="{{ $venda['products']['imagem'] ?? null}}" alt="photo" width="100" height="100"></img>
                </td>
                <td class="align-middle" width="10%">
                   {{$venda->quantidade}}
                </td>
            
                <td class="align-middle" width="10%">
                    R$ {{  number_format($venda['price'],2,',','.') }}
                </td>
                <td class="align-middle" width="10%">
                    R$ {{  number_format($venda['subtotal'],2,',','.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table><br />

    <span style="font-family: Arial, Helvetica, sans-serif;"> Total dessa venda : </span> <b class="font-size: 10px;"> R$ {{  number_format($vendas['total'],2,',','.') }}</b>
</body>

</html>

