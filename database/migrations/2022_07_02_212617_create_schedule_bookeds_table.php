<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleBookedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_bookeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->date('date');
            $table->time('time');
            $table->bigInteger('payment_method_id');
            $table->enum('status',['PENDING','APPROVE','REJECT','SUCCESS','CANCEL'])->default('PENDING');
            $table->bigInteger('total');
            $table->string('payment_proof')->nullable();
            $table->tinyInteger('payment_proof_status')->default(0);
            $table->string('payment_url')->nullable();
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
        Schema::dropIfExists('schedule_bookeds');
    }
}
