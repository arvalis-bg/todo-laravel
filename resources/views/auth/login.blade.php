@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">

        <h3 class="mb-3">Login</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                Invalid credentials
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Login</button>
        </form>

    </div>
</div>
@endsection
