@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                    <br>
                    Your role: {{ $role[0] }}
                </div>
                @if ($role[0] == 'admin')
                    <div class="card-body">
                    <div class="row mb-3">
                        <form action="{{route('editCourse')}}" method="GET">
                            <button class="btn btn-primary" >Edit courses</button>
                        </form>
                    </div>  
                    <div class="row mb-3">
                        <form action="{{route('editRole')}}" method="GET">
                            <button class="btn btn-primary" >Edit roles</button>
                        </form>
                    </div>
                    </div>
                @elseif ($role[0] == 'student')
                    <div class="card-body">
                        <form action="{{route('courses.student')}}" method="GET">
                            <button class="btn btn-primary">View courses</button>
                        </form>
                    </div>
                @elseif ($role[0] == 'teacher')
                <div class="card-body">
                        <form action="{{route('courses.teacher')}}" method="GET">
                            <button class="btn btn-primary">View courses</button>
                        </form>     
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
