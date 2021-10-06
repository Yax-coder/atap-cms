@extends('_layouts.guest')

@section('content')
    <form class="form-login" method="POST" action="{{ url('login') }}">
        <h2 class="form-login-heading">LOGIN IN NOW</h2>
        <div class="login-wrap">
            {{ csrf_field() }}
            <input type="email" name="email" class="form-control" placeholder="Email" required>
            <br>
            <input type="password" name="password" class="form-control" placeholder="Password">
            <br>
            <button type="submit" class="btn btn-theme btn-block"><i class="fa fa-lock"></i> LOGIN</button>
            <hr>
            <p class="text-center">
                Don't have an account? <a href="{{ route('new_register') }}">Register</a>
            </p>

        </div>

    </form> 
@endsection
