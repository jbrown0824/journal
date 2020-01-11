@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ $user->name }} - {{ $date->format('l M jS, Y') }}</h1>
            <h2>Group - {{ $group->name }}</h2>
            <p>
                @if ($lastUpdated)<em>Last saved {{ \Carbon\Carbon::parse($lastUpdated)->format('h:iA') }}</em>@endif
            </p>

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ __('Your day has been saved') }}
                </div>
            @endif

            @if (!count($answers))
                <h4>{{ $user->name }} {{ $date->isToday() ? 'has not yet journaled' : 'did not journal' }}</h4>
            @else
                @foreach ($group->prompts as $prompt)
                    <h4>{{ $prompt->prompt }}</h4>
                    @if (isset($answers[ $prompt->id ][ 'answer' ]))
                        <p>{{ $answers[ $prompt->id ][ 'answer' ] }}</p>
                    @else
                        <p><em>None Given</em></p>
                    @endif
                @endforeach
            @endif

            <div class="btn-group">
                <a href="#" class="btn btn-primary">Download</a>
                <a href="#" class="btn btn-default">Mirror</a>
            </div>

            @if ($user->id === auth()->id() && $date->isToday())
            <a href="/day/{{ $date }}" class="btn btn-success btn-block btn-lg">Update</a>
            @endif
            <a href="/home" class="btn btn-success btn-block btn-lg">Home</a>
        </div>
    </div>
</div>
@endsection
