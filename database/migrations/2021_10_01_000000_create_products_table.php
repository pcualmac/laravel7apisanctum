<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Schema table name to migrate.
     *
     * @var string
     */
    public $tableName = 'products';

    /**
     * Run the migrations.
     *
     * @table product
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('product_id');
            $table->string('product_name', 100)->nullable()->default(null);
            $table->text('product_desc')->nullable()->default(null);
            $table->unsignedInteger('product_category_id')->nullable()->default(null);
            $table->decimal('price', 15, 2);
            $table->softDeletes();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
