@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ
@endsection
@section('main')
    <div class="about-platform">
        <div class="image-section">
            <img src="{{ asset('images/banner2.jpg') }}" alt="banner" width="100%" height="690px">
        </div>
        <div class="container">
            <div class="intro-text">
                <h1>نسكـ القطاع غير الربحي</h1>
                <p>
                    هي أداتنا لتوثيق إسهامات القطاع غير الربحي في خدمة ضيوف الرحمن، ودور المؤسسة في النهوض بتلك الإسهامات.
                </p>
            </div>
            <div class="list-news">
                <div class="intro row">
                    @foreach($news as $item)
                        <div class="list-news-item my-3">
                            <div class="list-news-img">
                                <a href="{{ route('news.data', $item->id) }}">
                                    <img src="{{ asset($item->news_image) }}" class="img-fluid">
                                </a>
                            </div>
                            <div class="list-news-desc">
                                <a href="{{ route('news.data', $item->id) }}">
                                    <h5 style="text-align: center; color: #b49164">{{ $item->news_title }}</h5>
                                </a>
                                <p>{{ $item->short_description }}</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="text-center mt-5">
                        <a href="{{ route('news.archive') }}" class="btn btn-dark">المزيد من الاخبــــــار</a>
                    </div>
                    <div class="intro row">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
