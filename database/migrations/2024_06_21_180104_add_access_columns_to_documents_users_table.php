<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccessColumnsToDocumentsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents_users', function (Blueprint $table) {
            $table->boolean('is_access_granted')->default(false)->after('document_id');
            $table->boolean('is_access_blocked')->default(false)->after('is_access_granted');
            $table->boolean('is_requested')->default(false)->after('is_access_blocked');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents_users', function (Blueprint $table) {
            $table->dropColumn('is_access_granted');
            $table->dropColumn('is_access_blocked');
            $table->dropColumn('is_requested');
        });
    }
}
