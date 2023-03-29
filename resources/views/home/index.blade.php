@extends('layouts.admin')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
        <h1>Tasks</h1>
        <p class="lead">Authenticated user.</p>
        {{-- <a class="btn btn-lg btn-primary" href="https://codeanddeploy.com" role="button">View more tutorials here &raquo;</a> --}}
        <div>
                @if (Cookie::has("name_user"))
                    your name is : {{ Cookie::get("name_user")}}
                @else
                    none
                @endif
        </div>
        <form action="saveCookie" method="post">
            @csrf
            <label for="">your name :</label>
            <input type="text" id="txt_Name" name="txt_Name">
            <button class=" btn btn-lg btn-primary" type="submit" >Save</button>
        </form><br><br><br>
        <form method="post" action="saveAvatar" enctype="multipart/form-data">
            @csrf
            <div>
                <input type="file" name="avatar" id="avatar"
                class="form-control"@error('avatar') is-invalid @enderror value="{{ old('avatar') }}" required autocomplete="avatar">
                <img src="/avatars/{{ Auth::user()-> avatar }}" style="width:100px"/>
                @error("avatar")
                    <span>
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
                <button>{{ __('Save') }}</button>
            </div>

        </form>
        @endauth

        @guest
        <h1>Welcome</h1>
        <p class="lead">Please login </p>
        @endguest
    </div>
@endsection
