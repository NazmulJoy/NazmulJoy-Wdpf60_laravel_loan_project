<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentsTableAddTransactionIdAndPendingStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
           
            $table->string('transaction_id')->after('method');

   
            if (Schema::getColumnType('payments', 'status') === 'enum') {
                $table->enum('status', ['pending', 'completed', 'failed'])->default('pending')->change();
            } else {
            
                $table->string('status')->default('pending')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
          
            $table->dropColumn('transaction_id');

           
            if (Schema::getColumnType('payments', 'status') === 'enum') {
                $table->enum('status', ['completed', 'failed'])->default('completed')->change();
            } else {
                $table->string('status')->default('completed')->change();
            }
        });
    }
}
