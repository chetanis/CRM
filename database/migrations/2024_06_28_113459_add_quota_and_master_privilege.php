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
            // add master privilege
            $table->enum('privilege', ['admin', 'superuser', 'user', 'master'])->default('user')->change();

            //add quota column
            $table->integer('quota')->default(0);
            //add current_quota column
            $table->integer('current_quota')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //remove the master privilege
            $table->enum('privilege', ['admin', 'superuser','user'])->default('user')->change();
            //remove quota column
            $table->dropColumn('quota');
            //remove current_quota column
            $table->dropColumn('current_quota');
        });
    }
};
