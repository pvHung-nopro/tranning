<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySendMail extends Model
{
    use HasFactory;

    protected $table = 'history_send_mails';

    protected $fillable = [
        'user_id',
        'context_id',
        'status'
    ];
}
