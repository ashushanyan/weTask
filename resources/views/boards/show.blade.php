@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <form role="form" method="POST" action="{{route('board.update', $board['id'])}}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @foreach($errors->all() as $error)
                            <p class="alert alert-danger" style="color: red">* {{$error}}</p>
                        @endforeach
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Board Title</span>
                            </div>
                            <input type="text" name="title" value="{{$board['title']}}" class="form-control">
                            <button type="submit" class="btn btn-lg btn-info ml-1">Edit</button>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <div class="card">
                        <form role="form" method="POST" action="{{ route('addMember') }}">
                            @csrf
                            <div class="card-header ">Add member</div>
                            <div class="card-body">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Email</span>
                                    </div>
                                    <input type="hidden" name="board_id" value="{{$board['id']}}">
                                    <input type="email" name="email" placeholder="Email" class="form-control">
                                    <button type="submit" class="btn btn-sm btn-success ml-1">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card mt-2">
                        <form role="form" method="POST" action="{{ route('card.store') }}">
                            @csrf
                            <div class="card-header ">Create another Card</div>
                            <div class="card-body">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Title</span>
                                    </div>
                                    <input type="hidden" name="board_id" value="{{$board['id']}}">
                                    <input type="text" name="title" placeholder="Title" class="form-control">
                                    <button type="submit" class="btn btn-sm btn-success ml-1">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card mt-2">
                        <div class="card-header ">Cards</div>
                        <div class="list-group">
                            @foreach($board['cards'] as $card)
                                <div style="overflow: hidden">
                                    <div class="float-left" style="width: 95%">
                                        <a href="{{route('card.show', $card['id'])}}"
                                           class="list-group-item list-group-item-action float-left">
                                            {{$card['title']}}
                                        </a>
                                    </div>
                                    <div class="float-right mr-2 mt-2">
                                        <form method="post"
                                              action="{{route('card.destroy', $card['id'])}}">
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
        </div>
    </div>
    </div>
    </div>
@endsection
