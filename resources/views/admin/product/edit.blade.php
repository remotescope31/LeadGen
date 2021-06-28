@extends('layouts.app')

@section('content')
    <div class="container">





        <form class="form-horizontal" action="{{ route('admin.product.update',$product) }}" method="post">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach

                </div>
            @endif



            {{ method_field('PUT') }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="">Название продукта</label>
                <input type="text" class="form-control" name="name_product" placeholder="Название продукта" value="@if(old('name_product')){{old('name_product')}}@else{{$product->name_product ?? ""}}@endif" required>

                <label for="">Риски</label>
                <input type="text" class="form-control" name="riski" placeholder="Риски" value="@if(old('riski')){{old('riski')}}@else{{$product->riski ?? ""}}@endif" required>

                <label for="">Вид кредита</label>
                <input type="text" class="form-control" name="vid_kred" placeholder="Вид кредита" value="@if(old('vid_kred')){{old('vid_kred')}}@else{{$product->vid_kred ?? ""}}@endif" required>

                <label for="">Страховая выплата по рискам жизни</label>
                <input type="text" class="form-control" name="poter_rab" placeholder="Страховая выплата по рискам жизни" value="@if(old('poter_rab')){{old('poter_rab')}}@else{{$product->poter_rab ?? ""}}@endif" required>

                <label for="">Страховая выплата по риску потери работы</label>
                <input type="text" class="form-control" name="strah_vipl" placeholder="Страховая выплата по риску потери работы" value="@if(old('strah_vipl')){{old('strah_vipl')}}@else{{$product->strah_vipl ?? ""}}@endif" required>


                <hr/>

                <input class="btn btn-primary" type="submit" value="Сохранить">




        </form>


    </div>
@endsection
