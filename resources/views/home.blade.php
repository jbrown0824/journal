@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Welcome {{ auth()->user()->name }}</h1>

            <div class="card-deck">
                <div class="card">
                    <div class="card-header"> Core Desired Feelings</div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @forelse($feelings as $feeling)
                            <li>{{ $feeling->feeling }}</li>
                            @empty
                            <li><em>None Specified Yet!</em></li>
                            @endforelse
                            <li><i><a href="/day/{{ $today->toDateString() }}" class="small">Edit</a></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"> Consecutive Days</div>
                    <div class="card-body">
                        <h1 class="text-center">{{ auth()->user()->consecutive_days }}</h1>
                    </div>
                </div>
                </div>

            <br>

            <div class="card">
                <a href="/day/{{ $today->toDateString() }}" class="btn btn-success btn-block btn-lg">Today - {{ $today->format('l M jS') }} - Journal</a>
            </div>

            <br>

            <div class="card">
                <a href="/day/{{ $yesterday->toDateString() }}/review" class="btn btn-success btn-block btn-lg">Yesterday - {{ $yesterday->format('l M jS') }} - Review</a>
            </div>

            <br>

            <div class="card">
                <a href class="btn btn-success btn-block btn-lg">View Archive - for now csv dump</a>
            </div>

            <br>

            @foreach ($groups as $group)
            <h2>Group - {{ $group->name }}</h2>

            <div class="card testimonial-card">
                <!--Background color-->
                <div class="card-up indigo"></div>
                <!--Avatar-->
                <div class="avatar mx-auto white">
                    <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(10).jpg" class="rounded-circle img-fluid">
                </div>
                @foreach ($group->users as $groupUser)
                <div class="card-body">
                    <!--Name-->
                    <h4 class="font-weight-bold mb-4">{{ $groupUser->name }}</h4>
                    <hr>
                    <!--Stats-->
                    <p class="dark-grey-text mt-4">Consecutive Days: {{ $groupUser->consecutive_days }}</p>
                    @if ($groupUser->last_journaled_at)
                    <a href="/day/{{ $groupUser->last_journaled_at->toDateString() }}/review/{{ $group->id }}/{{ $groupUser->id }}" class="btn btn-success">View Last - {{ $groupUser->last_journaled_at->format('l M jS') }}</a>
                    @else
                    <p class="dark-gray-text mt-4"><em>Not Journaled Yet</em></p>
                    @endif
                </div>
                @endforeach
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
