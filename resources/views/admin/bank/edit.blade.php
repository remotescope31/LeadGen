@extends('layouts.app')

@section('content')
    <div class="container">

        <form class="form-horizontal" action="{{ route('admin.bank.update',$bank) }}" method="post">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach

                </div>
            @endif

            {{ method_field('PUT') }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <label for="">название банка</label>
            <input type="text" class="form-control" name="name" placeholder="" value="@if(old('name')){{old('name')}}@else{{$bank->name ?? ""}}@endif" required>

            <label for="">телефон</label>
            <input type="text" class="form-control" name="phone" placeholder="Никнэйм" value="@if(old('phone')){{old('phone')}}@else{{$bank->phone ?? ""}}@endif" required>


            <hr/>

            <input class="btn btn-primary" type="submit" value="Сохранить">




        </form>


    </div>
@endsection
