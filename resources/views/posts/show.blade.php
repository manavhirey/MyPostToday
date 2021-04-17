@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-outline-secondary">Go Back</a>
    <h1>{{$post->title}}</h1>
    <hr>
    <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}">
    <br>
    <br>
    <div>
        {{$post->body}}
    </div>
    <hr>
    <small> <b>Created By {{$post->user->name}}</b> on {{$post->created_at}}</small>
    <hr>
    @if(!Auth::guest())
        @if(auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a>
            {!!Form::open(['action'=>['App\Http\Controllers\PostsController@destroy',$post->id],'method' => 'POST', 'class' => 'float-right']) !!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection