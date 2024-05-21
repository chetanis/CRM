<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('commands', function (Blueprint $table) {
            $table->dropColumn('products');
        });
    }

    public function down()
    {
        Schema::table('commands', function (Blueprint $table) {
            $table->json('products'); // Assuming 'products' was of type JSON
        });
    }
};
