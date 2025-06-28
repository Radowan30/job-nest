<?php
// database/migrations/2025_01_01_000001_create_applications_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // applicant
            $table->unsignedBigInteger('job_id');
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->unique(['user_id','job_id']); // one application per user/job
        });
    }
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
