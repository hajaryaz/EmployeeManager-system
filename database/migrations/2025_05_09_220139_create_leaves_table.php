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
        Schema::create('leaves', function (Blueprint $table) {
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
            $table->string('leave_reason');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('processed_at')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('rejected_reason')->nullable();
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
        Schema::dropIfExists('leaves');
    }
};
