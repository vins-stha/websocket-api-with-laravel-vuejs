@extends('layouts.app')
@section('content')
    <section class="navbar">
        <div class="nav-logo">
            RkPprCZor
        </div>
    </section>
    <div id="app">

        <div class="flex-center position-ref full-height">
            <div class="content">
                <section class="login">
                    <form action="/rps/login" method="post">
                        @csrf
                        <h1></h1>
                        <h2>Sign in </h2>
                        <input type="text" name="fullname" class="uname" placeholder="Enter your name" required/>

                        <button type="submit" class="btn btn-primary">Submit</button>

                    </form>
                </section>
            </div>
        </div>

@endsection
