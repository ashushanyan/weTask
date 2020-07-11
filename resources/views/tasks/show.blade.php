@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <form role="form" method="POST" class="mb-2" style="width: 81%" action="{{route('addArchive') }}">
            @csrf
            @if($task->status)
                <input type="hidden" name="status" value="0">
                <button type="submit" name="task_id" value="{{$task->id}}"
                        class=" btn btn float-right btn-warning ml-4 mt-2">Send to archive
                </button>
            @else
                <input type="hidden" name="status" value="1">
                <button type="submit" name="task_id" value="{{$task->id}}"
                        class=" btn btn float-right btn-success ml-4 mt-2">Send back from archive
                </button>
            @endif
        </form>
        <div class="col-md-10">
            <div class="card">
                <div class="card-group">
                    <h2 class="ml-4 mt-2 mb-0" style="width: 60%;">{{$task['title']}}</h2>
                </div>
                <div class="card-body">
                    @foreach($errors->all() as $error)
                        <p class="alert alert-danger" style="color: red">* {{$error}}</p>
                    @endforeach
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="card">
                        <form role="form" method="POST" action="{{route('task.update', $task->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="card-header ">Add Task</div>
                            <div class="card-body" style="overflow: hidden">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Title</span>
                                    </div>
                                    <input type="text" name="title" value="{{$task->title}}" class="form-control"
                                           placeholder="Username"
                                           aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Card</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01" name="card_id">
                                        @foreach($cards as $card)
                                            <option
                                                value="{{$card->id}}" {{$card->id == $task->card_id ? 'selected' : ''}}>
                                                {{$card->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Description</span>
                                    </div>
                                    <textarea class="form-control" name="description" aria-label="description">{{$task->description}}
                                    </textarea>
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Assigned to</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01" name="assigned_to">
                                        <option
                                            value="{{$cardCreator['id']}}" {{$assignedBy->id == $task->assigned_to ? 'selected' : ''}}>
                                            {{$cardCreator->name}}
                                        </option>
                                        @foreach($cardMembers as $member)
                                            <option
                                                value="{{$member->id}}" {{$member->id == $task->assigned_to ? 'selected' : ''}}>
                                                {{$member->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn  float-right btn-info">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
