<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumeStatusToContextSendMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('context_send_mails', 'status')) {
            Schema::table('context_send_mails', function (Blueprint $table) {
                $table->tinyInteger('status')->default(1)->comment('1:before_run 2:running 3:done 4:server_die');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('context_send_mails', 'status')) {
            Schema::table('context_send_mails', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
