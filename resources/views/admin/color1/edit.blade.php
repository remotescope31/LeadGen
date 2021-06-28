@extends('layouts.app')

@section('content')
    <div class="container">

        <form class="form-horizontal" action="{{ route('admin.color1.update',$color1) }}" method="post">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach

                </div>
            @endif



            {{ method_field('PUT') }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <label for="">Базовый цвет</label>
                <input type="text" class="form-control" name="color1" placeholder="Базовый цвет" value="@if(old('color1')){{old('color1')}}@else{{$color1->color1 ?? ""}}@endif" required>

            <!--       <label for="">Описание</label>
        <input type="text" class="form-control" name="description" placeholder="Описание" value="@if(old('description')){{old('description')}}@else{{$color1->description ?? ""}}@endif">
-->
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Базовые страхи</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" name="description" placeholder="Базовые страхи"  required>@if(old('description')){{old('description')}}@else{{$color1->description ?? ""}}@endif</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea2">Базовые ценности</label>
                    <textarea class="form-control" id="exampleFormControlTextarea2" rows="10" name="description1" placeholder="Базовые ценности"  required>@if(old('description1')){{old('description1')}}@else{{$color1->description1 ?? ""}}@endif</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea3">Ценностные слова</label>
                    <textarea class="form-control" id="exampleFormControlTextarea3" rows="10" name="description2" placeholder="Ценностные слова"  required>@if(old('description2')){{old('description2')}}@else{{$color1->description2 ?? ""}}@endif</textarea>
                </div>


            <hr/>

            <input class="btn btn-primary" type="submit" value="Сохранить">




        </form>


    </div>
@endsection
