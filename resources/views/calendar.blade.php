@extends('layout')

@section('content')
    <h2>Calendar Events</h2>
    @if($events->isEmpty())
        <p>No events found.</p>
    @else
        <ul>
            @foreach($events as $event)
                <li>{{ $event->getSubject() }} on {{ $event->getStart()->format('Y-m-d H:i') }}</li>
            @endforeach
        </ul>
    @endif
@endsection
