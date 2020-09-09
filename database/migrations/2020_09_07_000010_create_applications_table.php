<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->uniuque();
            $table->string('email');
            $table->string('token');
            $table->string('position_reference');
            $table->string('name')->nullable();
            $table->text('cover_letter')->nullable();
            $table->text('cv')->nullable();
            $table->text('cv_upload')->nullable();
            $table->text('code_example')->nullable();
            $table->datetime('confirmed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('applications');
    }
}
