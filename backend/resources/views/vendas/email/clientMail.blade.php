
<p><b> Nome do Cliente: {{ $clients['name'] }}</b></p>

<p>Notificamos você acaba de fazer a compra de:</p>
<br>
<br>
<div>
<table>
  <thead>
    <tr>
      <th class="align-middle" scope="col" style="font-size: 1em; padding:10px; background:blue ;color:#fff;text-align: center;width:auto;">Nome do Produto </th>
      <th class="align-middle" scope="col" style="font-size: 1em; padding:10px; background:blue ;color:#fff;text-align: center;width:auto;">Imagem do Produto </th>
      <th class="align-middle" scope="col" style="font-size: 1em; padding:10px; background:blue ;color:#fff;text-align: center;width:auto;">QTD</th>
      <th class="align-middle" scope="col" style="font-size: 1em; padding:10px; background:blue ;color:#fff;text-align: center;width:auto;" >Preço do produto</th>
      <th class="align-middle" scope="col" style="font-size: 1em; padding:10px; background:blue ;color:#fff;text-align: center;width:auto;">Total do produto</th>
    </tr>
  </thead>
<tbody>
    @foreach($details_sales as $detalhe)
  <tr>
    <td  style="text-align:center;" width="10%">
      <span style="font-size:10pt;"  width="100" height="100"> {{ $detalhe['products']['name'] ?? null }}</span>
    </td>
    <td  style="text-align:center;" width="10%">
      <img src="{{  $detalhe['products']['imagem'] ?? null }}" alt="photo" width="100" height="100">
    </td>
    <td  style="text-align:center;" width="10%">
      <span style="font-size:10pt;"  width="100" height="100">{{ $detalhe['quantidade'] ?? null }}</span>
    </td>
    <td  style="text-align:center;" width="10%">
      <span style="font-size:10pt;"  width="100" height="100"> R$ {{ number_format($detalhe['price'],2,',','.') ?? null }}</span>
    </td>
    <td  style="text-align:center;" width="10%">
      <span style="font-size:10pt;"  width="100" height="100">R$ {{ number_format($detalhe['subtotal'],2,',','.') }}</span>
    </td>
  </tr>
@endforeach
</tbody>
<tfoot>
  <tr>
    <th colspan="1" scope="col" style="font-size: 1em;"><b>Total da sua compra:</b></th>
    <th scope="col" style="font-size: 1em;"><b> R$ {{ number_format($total,2,',','.') ?? null }}</b></th>
  </tr>
</tfoot>
</table>
</div>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
p.a {
  font-family: "Times New Roman", Times, serif;
}

p.b {
  font-family: Arial, Helvetica, sans-serif;
}
</style>