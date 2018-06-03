<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function typeToStr(){
        return $this->hasOne('App\AccountType','id', 'account_type_id');
    }

    public function isDeleted()
    {
    	if ($this->deleted_at == null) {
    		return false;
    	}
    	return true;
    }
}
