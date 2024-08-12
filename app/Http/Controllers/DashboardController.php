<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function DashboardView()
    {
        $opportunities = Opportunity::all();
        return view('dashboard', compact('opportunities'));
    }

    public function index()
    {
        $new = News::where('status_id', 1)->first();
        $news = News::where('status_id', 1)->take(3)->get();
        return view('frontend.index', compact('new', 'news'));
    }

    public function NewsArchive()
    {
        $news = News::where('status_id', 1)->get();
        return view('frontend.news.archive', compact('news'));
    }

    public function NewsData($id)
    {
        $new = News::find($id);
        $news = News::WhereNotIn('id', [$id])->where('status_id', 1)->take(2)->get();
        return view('frontend.news.data', compact('news', 'new'));

    }

}
