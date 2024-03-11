@extends('layout')

@section('content')
    <div class="xform container-fluid mt-5">
        <form action="/users" method="POST">
            @csrf
            <h3 class="mb-3 w-75 border-bottom pb-3 text-danger">Register Admin</h3>
            <div class="form-group w-100">
                <input type="text" name="name" placeholder="Enter username" value="{{old('name')}}" id="name"/>
                @error('name')
                    <p class="text-danger w-100">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group w-100">
                <input type="email" name="email" placeholder="Enter email address" value="{{old('email')}}" id="email"/>
                @error('email')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group w-100">
                <input type="password" name="password" value="{{old('password')}}" placeholder="Enter password" id="password"/>
                @error('password')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group w-100">
                <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" placeholder="Confirm password" id="password_confirmation"/>
                @error('password')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <input type="submit" class="submit-create-user bg-danger text-white" name="submit-create-user">
        </form>
    </div>
@endsection