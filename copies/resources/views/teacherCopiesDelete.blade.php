@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('The copies - ') }}{{$_POST['course']}}</div>
                    <div class="card-body">
                        @if (count($copies) === 0)
                                <p>Nothing for now...</p>
                        @else
                        <table>
                            <thead>
                                <tr>
                                    <th style='padding: 15px;'>student</th>
                                    <th style='padding: 15px;'>number</th>
                                    <th style='padding: 15px;'>delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $n = 1; ?>
                                @foreach ($copies as $copie)
                                <tr>
                                    <td>{{$copie['student']}}</td>
                                    <td><?= $n ?></td>
                                    <td>
                                        <form action="{{ route('copies.delete') }}" method="POST">
                                            @csrf
                                            <button class="download-button">delete</button>
                                            <input type="hidden" name="course" value="{{$_POST['course']}}">
                                            <input type="hidden" value="{{$copie['id']}}" name="id">
                                        </form>
                                    </td>
                                </tr>
                                <?php $n = $n+1; ?>
                                @endforeach
                        @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection