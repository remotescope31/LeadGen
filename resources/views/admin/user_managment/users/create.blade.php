@extends('layouts.app')

@section('content')
    <div class="container">

<form class="form-horizontal" action="{{ route('admin.user_managment.users.store') }}" method="post">

    @if ($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach

</div>
    @endif

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <label for="">ФИО</label>
    <input type="text" class="form-control" name="name" placeholder="ФИО" value="@if(old('name')){{old('name')}}@else{{$user->name ?? ""}}@endif" required>

    <label for="">Никнэйм</label>
    <input type="text" class="form-control" name="nickname" placeholder="Никнэйм" value="@if(old('nickname')){{old('nickname')}}@else{{$user->nickname ?? ""}}@endif" required>

    <label for="">Внутренний номер</label>
    <input type="text" class="form-control" name="internalphone" placeholder="Внутренний номер" value="@if(old('internalphone')){{old('internalphone')}}@else{{$user->internalphone ?? ""}}@endif">


        <label for="">Роль</label>
        <select class="form-control"  name='role' id="sel1">
            @if( Auth::user()->role >= 0)  <option value="0">Агент</option> @endif
            @if( Auth::user()->role >= 1)  <option value="1">Менеджер</option> @endif
            @if( Auth::user()->role >= 2)  <option value="2">Администратор</option> @endif
            @if( Auth::user()->role >= 3)  <option value="3">Super Администратор</option> @endif
        </select>


    <label for="">Пароль</label>
    <input type="password" class="form-control" name="password">

    <label for="">Подтверждение</label>
    <input type="password" class="form-control" name="password_confirmation">

    <hr/>

    <input class="btn btn-primary" type="submit" value="Сохранить">




</form>


    </div>
@endsection
