<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Department extends Model
{
    use NodeTrait;
    protected $guarded = [];
    public $fillable = ['title','parent_id'];

     /**
     * Get the index name for the model.
     *
     * @return string
    */
    public function childs() {
        return $this->hasMany('App\Department','parent_id','id') ;
    }

    public function users(){
        return $this->hasMany('App\User');
    }
}
