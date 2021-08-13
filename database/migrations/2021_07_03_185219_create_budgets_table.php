<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('client_id')->constrained()->nullable();
            $table->date('date')->nullable();
            $table->string('address')->nullable();
            $table->json('headings')->nullable();
            $table->json('conditions')->nullable();
            $table->longText('notes')->nullable();
            $table->json('team')->nullable();
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
        Schema::dropIfExists('budgets');
    }
}
