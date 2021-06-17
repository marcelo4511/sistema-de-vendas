<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsToReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills_to_receive', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao')->nullable();
            $table->date('dt_vencimento')->nullable(); 
            $table->decimal('valor',14,2); 
            $table->longText('comprovante')->nullable();

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
        Schema::dropIfExists('bills_to_receive');
    }
}
