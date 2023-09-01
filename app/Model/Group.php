<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
    public function getContactsCount()
    {
        return $this->contacts()->count();
    }
    public function getMessageSentCount()
    {
        return $this->contacts()->where("msg_sent",1)->count();
    }
    public function getMessageNotSentCount()
    {
        return $this->contacts()->where("msg_sent",0)->count();
    }
}
