{{-- <div>
    <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
</div> --}}

@extends('layout.master')
@section('title', 'dashboard')
@section('nav-content')
<li class="nav-item">
    <a class="nav-link active" aria-current="page" href="{{route('login')}}">Login</a>
</li>
@endsection