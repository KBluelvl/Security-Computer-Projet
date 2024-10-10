@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('The roles') }}</div>
                    <div class="card-body">
                        <table style='border: 1px solid;'>
                        <thead style='border: 1px solid;'>
                            <th style='border: 1px solid; padding: 15px;'>id</th>
                            <th style='padding: 15px;'>username</th>
                            <th style='padding: 15px;'>role</th>
                            <th style='padding: 15px;'>accept</th>
                            <th style='padding: 15px;'>decline</th>
                        </thead>
                        <tbody>
                        <?php $n = 1 ?>
                        @foreach ($requests as $request)
                            <tr>
                            <td style='border: 1px solid;'><?= $n ?></td>
                            <td name='username'>{{$request->username}}</td>
                            <td>{{$request->name}}</td>
                            <td>
                                <form action="{{route('acceptRole')}}" method="post">
                                @csrf
                                    <input type="hidden" name="username" value="{{$request->username}}">
                                    <button type="submit" class="btn btn-primary" style='background-color: green'>ACCEPT</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{route('declineRole')}}" method="post">
                                @csrf
                                    <input type="hidden" name="username" value="{{$request->username}}">
                                    <button class="btn btn-primary" style='background-color: red'>DECLINE</button>
                                </form>
                            </td>
                            </tr>
                            <?php $n = $n +1 ?>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection