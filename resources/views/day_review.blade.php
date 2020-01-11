@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ $date->format('l M jS, Y') }}</h1>
            @foreach ($group->prompts as $prompt)
                <h4>{{ $prompt->prompt }}</h4>
                @if (isset($answers[ $prompt->id ][ 'answer' ]))
                    <p>{{ $answers[ $prompt->id ][ 'answer' ] }}</p>
                @else
                    <p><em>None Given</em></p>
                @endif
            @endforeach

            <a href="/home" class="btn btn-success btn-block btn-lg">Back</a>
        </div>
    </div>
</div>
@endsection
