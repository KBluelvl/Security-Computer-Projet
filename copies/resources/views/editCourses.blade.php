@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Adding courses') }}</div>
                    <div class="card-body">
                    <form action="{{route('addingCourse')}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">name</label>
                            <div class="col-md-6">
                                <input name='name' id='name' type="text"><br>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="teacher" class="col-md-4 col-form-label text-md-end">Select a teacher</label>
                            <div class="col-md-6">
                                <select id="teacher" name="teacher">
                                @foreach ($teachers as $teacher)
                                <option value="{{$teacher['id']}}">{{$teacher['name']}}</option>
                                @endforeach 
                                </select><br><br>
                            </div>
                        </div> 
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create course') }}
                                </button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
        <div style='margin: 10px;'></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Delete courses') }}</div>
                    <div class="card-body">
                    <form action="{{route('deleteCourse')}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="course" class="col-md-4 col-form-label text-md-end">Select a Course</label>
                            <div class="col-md-6">
                                <select id="course" name="course">
                                @foreach ($courses as $course)
                                <option value="{{$course}}">{{$course}}</option>
                                @endforeach 
                                </select>
                            </div>
                        </div> 
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Delete course') }}
                                </button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection