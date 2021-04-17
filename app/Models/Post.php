<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //Table Name
    protected $table = 'posts';

    //Primary Key can be changed here
    public $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;

    //Post -> User Relation
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
