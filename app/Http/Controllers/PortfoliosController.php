<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portfolio;

class PortfoliosController extends Controller
{
        public function execute(){
            if (view()->exists('admin.portfolios')){
                $portfolio = Portfolio::all();
                $data = [
                    'title'=>'Страницы',
                    'portfolios'=>$portfolio
                ];

                return view('admin.portfolios',$data);
            }else{
                abort(404);
            }
        }
}
