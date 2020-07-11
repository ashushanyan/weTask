@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <form role="form" method="POST" action="{{route('card.update', $card['id'])}}">
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
                                <span class="input-group-text" id="inputGroup-sizing-sm">Card Title</span>
                            </div>
                            <input type="text" name="title" value="{{$card['title']}}" class="form-control">
                            <button type="submit" class="btn btn-lg btn-info ml-1">edit</button>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <div class="card">
                        <form role="form" method="POST" action="{{ route('task.store') }}">
                            @csrf
                            <div class="card-header ">Add Task</div>
                            <div class="card-body" style="overflow: hidden">
                                <input type="hidden" name="card_id" value="{{$card['id']}}">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">title</span>
                                    </div>
                                    <input type="text" name="title" class="form-control" placeholder="title"
                                           aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">description</span>
                                    </div>
                                    <textarea class="form-control" name="description"
                                              aria-label="description"></textarea>
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">assigned to</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01" name="assigned_to">
                                        <option value="{{$creator['id']}}">{{$creator['name']}}</option>
                                        @foreach($members as $member)
                                            <option value="{{$member['id']}}">{{$member['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn  float-right btn-success">create</button>
                            </div>
                        </form>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header ">My Tasks</div>
                        <div class="list-group">
                            @foreach($myTasks as $task)
                                <div style="overflow: hidden">
                                    <div class="float-left" style="width: 95%">
                                        <a href="{{route('task.show', $task->id)}}"
                                           class="list-group-item list-group-item-action float-left">
                                            {{$task->title}}
                                        </a>
                                    </div>
                                    <div class="float-right mr-2 mt-2">
                                        <form method="post"
                                              action="{{route('task.destroy', $task->id)}}">
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

                    <div class="card mt-2">
                        <div class="card-header ">Tasks</div>
                        <div class="list-group">
                            @foreach($activeTasks as $task)
                                <div style="overflow: hidden">
                                    <div class="float-left" style="width: 95%">
                                        <a href="{{route('task.show', $task->id)}}"
                                           class="list-group-item list-group-item-action float-left">
                                            {{$task->title}}
                                        </a>
                                    </div>
                                    <div class="float-right mr-2 mt-2">
                                        <form method="post"
                                              action="{{route('task.destroy', $task->id)}}">
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
                    <div class="card mt-2">
                        <div class="card-header ">Archive Tasks</div>
                        <div class="list-group">
                            @foreach($archiveTasks as $task)
                                <div style="overflow: hidden">
                                    <div class="float-left" style="width: 95%">
                                        <a href="{{route('task.show', $task->id)}}"
                                           class="list-group-item list-group-item-action float-left">
                                            {{$task->title}}
                                        </a>
                                    </div>
                                    <div class="float-right mr-2 mt-2">
                                        <form method="post"
                                              action="{{route('task.destroy', $task->id)}}">
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
@endsection
