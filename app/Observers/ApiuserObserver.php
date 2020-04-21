<?php
namespace App\Observers;
use App\Models\Apiuser;

class ApiuserObserver{
    //在添加前会执行此回调：
    public function creating(Apiuser $apiuser){
        $apiuser->password=bcrypt($apiuser->password);
    }
}

