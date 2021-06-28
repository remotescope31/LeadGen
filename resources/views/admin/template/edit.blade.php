@extends('layouts.app')

@section('content')
    <div class="container">



        <form class="form-horizontal" action="{{ route('admin.template.update',$templete) }}" method="post">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach

                </div>
            @endif



            {{ method_field('PUT') }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <label for="">Название смс темплейта</label>
                <input type="text" class="form-control" name="templetesmsname" placeholder="Название смс темплейта" value="@if(old('templetesmsname')){{old('templetesmsname')}}@else{{$templete->templetesmsname ?? ""}}@endif" required>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Темплейт</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" placeholder="Темплейт"  required>@if(old('description')){{old('description')}}@else{{$templete->description ?? ""}}@endif</textarea>
                </div>


            <hr/>

            <input class="btn btn-primary" type="submit" value="Сохранить">




        </form>


    </div>
@endsection
