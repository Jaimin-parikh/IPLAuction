@extends('layout.master')
@section('title', 'login')
@section('nav-content')
    <li class="nav-item">Login Here!!
    </li>
@endsection
@section('form')
    <br><br>
    <form action="" style="padding-left:20px ">
        <x-input label="Email address:" type="email" placeholder="name@example.com" name="email" />
        <x-input label="Password:" type="password" placeholder="password" name="password" />
        <input type="submit" value="Login" class="btn btn-primary">
    </form>
@endsection
