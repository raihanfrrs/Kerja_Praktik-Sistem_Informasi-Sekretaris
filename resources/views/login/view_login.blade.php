@extends('layouts.main')

@section('section')
@include('partials.logo')

<div class="card mb-3">

  <div class="card-body">

    <div class="pt-4 pb-2">
      @include('partials.flash')
      <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
      <p class="text-center small">Enter your username & password to login</p>
    </div>

    <form class="row g-3 needs-validation" action="{{ url('login/proses') }}" method="post">
      @csrf
      <div class="col-12">
        <label for="yourUsername" class="form-label">Username</label>
        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="yourUsername">
        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="col-12">
        <label for="yourPassword" class="form-label">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="yourPassword">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="col-12">
        <button class="btn btn-primary w-100" type="submit">Login</button>
      </div>
      <div class="col-12">
        <p class="small mb-0">Don't have account? <a href="register">Create an account</a></p>
      </div>
    </form>

  </div>
</div>
@endsection