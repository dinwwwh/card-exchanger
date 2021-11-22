<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardTypesTable extends Migration
{
    public function up()
    {
        Schema::create('card_types', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('value');
            $table->string('telco');
            $table->unsignedInteger('fees')->min(0)->max(100)->default(0);
            $table->unsignedInteger('penalty')->min(0)->max(100)->default(0);

            # App\Traits\Callbackable
            $table->json('callback')->nullable();

            # App\Traits\Trackable
            $table->foreignId('creator_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->foreignId('updater_id')->nullable()->constrained('users', 'id')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('card_types');
    }
}
