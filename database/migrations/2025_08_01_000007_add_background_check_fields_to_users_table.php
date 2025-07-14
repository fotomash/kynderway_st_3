<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'ssn')) {
                $table->string('ssn')->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'checkr_candidate_id')) {
                $table->string('checkr_candidate_id')->nullable()->after('ssn');
            }
            if (!Schema::hasColumn('users', 'background_check_report_id')) {
                $table->string('background_check_report_id')->nullable()->after('checkr_candidate_id');
            }
            if (!Schema::hasColumn('users', 'background_check_status')) {
                $table->string('background_check_status')->nullable()->after('background_check_report_id');
            }
            if (!Schema::hasColumn('users', 'background_check_initiated_at')) {
                $table->timestamp('background_check_initiated_at')->nullable()->after('background_check_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'background_check_initiated_at')) {
                $table->dropColumn('background_check_initiated_at');
            }
            if (Schema::hasColumn('users', 'background_check_status')) {
                $table->dropColumn('background_check_status');
            }
            if (Schema::hasColumn('users', 'background_check_report_id')) {
                $table->dropColumn('background_check_report_id');
            }
            if (Schema::hasColumn('users', 'checkr_candidate_id')) {
                $table->dropColumn('checkr_candidate_id');
            }
            if (Schema::hasColumn('users', 'ssn')) {
                $table->dropColumn('ssn');
            }
        });
    }
};
