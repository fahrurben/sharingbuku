<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersTableAddBalanceAndOtherChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('balance')->default(0)->after('zip_code');
        });

        Schema::table('transaction', function (Blueprint $table) {
            $table->integer('point')->after('received_back_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('balance');
        });

        Schema::table('transaction', function (Blueprint $table) {
            $table->dropColumn('point');
        });
    }
}
