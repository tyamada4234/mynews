@extends('layouts.profile')

@section('content')
    <div class="container">
        
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                @foreach($posts as $post)
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="date">
                                    {{ $post->updated_at->format('Y年m月d日') }}
                                </div>
                                <div class="name">
                                    {{ Str::limit($post->name, 150) }}
                                </div>
                                <div class="gender">
                                    {{ Str::limit($post->gender, 150) }}
                                </div>
                                <div class="hobby">
                                    {{ Str::limit($post->hobby, 150) }}
                                </div>
                                <div class="body mt-3">
                                    {{ Str::limit($post->introduction, 1500) }}
                                </div>
                            </div>   
                        </div>
                    </div>
                    <hr color="#c0c0c0">
                @endforeach
            </div>
        </div>
    </div>
@endsection