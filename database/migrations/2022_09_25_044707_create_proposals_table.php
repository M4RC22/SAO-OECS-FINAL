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
        Schema::create('proposals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->integer('duration_val');
            $table->string('duration_unit');
            $table->string('venue');
            $table->foreignUuid('organizer_organization_user_id')->references('id')->on('organization_user');
            // $table->string('organizer_name');
            $table->string('act_classification');
            $table->string('act_location');
            $table->string('description');
            $table->string('rationale');
            $table->string('outcome');
            $table->string('primary_audience');
            $table->integer('num_primary_audience');
            $table->string('secondary_audience');
            $table->integer('num_secondary_audience');
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
        Schema::dropIfExists('proposals');
    }
};
