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
        Schema::create('addresses', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->increments('id');
                $table->integer('user_id')->unsigned()->index();
                $table->renameColumn('firstname', 'first_name');
                $table->string('lastname');
                $table->string('address');
                $table->string('city');
                $table->string('country');
                $table->string('zip');
                $table->string('telephone');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->renameColumn('first_name', 'firstname');
        });
    }
};