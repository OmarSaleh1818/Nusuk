<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Opportunity;
use Carbon\Carbon;

class NewsController extends Controller
{
    
    public function NewsView()
    {
        $opportunities = Opportunity::all();
        $news = News::orderBy('id', 'DESC')->get();
        return response()->json([
            'news' => $news,
            'opportunities' => $opportunities,
            'message' => 'News view'
        ], 200);
    }

    public function NewsAdd()
    {
        $opportunities = Opportunity::all();
        return response()->json([
            'opportunities' => $opportunities,
            'message' => 'News add'
        ], 200);
    }

    public function NewsStore(Request $request)
    {
        // Validate the request
        $request->validate([
            'news_title' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'news_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'news_title.required' => 'ادخل العنوان من فضلك',
            'short_description.required' => 'ادخل المحتوى المختصر من فضلك',
            'long_description.required' => 'ادخل المحتوى الكامل من فضلك',
            'news_image.required' => 'Please upload image',
            'news_image.image' => 'The file must be an image',
            'news_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg',
            'news_image.max' => 'The image must not be greater than 2MB',
        ]);

        $file = $request->file('news_image');
        if ($file) {
            $filePath = $file->move("upload", $file->getClientOriginalName());
            if ($filePath) {
                $news = News::insert([
                    'news_title' => $request->news_title,
                    'short_description' => $request->short_description,
                    'long_description' => $request->long_description,
                    'news_image' => $filePath,
                    'created_at' => Carbon::now('Asia/Riyadh'),
                ]);
                return response()->json([
                    'news' => $news,
                    'message' => 'News added successfully'
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'News not added'
            ], 401);
        } 
    }

    public function NewsHide($id)
    {
        $news = News::find($id);
        $news->status_id = 2;
        $news->save();
        return response()->json([
            'news' => $news,
            'message' => 'News hidden successfully'
        ], 200);
    }

    public function NewsShow($id)
    {
        $news = News::find($id);
        $news->status_id = 1;
        $news->save();
        return response()->json([
            'news' => $news,
            'message' => 'News shown successfully'
        ], 200);
    }

    public function NewsEdit($id)
    {
        $news = News::find($id);
        $opportunities = Opportunity::all();
        return response()->json([
            'news' => $news,
            'opportunities' => $opportunities,
            'message' => 'News edited successfully'
        ], 200);
    }
    
    public function NewsUpdate(Request $request, $id)
    {
        $file = $request->file('news_image');
        if ($file) {
            $filePath = $file->move("upload", $file->getClientOriginalName());
            if ($filePath) {
                $news = News::find($id);
                $news->news_title = $request->news_title;
                $news->short_description = $request->short_description;
                $news->long_description = $request->long_description;
                $news->news_image = $filePath;
                $news->save();
                return response()->json([
                    'news' => $news,
                    'message' => 'News updated successfully'
                ], 200);
            }
        } else {
            $news = News::find($id);
            $news->news_title = $request->news_title;
            $news->short_description = $request->short_description;
            $news->long_description = $request->long_description;
            $news->save();
            return response()->json([
                'news' => $news,
                'message' => 'News updated successfully'
            ], 200);
        }
    }

    public function NewsDelete($id)
    {
        $news = News::find($id);
        $news->delete();
        return response()->json([
            'message' => 'News deleted successfully'
        ], 200);
    }
            



}
