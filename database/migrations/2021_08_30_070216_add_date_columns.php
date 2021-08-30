<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_files', function (Blueprint $table) {
           $table->integer('date')->nullable();
           $table->integer('month')->nullable();
           $table->year('year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_files', function (Blueprint $table) {
           $table->dropColumn('date');
           $table->dropColumn('month');
           $table->dropColumn('year');
        });
    }
}
