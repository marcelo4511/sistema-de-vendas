<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('data_compra');
            $table->float('total',14,2);  

            $table->unsignedInteger('fornecedor_id')->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('cascade');
           
            $table->unsignedInteger('situacao_id')->nullable();
            $table->foreign('situacao_id')->references('id')->on('situacao')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
