<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;     //даем доступ к нашим моделям
use App\People;
use App\Page;
use App\Portfolio;
use DB;
use Mail;


class IndexController extends Controller
{
    public function execute(Request $request)
    {  //передаем объект класса Request
        if ($request->isMethod('post')) {

            $messages = [

                'required' => "Поле :attribute обязательно к заполнению",
                'email' => "Поле :attribute должно соответствовать email адресу"

            ];

            $this->validate($request, [

                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'

            ], $messages);


            $data = $request->all();

            $result = Mail::send('site.email', ['data' => $data], function ($message) use ($data) {

                $mail_admin = env('MAIL_ADMIN');

                $message->from($data['email'], $data['name']);
                $message->to($mail_admin, 'Mr. Admin')->subject('Question');


            });

            if ($result = TRUE) {
                return redirect()->route('home')->with('status', 'Email was sent');
            }
        }

        $pages = Page::all();  //выбрать все
        $portfolios = Portfolio::get(array('name', 'filter', 'images'));  //выбрать из указаных полей
        $services = Service::where('id', '<', 20)->get();  //выбрать по условию
        $peoples = People::take(3)->get();//выбрать только 3 записи
        $tags = DB::table('portfolios')->distinct()->pluck('filter')->toArray();  //вывести уникальную инфу из поля filter таблицы portfolios  в виде массива
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
            'tags' => $tags,
        ));
    }
}
