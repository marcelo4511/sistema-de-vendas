
<p><b> Nome do Cliente: {{$clients['name']}}</b></p>

<p>Notificamos formalmente a vossa equipe que vc fez a compra de:</p>
<br>
<br>
<div class="linha">

    <b>Nome do produto:</b><br>
    @foreach($details_sales as $d)
    {{ $d['products']['name'] ?? null }}<br>
    @endforeach
    
    <b>Quantidade:</b><br>
    @foreach($details_sales as $d)
    {{ $d['descount'] ?? null }}<br>
    @endforeach
    
    <b>Preco:</b><br>
    @foreach($details_sales as $d)
    R$ {{ number_format($d['price'],2,',','.') ?? null }}<br>
    @endforeach
    
    <b>Total do produto:</b><br>
    @foreach($details_sales as $d)
    R$ {{ number_format($d['subtotal'],2,',','.') }}<br>
    @endforeach
    <br>
</div>
<br>

<br>
<br>

<style>
    .linha{
        margin: 20px;
        width: 700px;
        height: 280px;
    }
</style>