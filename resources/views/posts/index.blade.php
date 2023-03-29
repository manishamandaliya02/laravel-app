@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>{{ __('Posts List') }}</b>
                </div>

                <div class="card-body">
                @if(Session::has("success"))
                            <div class="alert alert-success">
                                {{Session::get("success")}}
                            </div>
                        @elseif(Session::has("failed")) 
                        <div class="alert alert-danger">
                            {{Session::get("failed")}}
</div>
                        @endif
                    <table id="posts" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Date</th>                                
                                <th>Edit</th>
                                <th>Share</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{$post->id}}</td>
                               <td><img src="/images/{{$post->image}}" width="100" height="100"/></td>
                               <td>{{$post->name}}</td>
                                <td>{{$post->description}}</td>
                                <td>{{$post->date}}</td>
                               
                                <td>
                                @if(in_array($userId, json_decode($post->accessUser)) || $userId == $post->createBy)
                                    <a class="btn btn-primary btn-sm" href="{{ route('posts.edit',$post->id) }}">Edit</a> 
                                @endif
                                </td>
                                <td>
                                @if($userId == $post->createBy)
                                <form action="{{ route('posts.share') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" value="{{$post->id}}" name="postid"/>
                                        <select name="users[]" class="form-control" multiple="multiple">
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-primary btn-sm" type="submit">Shared</button>
                                </form>
                                @endif
                                </td>
                                
                            </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
