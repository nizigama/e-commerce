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
        Schema::create('Cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("productID");
            $table->unsignedBigInteger("userID");
            $table->integer("qty");
            $table->timestamps();

            $table->foreign("productID")->references("id")->on("Product")
                ->onUpdate("cascade")
                ->onDelete("restrict");

            $table->foreign("userID")->references("id")->on("User")
                ->onUpdate("cascade")
                ->onDelete("restrict");

            $table->unique(["productID", "userID"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Cart');
    }
};
