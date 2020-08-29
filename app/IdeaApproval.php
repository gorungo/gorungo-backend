<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdeaApproval extends Model
{
    protected $table = 'idea_approvals';
    protected $guarded = [];

    public function idea(){
        return $this->belongsTo('App\Idea');
    }

    public function moderator(){
        return $this->belongsTo('App\User', 'moderator_id');
    }

    public function approvalStatus(){
        return $this->belongsTo('App\ApprovalStatus');
    }

}
