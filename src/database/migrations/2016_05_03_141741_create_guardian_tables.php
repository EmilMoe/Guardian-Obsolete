<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use EmilMoe\Guardian\Support\Guardian;

class CreateGuardianTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('guardian.table.permission'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('table');
            $table->string('foreign_id_column');
            $table->string('user_id_column');
            $table->timestamps();
        });

        Schema::create(config('guardian.table.role'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('locked')->default(false);

            if (Guardian::hasClients())
                $table->integer(Guardian::getClientColumn())->unsigned();

            $table->timestamps();

            if (Guardian::hasClients())
                $table->foreign(Guardian::getClientColumn())
                    ->references(Guardian::getClientKey())
                    ->on(Guardian::getClientTable())
                    ->onDelete('cascade');
        });

        Schema::create(config('guardian.table.role') .'_'. config('guardian.table.permission'), function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->timestamps();
            $table->foreign('permission_id')->references('id')->on(config('guardian.table.permission'))->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on(config('guardian.table.role'))->onDelete('cascade');
        });

        Schema::create(Guardian::getUserTable() .'_'. config('guardian.table.role'), function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references(Guardian::getUserKey())->on(Guardian::getUserTable())->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on(config('guardian.table.role'))->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(config('guardian.table.permission') .'_'. config('guardian.table.role'));
        Schema::drop(config('guardian.table.role'));
        Schema::drop(config('guardian.table.permission'));
    }
}
