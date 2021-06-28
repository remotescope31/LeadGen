@extends('layouts.app')

@section('content')
    <div class="container">


    {{$policy->name_policy}}


        <a href="{{ route('admin.product.create',['policy'=>$policy->id]) }}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Добавить Продукт</a>




        <table class="table table-striped">
            <thead>
            <th>Название Продукта</th>
            <th>Риски</th>
            <th>Вид кредита</th>
            <th>Страховая выплата по рискам жизни</th>
            <th>Страховая выплата по риску потери работы</th>
            <th class="text-right">Действие</th>
            </thead>
            <tbody>




            @forelse($product as $prod)
                <tr>
                    <td>{{ $prod-> name_product }}</td>
                    <td>{{$prod-> riski}}</td>
                    <td>{{$prod-> vid_kred}}</td>
                    <td>{{$prod-> poter_rab}}</td>
                    <td>{{$prod-> strah_vipl}}</td>
                    <td class="text-right">
                        <form onsubmit="if(confirm('Удалить?')){return true}else{ return false}" action="{{ route('admin.product.destroy',$prod ,['policy_id'=>$policy->id]) }}" method="post">
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-default" href="{{ route('admin.product.edit',$prod,$policy) }}"><i class="fa fa-edit"></i> </a>
                            <button type="submit" class="btn"><i class="fa fa-trash-o"></i> </button>
                        </form>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center"><h2>Данные отсуствуют</h2></td>
                </tr>
            @endforelse
            </tbody>
            <tbody>
            </tbody>
        </table>


    </div>
@endsection
