<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique();
            $table->string('alternate_phone')->unique()->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth');

            $table->enum('role', ['lead', 'admin'])->nullable();

            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('country')->default('India');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'alternate_phone',
                'gender',
                'date_of_birth',
                'role',
                'address_line_1',
                'address_line_2',
                'city',
                'state',
                'pincode',
                'country',
            ]);
        });
    }
};
