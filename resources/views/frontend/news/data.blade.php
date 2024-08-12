@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (الخبر)
@endsection
@section('main')
    <div class="show-new">
        <div class="container">

            <row class="news row mt-4">

                <div class="col-md-10">
                    <div class="row main-show">
                        <div class="col-md-12">
                            <div class="list-news-img">
                                <img src="{{ asset($new->news_image) }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="list-news-desc my-3">
                                <h5 style="text-align: center; color: #b49164; font-weight: 800">
                                    {{ $new->news_title }}
                                </h5>
                                <p>
                                    {{ $new->long_description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($news as $item)
                    <div class="col-md-6">
                        <div class="row list-show">
                            <div class="col-md-5">
                                <div class="list-news-img">
                                    <a href="{{ route('news.data', $item->id) }}">
                                        <img src="{{ asset($item->news_image) }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="list-news-desc my-3">
                                    <a href="{{ route('news.data', $item->id) }}">
                                        <h5 style="color: #b49164; font-weight: 800">
                                            {{ $item->news_title }}
                                        </h5>
                                    </a>
                                    <p>
                                        {{ $item->short_description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </row>
        </div>
    </div>


@endsection
