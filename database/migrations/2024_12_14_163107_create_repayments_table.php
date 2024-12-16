<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');  
            $table->integer('installment_number');  
            $table->date('due_date');  
            $table->decimal('amount', 10, 2);  
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending'); 
            $table->timestamp('paid_at')->nullable();  
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('repayments');
    }
}
