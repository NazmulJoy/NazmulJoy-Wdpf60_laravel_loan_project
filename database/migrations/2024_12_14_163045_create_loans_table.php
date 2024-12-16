<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  
            $table->foreignId('loan_type_id')->constrained()->onDelete('cascade');  
            $table->decimal('amount', 10, 2);  
            $table->decimal('interest_rate', 5, 2);  
            $table->integer('duration');  
            $table->enum('status', ['pending', 'approved', 'rejected', 'disbursed', 'fully repaid'])->default('pending'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loans');
    }
}

