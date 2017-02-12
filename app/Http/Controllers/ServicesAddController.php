<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Service;

class ServicesAddController extends Controller
{

    public function execute(Request $request){

        if ($request->isMethod('post')) {
            $input = $request->except('_token');   //записываем все,кроме  _token

            $massages = [
                'required' => 'Поле :attribute обязательно к заполнению',
            ];


            $validator = Validator::make($input, [    //формируем валидацию для полей

                'name' => 'required|max:255',
                'text' => 'required'

            ], $massages);

            if($validator->fails()) {    //проверка на валидацию
                return redirect()
                    ->route('servicesAdd')
                    ->withErrors($validator)
                    ->withInput();
            }

            $service = new Service();   //создаем пустой объект модели Service
            $service->fill($input);   //заполняем поля модели
            if($service->save()) {
                return redirect('admin')->with('status','Услуга добавлена');
            }

        }


        if (view()->exists('admin.services_add')) {
            $data = [
                'title' => 'Новый сервис'
            ];
            return view('admin.services_add', $data);
        }
        abort(404);
    }


}
