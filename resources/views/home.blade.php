@extends('layouts.default')
@section('header')
    <h1>this is a header</h1>
@endsection
@section('content')
    <h2>Home</h2>

    <form action ="{{ route('namesubmit') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type ="text" id="name" name="fullname" placeholder ="Enter your full name" required><br>
        <label for="email">Email:</lable>
        <input type="email" id="email" name="email" placeholder="Enter your email" required><Br>
        <button type="submit">Submit</button>
    </form>
@endsection
@section('footer')
    <h2>this is a footer</h2>
@endsection