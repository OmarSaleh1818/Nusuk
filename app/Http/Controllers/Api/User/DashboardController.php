<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opportunity;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\OpportunityData;

class DashboardController extends Controller
{

    public function DashboardView()
    {
        $opportunities = Opportunity::all();
        $opportunityData = [];

        foreach ($opportunities as $opportunity) {
            $opportunityData[] = [
                'opportunity_id' => $opportunity->id,
                'opportunity_name' => $opportunity->opportunity_name,
                'opportunity_data_count' => OpportunityData::where('opportunity_id', $opportunity->id)->count(),
            ];
        }
        $user = Auth::user();
        return response()->json([
            'opportunities' => $opportunities,
            'opportunity_data' => $opportunityData,
            'user' => $user,
            'message' => 'Dashboard View',
            'status' => 200,
        ]);
    }

    public function index()
    {
        $news = News::where('status_id', 1)
            ->orderBy('id', 'desc') 
            ->take(3)
            ->get();
        if($news->isEmpty()){
            return response()->json([
                'message' => 'No news found',
                'status' => 404,
            ]);
        }
        return response()->json([
            'news' => $news,
            'message' => 'display the last three news',
            'status' => 200,
        ]);
    }

    public function NewsArchive()
    {
        $news = News::where('status_id', 1)->get();
        if($news->isEmpty()){
            return response()->json([
                'message' => 'No news found',
                'status' => 404,
            ]);
        }
        return response()->json([
            'news' => $news,
            'message' => 'display all news',
            'status' => 200,
        ]);
    }

    public function NewsData($id)
    {
        $new = News::find($id);
        $news = News::WhereNotIn('id', [$id])->where('status_id', 1)->take(2)->get();
        if($news->isEmpty()){
            return response()->json([
                'message' => 'No news found',
                'status' => 404,
            ]);
        }
        return response()->json([
            'new' => $new,
            'news' => $news,
            'message' => 'display the news data',
            'status' => 200,
        ]);
    }
    
    


}
