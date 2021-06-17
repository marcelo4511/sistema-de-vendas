<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao')->nullable();
            $table->date('dt_vencimento')->nullable(); 
            $table->decimal('valor',14,2); 
            $table->longText('comprovante')->nullable();

            $table->integer('tipo_movimentacao_id')->unsigned()->nullable();
            $table->foreign('tipo_movimentacao_id')->references('id')->on('tipo_movimentacao')->onDelete('cascade')->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimentacoes');
    }
}
