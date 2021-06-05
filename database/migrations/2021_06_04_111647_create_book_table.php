<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('author');
            $table->foreignId('category_id')->constrained('book_category');
            $table->string('isbn')->nullable();
            $table->bigInteger('thumbnail')->nullable();
            $table->timestamp('created_at');
            $table->bigInteger('created_by');
            $table->timestamp('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book');
    }
}
