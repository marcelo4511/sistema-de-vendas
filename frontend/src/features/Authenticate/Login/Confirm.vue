<template>
  <div class="confirmacao">
    <fieldset class="form-group col-md-6">
      <h4 class="titulo1"><i class="fa fa-user">  </i> Sistema de vendas </h4>
      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control"><br>
        <label> Digite uma Senha</label>
        <input type="password" class="form-control"><br>
        <label>Confirme a Senha</label>
        <input type="password" class="form-control"><br>
        <button class="btn btn-primary">Entrar</button><br><br>
      </div>
      </fieldset>
  </div>
</template>

<script>
export default {

}
</script>

<style>
  div .confirmacao{
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px;
  }

  div .confirmacao p{
    display: flex;
    justify-content: center;
    align-items: center;
  }

  div .titulo1{
    display: flex;
    align-items: center;
    margin: 20px;
    justify-content: center;
  }
</style>