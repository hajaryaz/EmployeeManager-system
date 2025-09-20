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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
           $table->unsignedBigInteger('employee_id')->nullable();
$table->unsignedBigInteger('processed_by')->nullable();

$table->foreign('employee_id')
      ->references('id')
      ->on('utilisateures')
      ->onDelete('set null');

$table->foreign('processed_by')
      ->references('id')
      ->on('utilisateures')
      ->onDelete('set null');
            $table->string('employee_name');
            $table->text('description')->nullable();
            $table->enum('status', [
                'pending', 
                'in_progress',
                'approved',
                'rejected',  
                'completed' 
            ])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('processed_at')->nullable();
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
        Schema::dropIfExists('documents');
    }
};
