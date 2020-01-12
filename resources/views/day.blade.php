@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ $date->format('l M jS, Y') }}</h1>
            <p>
            @if ($date->isToday())At midnight this day will lock down<br>@endif
            @if ($lastUpdated)<em>Last saved {{ \Carbon\Carbon::parse($lastUpdated)->format('h:iA') }}</em>@endif
            </p>

            <form action="/day/{{ $date->toDateString() }}" method="post">
                {{ csrf_field() }}

                @if (session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ session()->get('error') }}</strong>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Your day has been saved') }}
                    </div>
                @endif

                <h3>Core Desired Feelings</h3>

                @foreach ($feelings as $index => $feeling)
                    <div class="form-group">
                        <label>Feeling #{{ $index + 1 }}</label><br>
                        <input class="form-control" name="feelings[{{ $feeling->id }}]" value="{{ $feeling->feeling }}">
                    </div>
                @endforeach

                @for ($i = count($feelings); $i < 5; $i++)
                <div class="form-group">
                    <label>Feeling #{{ $i + 1 }}</label><br>
                    <input class="form-control" name="new_feelings[]">
                </div>
                @endfor

                <h3>Group Prompts</h3>

                @foreach ($group->prompts as $prompt)

                    <div class="form-group">
                        <label>{{ $prompt->prompt }}</label><br>
{{--                        <label>URL</label>--}}
{{--                        <input class="form-control form-control-sm" placeholder="Optional" name="url[{{ $prompt->id }}]"><br>--}}
                        <textarea class="form-control" rows="3" name="answer[{{ $prompt->id }}]">{{ $answers[ $prompt->id ]['answer'] ?? '' }}</textarea><br>
                    </div>

                @endforeach
{{--                <div class="form-group">--}}
{{--                    <label for="QuoteOfTheDay">Quote of the Day</label>--}}
{{--                    <textarea class="form-control" rows="3"></textarea>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="ListenOrRead">What did you listen to or read?</label>--}}
{{--                    <textarea class="form-control" rows="3"></textarea>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="ExcitedAboutToday">What are you excited about in the next 24 hours?</label>--}}
{{--                    <textarea class="form-control" rows="3"></textarea>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="Focus">What do you want to focus on in the next 24 hours?</label>--}}
{{--                    <textarea class="form-control" rows="3"></textarea>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="DailyLover">One thing that happened: Lover</label>--}}
{{--                    <textarea class="form-control" rows="3"></textarea>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="DailySelf">One thing that happened: Self</label>--}}
{{--                    <textarea class="form-control" rows="3"></textarea>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="DailyKid">One thing that happened: Kids</label>--}}
{{--                    <textarea class="form-control" rows="3"></textarea>--}}
{{--                </div>--}}
            <button type="submit" class="btn btn-success btn-block btn-lg">Save</button><br><br>
            </form>
            <a href="/home" class="btn btn-dark btn-block btn-lg">Back</a>
        </div>
    </div>
</div>
@endsection
