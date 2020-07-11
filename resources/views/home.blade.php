@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-group mb-2"><h2 class="ml-4 mt-2 mb-0">{{$user->name}}</h2></div>
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="card">
                <form role="form" method="POST" action="{{ route('board.store') }}">
                    @csrf
                    <div class="card-header ">Create Board</div>
                    <div class="card-body">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Title</span>
                            </div>
                            <input type="text" name="title" placeholder="Title" class="form-control">
                            <button type="submit" class="btn btn-sm btn-success ml-1">Create</button>
                        </div>
                        @foreach($errors->all() as $error)
                            <p class="alert alert-danger" style="color: red">* {{$error}}</p>
                        @endforeach
                    </div>

                </form>
            </div>
            <div class="card mt-2">
                <div class="card-header">My boards</div>

                <div class="list-group">
                    @foreach($myBoards as $board)
                        <div style="overflow: hidden">
                            <div class="float-left" style="width: 96%">
                                <a href="{{route('board.show', $board['id'])}}"
                                   class="list-group-item list-group-item-action float-left">
                                    {{$board['title']}}
                                    <small class="float-right">created by` {{$board['created_by']}} </small>
                                </a>
                            </div>
                            <div class="float-right m-1 mt-2">
                                <form method="post"
                                      action="{{route('board.destroy', $board['id'])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>


                            </div>
                        </div>

                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
