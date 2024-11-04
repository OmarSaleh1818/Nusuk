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
        try {
            $news = News::orderBy('id', 'DESC')->get();
            if ($news->isNotEmpty()) {
                return response()->json([
                    'succeed' => true,
                    'message' => 'News view',
                    'data' => $news,
                ], 200);
            } else {
                return response()->json([
                    'succeed' => false,
                    'message' => 'No news found',
                    'data' => [],
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during NewsView',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function NewsAdd()
    {
        try {
            return response()->json([
                'message' => 'News add'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during NewsAdd',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }

    }

    public function NewsStore(Request $request)
    {
        try {
        // Validate the request
        $request->validate([
            'news_title' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'news_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ], [
            'news_title.required' => 'ادخل العنوان من فضلك',
            'short_description.required' => 'ادخل المحتوى المختصر من فضلك',
            'long_description.required' => 'ادخل المحتوى الكامل من فضلك',
            'news_image.required' => 'Please upload image',
            'news_image.image' => 'The file must be an image',
            'news_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg'
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
                    'succeed' => true,
                    'message' => 'News added successfully',
                    'data' => $news,
                ], 200);
            }
        } else {
            return response()->json([
                'succeed' => false,
                'message' => 'News not added'
            ], 401);
        }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during News',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function NewsHide($id)
    {
        try {
            $news = News::find($id);
            $news->status_id = 2;
            if ($news) {
                $news->save();
                return response()->json([
                    'succeed' => true,
                    'message' => 'News hidden successfully',
                    'data' => $news,
                ], 200);
            } else {
                return response()->json([
                    'succeed' => false,
                    'message' => 'News not found',
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during NewsHide',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function NewsShow($id)
    {
        try {
            $news = News::find($id);
            if ($news) {
                $news->status_id = 1;
                $news->save();
                return response()->json([
                    'succeed' => true,
                    'message' => 'News hidden successfully',
                    'data' => $news,
                ], 200);
            } else {
                return response()->json([
                    'succeed' => false,
                    'message' => 'News not found',
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during NewsShow',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function NewsEdit($id)
    {
        try {
            $news = News::find($id);
            if ($news) {
                return response()->json([
                    'succeed' => true,
                    'message' => 'News found successfully',
                    'data' => $news,
                ], 200);
            } else {
                return response()->json([
                    'succeed' => false,
                    'message' => 'News not found',
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during NewsEdit',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function NewsUpdate(Request $request, $id)
    {
        try {
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
                        'succeed' => true,
                        'message' => 'News updated successfully',
                        'data' => $news,
                    ], 200);
                }
            } else {
                $news = News::find($id);
                $news->news_title = $request->news_title;
                $news->short_description = $request->short_description;
                $news->long_description = $request->long_description;
                $news->save();
                return response()->json([
                    'succeed' => true,
                    'message' => 'News updated successfully',
                    'news' => $news,
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during registration',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function NewsDelete($id)
    {
        try {

            $news = News::find($id);
            if ($news) {
                $news->delete();
                return response()->json([
                    'succeed' => true,
                    'message' => 'News deleted successfully'
                ], 200);
            } else {
                return response()->json([
                    'succeed' => false,
                    'message' => 'News not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during registration',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }




}
