<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVcard extends Model
{
    protected $table= 'vcard';
    public $timestamps=false;
    
    /**
     * Hasone Relation with user contact details
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    // public function userVcardDetail() {
    //     return $this->hasOne(Users::class,"username","username");
    // }
}
