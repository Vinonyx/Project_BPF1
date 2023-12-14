@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-9 mt-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                </div>
                                @if (Session::has('logout'))
                                    <div class="alert alert-success">
                                        {{ Session::get('logout') }}
                                    </div>
                                    <?php Session::forget('logout'); ?>
                                @endif
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="exampleInputEmail" aria-describedby="emailHelp" name="email"
                                            placeholder="Enter Email Address..." value="{{ old('email') }}">
                                        <label for="exampleInputEmail">Email address</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="exampleInputPassword" name="password" placeholder="Password">
                                        <label for="exampleInputPassword">Password</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit">
                                        {{ __('Login') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
