<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalStatus extends Model
{
    protected $table = 'approval_status';
    protected $guarded = [];

    public function idea(){
        return $this->hasMany('App\Idea');
    }

}
