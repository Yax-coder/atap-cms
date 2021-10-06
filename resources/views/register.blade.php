@extends('_layouts.guest')

@section('content')
    <form class="form-login" method="POST" action="{{ route('post_register') }}" style="margin-top:20px;">
        <h2 class="form-login-heading">Register now</h2>
        <div class="login-wrap">
            {{ csrf_field() }}
            <input type="text" name="matric_no" id="matric_no" class="form-control" placeholder="Matric No" value="{{ old('matric_no') }}" required>
            <br>
            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') }}" required>
            <br>
            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}" required>
            <br>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
            <br>
            <select name="department" id="department" class="form-control" value="{{ old('department') }}" required>
                <option value="">Choose Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
                
            </select>
            <br>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            <br>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
            <br>
            <button type="submit" class="btn btn-theme btn-block"><i class="fa fa-lock"></i> REGISTER</button>
            <hr>
            <p class="text-center">
                Alredy have an account? <a href="{{ route('login') }}">Login</a>
            </p>

        </div>

    </form> 
@endsection
