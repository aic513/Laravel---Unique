<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends Controller
{
        public function execute(){
            if (view()->exists('admin.services')){
                $services = Service::all();
                $data = [
                    'title'=>'Услуги',
                    'services'=>$services
                ];

                return view('admin.services',$data);
            }else{
                abort(404);
            }
        }
}
