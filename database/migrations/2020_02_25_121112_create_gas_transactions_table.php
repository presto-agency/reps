<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGasTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gas_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('initializable_id')->nullable();
            $table->string('initializable_type')->nullable();

            //debit
            $table->bigInteger('incoming')->unsigned()->default(0)->comment('приход');

            //credit
            $table->bigInteger('outgoing')->unsigned()->default(0)->comment('расход');

            $table->text('description');

            $table->timestamps();
        });

        Schema::table('gas_transactions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gas_transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('gas_transactions');
    }
}
