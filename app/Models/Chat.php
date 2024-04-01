<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Mpociot\Firebase\SyncsWithFirebase;

class Chat extends Model
{
//    use HasFactory;

    protected $table = 'chats';
    protected $fillable = ['name', 'content', 'ip', 'type'];
}
