<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;     //даем доступ к нашим моделям
use App\People;
use App\Page;
use App\Portfolio;


class IndexController extends Controller
{
    public function execute(Request $request)
    {  //передаем объект класса Request
        $pages = Page::all();  //выбрат все
        $portfolios = Portfolio::get(array('name', 'filter', 'images'));  //выбрать из указаных полей
        $services = Service::where('id', '<', 20)->get();  //выбрать по условию
        $peoples = People::take(3)->get();//выбрать только 3 записи
        $menu = array();
        foreach ($pages as $page) {
            $item = array('title' => $page->name, 'alias' => $page->alias);
            array_push($menu, $item);
        }
        $item = array('title' => 'Services', 'alias' => 'service');
        array_push($menu, $item);

        $item = array('title' => 'Portfolio', 'alias' => 'Portfolio');
        array_push($menu, $item);

        $item = array('title' => 'Team', 'alias' => 'team');
        array_push($menu, $item);

        $item = array('title' => 'Contact', 'alias' => 'contact');
        array_push($menu, $item);
        return view('site.index', array(  //передаем в шаблон переменные

            'menu' => $menu,
            'pages' => $pages,
            'services' => $services,
            'portfolios' => $portfolios,
            'peoples' => $peoples,


        ));
    }
}
