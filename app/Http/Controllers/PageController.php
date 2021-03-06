<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
    public function execute($alias)
    {
        if (!$alias) {   //если не был передан параметр
            abort(404);
        }
        if (view()->exists('site.page')) {
            // Where `alias` = $alias
            $page = Page::where('alias', strip_tags($alias))->first();
            $data = [
                'title' => $page->name,
                'page' => $page
            ];
            return view('site.page', $data);
        } else {
            abort(404);
        }

    }
}
