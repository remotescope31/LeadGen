@extends('layouts.app')

@section('content')
    <div class="container">




 <form class="form-horizontal" action="{{ route('admin.policy.store') }}" method="post">

    @if ($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach


</div>
    @endif

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="">название полиса</label>
        <input type="text" class="form-control" name="name_policy" placeholder="Название Полиса" value="@if(old('name_policy')){{old('name_policy')}}@else{{$polis->name_policy ?? ""}}@endif" required>

        <label for="">Маска полиса</label>
        <input type="text" class="form-control" name="regex_policy" placeholder="Маска полиса" value="@if(old('regex_policy')){{old('regex_policy')}}@else{{$polis->regex_policy ?? ""}}@endif" required>

        <label for="">Тип продукта</label>
        <input type="text" class="form-control" name="type_product" placeholder="Тип продукта" value="@if(old('Тип продукта')){{old('type_product')}}@else{{$policy->type_product ?? ""}}@endif" required>


        <input type="hidden" name="bank_id" value="{{ request()->query('bank') }}">

        <hr/>

        <input class="btn btn-primary" type="submit" value="Сохранить">




</form>


    </div>
@endsection
