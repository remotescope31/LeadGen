@extends('layouts.app')

@section('content')
    <div class="container">

        <form class="form-horizontal" action="{{ route('admin.comment1.update',$comment1) }}" method="post">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach

                </div>
            @endif



            {{ method_field('PUT') }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <label for="">Предустановленный комментарий</label>
                <input type="text" class="form-control" name="comment1" placeholder="Предустановленный комментарий" value="@if(old('comment1')){{old('comment1')}}@else{{$comment1->comment1 ?? ""}}@endif" required>

            <hr/>

            <input class="btn btn-primary" type="submit" value="Сохранить">




        </form>


    </div>
@endsection
