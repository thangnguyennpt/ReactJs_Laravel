<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer ('user_id')->unsigned()->index();
            $table->integer('stock_id')->unsigned()->index();
            $table->integer('quantity');
            $table->string('note')->nullable();
            $table->string('status');
            $table->timestamps();
        });

            if (config('app.debug') == true) {
            DB::table('orders')->insert([
            ['user_id' => 1,
            'stock_id' => 1,
            'quantity' => 1,
            'note' => null,
            'status' => 'completed',
            'created_at' => now()],
            ]);
            DB::table('orders')->insert([
            ['user_id' => 21,
            'stock_id' => 1,
            'quantity' => 2,
            'note' => null,
            'status' => 'completed',
            'created_at' => now()],
            ]);
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
