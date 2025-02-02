<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsByCommunityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_by_community', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('community_admin_id');
            $table->unsignedInteger('community_id');
        });

        Schema::table('admins_by_community', function (Blueprint $table) {
            $table->foreign('community_admin_id')->references('id')->on('community_admins');
            $table->foreign('community_id')->references('id')->on('communities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins_by_community');
    }
}
