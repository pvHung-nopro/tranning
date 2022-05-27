<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContextSendMail extends Model
{
    use HasFactory;

    protected $table = 'context_send_mails';

    protected $fillable = [
        'context',
        'status'
    ];
}
