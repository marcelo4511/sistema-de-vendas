<template>
  <div class="plano-de-fundo">
    <fieldset class="form-group col-md-6">
      <h4 class="titulo"><i class="fa fa-user">  </i> Sistema de vendas </h4>
      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control"><br>
        <label>Senha</label>
        <input type="password" class="form-control"><br>
        <button class="btn btn-primary">Entrar</button><br><br>
        <p>Se você ainda não é um usuário <a href="/confirm">Registrar </a></p>
      </div>
      </fieldset>
  </div>
</template>

<script>
export default {

}
</script>

<style>

  div .plano-de-fundo{
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px;
  }

  div .plano-de-fundo p{
    display: flex;
    justify-content: center;
    align-items: center;
  }

  div .titulo{
    display: flex;
    align-items: center;
    margin: 20px;
    justify-content: center;
  }
</style>