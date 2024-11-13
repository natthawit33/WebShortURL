@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="card" style="max-width: 500px; margin: auto;">
        <div class="card-header text-center">
            <h2>Login</h2>
        </div>
        <div class="card-body">
         
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>

                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                </div>

               
                {{-- <div class="form-group text-center mt-3">
                    <a href="{{ route('password.request') }}">Forgot your password?</a> | <a href="{{ route('register') }}">Register</a>
                </div> --}}
            </form>
        </div>
    </div>
</div>

@endsection
