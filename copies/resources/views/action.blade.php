@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Course - ') }}{{$_POST['course']}}</div>

                    <div class="card-body">
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <form method="POST" action="{{ route('copies.teacher.upload') }}">
                                    @csrf
                                    <input type="hidden" name="course" value="{{$_POST['course']}}">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('upload copies') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <form method="POST" action="{{ route('copies.teacher.view') }}">
                                    @csrf
                                    <input type="hidden" name="course" value="{{$_POST['course']}}">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('view copies') }}
                                        </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <form method="POST" action="{{route('copies.teacher.delete')}}">
                                    @csrf
                                    <input type="hidden" name="course" value="{{$_POST['course']}}">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('delete copies') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection