@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (ارشيف الأخبار)
@endsection
@section('main')

    <div class="about-platform">
        <div class="container">
            <div class="list-news-archive">
                <div class="intro row mt-4">
                    @foreach($news as $item)
                        <div class="list-news-item my-3">
                            <div class="list-news-img">
                                <a href="{{ route('news.data', $item->id) }}">
                                    <img src="{{ asset($item->news_image) }}" class="img-fluid">
                                </a>
                            </div>
                            <div class="list-news-desc">
                                <a href="{{ route('news.data', $item->id) }}">
                                    <h5 style="text-align: center; color: #b49164; font-weight: 800">{{ $item->news_title }}</h5>
                                </a>
                                <p>{{ $item->short_description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>




@endsection
