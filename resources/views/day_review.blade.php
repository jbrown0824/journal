@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ $user->name }} - {{ $date->format('l M jS, Y') }}</h1>
            <h2>Group - {{ $group->name }}</h2>

            <div class="row mb-3 mt-3">
                <div class="col-6">
                    <a href="/day/{{ $previous->toDateString() }}/review/{{ $group->id }}/{{ $user->id }}" class="btn btn-info text-left">&lt; {{ $previous->format('M jS, Y') }}</a>
                </div>
                @if (!$date->isToday() && !$date->isFuture())
                    <div class="col-6 text-right">
                        <a href="/day/{{ $next->toDateString() }}/review/{{ $group->id }}/{{ $user->id }}" class="btn btn-info">{{ $next->format('M jS, Y') }} &gt;</a>
                    </div>
                @endif
            </div>

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ __('Your day has been saved') }}
                </div>
            @endif

            <h3>Core Desired Feelings</h3>

            @forelse ($feelings as $index => $feeling)
                <div class="card">
                    <div class="card-header">
                        Desired since {{ \Carbon\Carbon::parse($feeling->start_date)->format('M jS, Y') }}
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $feeling->feeling }}</p>
                    </div>
                </div>
            @empty
            <h4>No Desired Feelings On This Day</h4>
            @endforelse
            <br>

            <h3>Group Prompts</h3>
            <p>
                @if ($lastUpdated)<em>Last saved {{ \Carbon\Carbon::parse($lastUpdated)->format('h:iA') }}</em>@endif
            </p>

            @if (!count($answers))
                <h4>{{ $user->name }} {{ $date->isToday() ? 'has not yet journaled' : 'did not journal' }}</h4>
            @else
                @foreach ($group->prompts as $prompt)
                    <h4>{{ $prompt->prompt }}</h4>
                    @if (isset($answers[ $prompt->id ][ 'answer' ]))
                    <p>{!! nl2br($answers[ $prompt->id ][ 'answer' ]) !!}</p>
                    @else
                    <p><em>None Given</em></p>
                    @endif
                @endforeach
            @endif

            @if ($user->id === auth()->id() && $date->isToday())
            <a href="/day/{{ $date->toDateString() }}" class="btn btn-success btn-block btn-lg">Update</a>
            @endif
            <a href="/home" class="btn btn-success btn-block btn-lg">Home</a>
        </div>
    </div>
</div>
@endsection
