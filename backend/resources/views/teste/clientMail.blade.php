
<p><b> Nome do Cliente: {{$clients['name']}}</b></p>

<p>Notificamos você acaba de fazer a compra de:</p>
<br>
<br>
<div>
<table>
  <thead>
    <tr>
      <th class="align-middle" scope="col" style="font-size: 1em;"><b>Nome do produto:</b></th>
      <th class="align-middle" scope="col" style="font-size: 1em;"><b>Imagem:</b></th>
      <th class="align-middle" scope="col" style="font-size: 1em;"><b>Quantidade:</b></th>
      <th class="align-middle" scope="col" style="font-size: 1em;"><b>Preço:</b></th>
      <th class="align-middle" scope="col" style="font-size: 1em;"><b>Total do Produto:</b></th>
    </tr>
  </thead>
<tbody>
    @foreach($details_sales as $d)
  <tr>
    <td class="align-middle" width="10%">
      <span style="font-size:10pt;"  width="100" height="100"> {{ $d['products']['name'] ?? null }}</span>
    </td>
    <td class="align-middle" width="10%">
      <img src="$d['products']['imagem'] ?? null" alt="photo" width="100" height="100"></img>
    </td>
    <td class="align-middle" width="10%">
      <span style="font-size:10pt;"  width="100" height="100">{{ $d['quantidade'] ?? null }}</span>
    </td>
    <td class="align-middle" width="10%">
      <span style="font-size:10pt;"  width="100" height="100"> R$ {{ number_format($d['price'],2,',','.') ?? null }}</span>
    </td>
    <td class="align-middle" width="10%">
      <span style="font-size:10pt;"  width="100" height="100">R$ {{ number_format($d['subtotal'],2,',','.') }}</span>
    </td>
  </tr>
@endforeach
</tbody>
<tfoot>
  <tr>
    <th colspan="4" scope="col" style="font-size: 1em;"><b>Total da sua compra:</b></th>
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