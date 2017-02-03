<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $table = 'peoples';  //переопределяем защищенное свойство,иначе ларавель не понимает,что peoples-это табличка
}
