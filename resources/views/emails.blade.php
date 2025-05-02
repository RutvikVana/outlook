@extends('layout')

@section('content')
    <h2>Emails</h2>
    @if($emails->isEmpty())
        <p>No emails found.</p>
    @else
        <ul>
            @foreach($emails as $email)
                <li>{{ $email->getSubject() }} - {{ $email->getSender()->getEmailAddress()->getAddress() }}</li>
            @endforeach
        </ul>
    @endif
@endsection
