@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="jumbotron text-center">
        <h1 class="display-4">Outlook Productivity</h1>
        <p class="lead"> Visualize and analyze your organizational performance through Outlook emails and meetings.</p>
        {{-- Flash messages --}}
        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif

        {{-- User is signed in --}}
        @if(session('userName'))
            <h4 class="mt-4">Welcome, {{ session('userName') }}!</h4>
            <p>Your email is: {{ session('userEmail') }}</p>

            <div class="mt-4">
                <a href="/emails" class="btn btn-primary m-2">View Emails</a>
                <a href="/calendar" class="btn btn-primary m-2">View Calendar Events</a>
                <a href="/dashboard" class="btn btn-success m-2">View Productivity Dashboard</a>
                <form method="POST" action="/signout" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger m-2">Sign Out</button>
                </form>
            </div>

        {{-- User not signed in --}}
        @else
            <a href="/signin" class="btn btn-primary btn-lg mt-4">Click here to sign in with Outlook</a>
        @endif
    </div>
</div>
@endsection
