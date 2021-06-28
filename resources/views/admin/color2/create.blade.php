@extends('layouts.app')

@section('content')
    <div class="container">

<form class="form-horizontal" action="{{ route('admin.color2.store') }}" method="post">

    @if ($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach

</div>
    @endif

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="">Вторичный цвет</label>
        <input type="text" class="form-control" name="color2" placeholder="Вторичный цвет" value="@if(old('color2')){{old('color2')}}@else{{$color2->color2 ?? ""}}@endif" required>

    <!--       <label for="">Описание</label>
        <input type="text" class="form-control" name="description" placeholder="Описание" value="@if(old('description')){{old('description')}}@else{{$color2->description ?? ""}}@endif">
-->
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Описание</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" placeholder="Описание" required>@if(old('description')){{old('description')}}@else{{$color2->description ?? ""}}@endif</textarea>
        </div>

        <hr/>

        <input class="btn btn-primary" type="submit" value="Сохранить">




</form>


    </div>
@endsection
