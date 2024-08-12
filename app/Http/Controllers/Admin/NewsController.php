<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{

    public function NewsView()
    {
        $opportunities = Opportunity::all();
        $news = News::orderBy('id', 'DESC')->get();
        return view('admin.news.news_view', compact('news', 'opportunities'));
    }

    public function NewsAdd()
    {
        $opportunities = Opportunity::all();
        return view('admin.news.news_add', compact('opportunities'));
    }

    public function NewsStore(Request $request)
    {
        $request->validate([
            'news_title' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'news_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'news_title.required' => 'ادخل العنوان من فضلك',
            'short_description.required' => 'ادخل المحتوى المختصر من فضلك',
            'long_description.required' => 'ادخل المحتوى الكامل من قضلك',
            'news_image.required' => 'Please upload image',
            'news_image.image' => 'The file must be an image',
            'news_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg',
            'news_image.max' => 'The image must not be greater than 2MB',
        ]);

        $file = $request->file('news_image');
        if ($file) {
            $filePath = $file->move("upload", $file->getClientOriginalName());
            if ($filePath) {
                News::insert([
                    'news_title' => $request->news_title,
                    'short_description' => $request->short_description,
                    'long_description' => $request->long_description,
                    'news_image' => $filePath,
                    'created_at' => now(),
                ]);

                Session()->flash('error', 'تم إضافة خبر بنجاح');
                return redirect()->route('news');
            } else {
                Session()->flash('error', 'للأسف لم يتم ');
                return redirect()->route('news');
            }
        } else {
            Session()->flash('error', 'Please upload a valid image');
            return redirect()->route('news');
        }


    }

    public function NewsHide($id)
    {
        DB::table('news')
            ->where('id', $id)
            ->update(['status_id' => 2]);

        Session()->flash('error', 'تم إخفاء الخبر');
        return redirect()->back();
    }


    public function NewsShow($id)
    {
        DB::table('news')
            ->where('id', $id)
            ->update(['status_id' => 1]);

        Session()->flash('error', 'تم إظهار الخبر');
        return redirect()->back();
    }

    public function NewsEdit($id)
    {
        $opportunities = Opportunity::all();
        $news = News::find($id);
        return view('admin.news.news_edit', compact('news', 'opportunities'));
    }

    public function NewsUpdate(Request $request, $id)
    {
        $request->validate([
            'news_title' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
        ],[
            'news_title.required' => 'ادخل العنوان من فضلك',
            'short_description.required' => 'ادخل المحتوى المختصر من فضلك',
            'long_description.required' => 'ادخل المحتوى الكامل من قضلك',
        ]);

        $file = $request->file('news_image');
        if ($file) {
            $filePath = $file->move("upload", $file->getClientOriginalName());
            if ($filePath) {
                News::findOrFail($id)->update([
                    'news_title' => $request->news_title,
                    'short_description' => $request->short_description,
                    'long_description' => $request->long_description,
                    'news_image' => $filePath,
                ]);

                Session()->flash('error', 'تم تعديل خبر بنجاح');
                return redirect()->route('news');
            } else {
                Session()->flash('error', 'للأسف لم يتم ');
                return redirect()->route('news');
            }
        } else {
            News::findOrFail($id)->update([
                'news_title' => $request->news_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'created_at' => now(),
            ]);
            Session()->flash('error', 'تم تعديل خبر بنجاح');
            return redirect()->route('news');
        }
    }

    public function NewsDelete($id)
    {
        News::destroy($id);
        Session()->flash('error', 'تم حذف الخبر');
        return redirect()->back();
    }




}
