<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Portfolio;


class PortfoliosAddController extends Controller
{
    public function execute(Request $request)
    {

        if($request->isMethod('post')) {
            $input = $request->except('_token');

            $massages = [

                'required' => 'Поле :attribute обязательно к заполнению',
                'unique' => 'Поле :attribute должно быть уникальным'

            ];

            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'filter' => 'required|unique:portfolios|max:255'
            ],$massages);

            if ($validator->fails()) {

                return redirect()->route('portfoliosAdd')
                    ->withErrors($validator)
                    ->withInput();
            }

            $file = $request->file('images');
            $request->file('images')->move(public_path().'/assets/img',$file->getClientOriginalName());

            $input['images'] = $file->getClientOriginalName();


            $porfolio = new Portfolio();
            $porfolio->fill($input);
            if($porfolio->save()) {
                return redirect('admin')->with('status', 'Страница добавлена');
            }
        }

        if(view()->exists('admin.portfolios_add')) {

            $data = [

                'title' => 'Новая страница'

            ];
            return view('admin.portfolios_add',$data);
        }

    }
}
