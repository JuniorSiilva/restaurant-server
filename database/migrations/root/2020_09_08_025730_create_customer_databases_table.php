<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_databases', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('host')->default('127.0.0.1');
            $table->string('port')->default('5432');
            $table->string('user')->default('postgres');
            $table->string('password')->default('root');
            $table->string('driver')->default('pgsql');
            $table->foreignId('customer_id');
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_databases');
    }
}
