<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable(); 
            $table->enum('marital_status', ['single', 'married'])->nullable(); 
            $table->string('mobile_number')->nullable();
            $table->text('present_address')->nullable(); 
            $table->string('state')->nullable(); 
            $table->string('city')->nullable(); 
            $table->string('postal_code')->nullable(); 
            $table->string('image')->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'date_of_birth',
                'marital_status',
                'mobile_number',
                'present_address',
                'state',
                'city',
                'postal_code',
                'image',
            ]);
        });
    }
}
