<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Page;

class PagesAddController extends Controller
{
    public function execute(Request $request)
    {

        if ($request->isMethod('post')) {
            $input = $request->except('_token');   //записываем все,кроме  _token

            $massages = [

                'required' => 'Поле :attribute обязательно к заполнению',
                'unique' => 'Поле :attribute должно быть уникальным'

            ];


            $validator = Validator::make($input, [    //формируем валидацию для полей

                'name' => 'required|max:255',
                'alias' => 'required|unique:pages|max:255',
                'text' => 'required'

            ], $massages);

            if($validator->fails()) {    //проверка на валидацию
                return redirect()
                    ->route('pagesAdd')
                    ->withErrors($validator)
                    ->withInput();
            }

            //для загрузки файлов
            if($request->hasFile('images')) {
                $file = $request->file('images');

                $input['images'] = $file->getClientOriginalName();   //записываем оригинальное имя файла в ячейку массива

                $file->move(public_path().'/assets/img',$input['images']);  //копируем файл в указанную папку

            }

            $page = new Page();   //создаем пустой объект модели Page


            //$page->unguard();       //либо можем дать автоматический доступ ко всем поля

            $page->fill($input);   //заполняем поля модели

            if($page->save()) {
                return redirect('admin')->with('status','Страница добавлена');
            }


        }


        if (view()->exists('admin.pages_add')) {
            $data = [
                'title' => 'Новая страница'
            ];
            return view('admin.pages_add', $data);
        }
        abort(404);
    }
}
