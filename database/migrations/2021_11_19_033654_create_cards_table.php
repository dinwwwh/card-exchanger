<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('serial');
            $table->string('code');

            # CardType relationship
            $table->foreignId('type_id')->constrained('card_types', 'id')->onDelete('cascade');

            # Wallet relationship
            $table->foreignId('wallet_id')->constrained('wallets', 'id')->onDelete('cascade');
            $table->timestamp('paid_at')->nullable();

            # Approvement
            $table->foreignId('approver_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('received_value')->nullable();

            # App\Traits\Trackable
            $table->foreignId('creator_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->foreignId('updater_id')->nullable()->constrained('users', 'id')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
