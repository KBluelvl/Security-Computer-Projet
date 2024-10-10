@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Course overview') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('courses.teacher.action') }}">
                        @csrf
                            <div class="row mb-3">
                                <select id="course" name="course">
                                    @foreach ($courses as $course)
                                    <option value="{{$course}}">{{$course}}</option>
                                    @endforeach 
                                </select>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Go to course') }}
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <br>
            @if (session('success') != "")
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
        </div>
    </div>
</div>
@endsection