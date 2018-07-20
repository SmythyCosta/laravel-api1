<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Setting extends Model
{
    //
    protected $table = "settings";

    public function settingData()
    {
        $find = Setting::select('company_name','address','phone','email','vat_percentage','currency')->where('id',1)->first();
        return $find;
    }

}
