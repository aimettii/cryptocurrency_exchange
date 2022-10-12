<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_from')->constrained('currencies')->cascadeOnDelete();
            $table->foreignId('currency_to')->constrained('currencies')->cascadeOnDelete();
            $table->double('rate');
            $table->decimal('tax', 2, 2);
            $table->enum('api', [
                \App\Models\Ticker::API_BLOCKCHAIN_TYPE,
                \App\Models\Ticker::API_COINGECKO_TYPE,
            ]);
            $table->boolean('is_active');
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
        Schema::dropIfExists('tickers');
    }
};
