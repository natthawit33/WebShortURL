@extends('layout.app')

@section('content')
<div class="container">

    <div class="card" style="width: 35rem;margin:auto">
        <div class="card-header">
            <h2>Register</h2>
        </div>
    
    <div class="card-body">
        <form method="POST" action="{{ route('registers') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirm Password</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Register</button>
              </div>
           
        </form>
    </div>
</div>

</div>
@endsection
