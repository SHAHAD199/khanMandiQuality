<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->date('order_date')->nullable();           
            $table->boolean('response')->default(0);
            $table->foreignId('order_type_id')->constrained()->onDelete('cascade');
            $table->string('meal')->nullable();
            $table->string('city');
            $table->float('bill');
            $table->string('main_course')->nullable();
            $table->string('drinks')->nullable();
            $table->string('additions')->nullable();
            $table->string('appetizers')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('add_status')->default(0);
            $table->boolean('call_status')->default(0);
            $table->string('added_by')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
