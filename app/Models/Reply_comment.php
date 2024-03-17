<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply_comment extends Model
{
    use HasFactory;
    public $table = 'reply_comments';
    protected $fillable = ['content', 'comment_id'];

    public function comment(){
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}
