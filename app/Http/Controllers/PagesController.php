<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use App\Page;*/


class PagesController extends Controller
{
    public function execute(){
        if(view()->exists('admin.pages')) {   //проверяем шаблон на существование

            $pages = \App\Page::all();   //выбираем все данные из таблицы

            $data = [                    //формируем массив с данными
                'title' => 'Страницы',
                'pages' => $pages
            ];

            return view('admin.pages',$data);    //передаем массив в шаблон

        }

        abort(404);
    }
}
