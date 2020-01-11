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
                            <li>CDF #1</li>
                            <li>CDF #2</li>
                            <li>CDF #3 - max of 5</li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"> Consecutive Days</div>
                    <div class="card-body">
                        <h1 class="text-center">5</h1>
                    </div>
                </div>
                </div>

            <br>

            <div class="card">
                <a href="/day/{{ $today->format('Y-m-d') }}" class="btn btn-success btn-block btn-lg">Today - {{ $today->format('l M jS') }} - Journal</a>
            </div>

            <br>

            <div class="card">
                <a href="/day/{{ $yesterday->format('Y-m-d') }}/review" class="btn btn-success btn-block btn-lg">Yesterday - {{ $yesterday->format('l M jS') }} - Review</a>
            </div>

            <br>

            <div class="card">
                <a href class="btn btn-success btn-block btn-lg">View Archive - for now csv dump</a>
            </div>

            <br>

            <h2>Group - Career Moms</h2>

            <div class="card testimonial-card">
                <!--Background color-->
                <div class="card-up indigo"></div>
                <!--Avatar-->
                <div class="avatar mx-auto white">
                    <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(10).jpg" class="rounded-circle img-fluid">
                </div>
                <div class="card-body">
                    <!--Name-->
                    <h4 class="font-weight-bold mb-4">Alexis</h4>
                    <hr>
                    <!--Stats-->
                    <p class="dark-grey-text mt-4">Consecutive Days: 5</p>
                    <a href class="btn btn-success">View Yesterday</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
