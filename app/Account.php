<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'owner_id','account_type_id', 'code','date','start_balance','current_balance','description'
    ];

    public $timestamps = false;

    public function type(){
        return $this->hasOne('App\AccountType','id', 'account_type_id');
    }

    public function isDeleted()
    {
    	if ($this->deleted_at == null) {
    		return false;
    	}
    	return true;
    }

    public function canDelete()
    {
        if (count($this->movements()->get()) == 0 && $this->last_movement_date == null) {
            return true;
        }
        return false;
    }

    public function movements()
    {
        return $this->hasMany('App\Movement');
    }
}
