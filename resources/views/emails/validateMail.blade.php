<p>Hi <b>{{$data['name']}}</b></p>

<a class="btn btn-outline-success" href="{{route('v-email', ['key' => $data['key'], 'id' => $data['id']])}}">Please click for validate email</a>
