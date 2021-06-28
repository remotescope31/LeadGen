@extends('layouts.app')

@section('content')
    <div class="container">



        {{$bank->name}}

   <!--     <a href="{{ route('admin.policy.create') }}?bank={{$bank->id}}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Добавить Полис</a> -->
                 <a href="{{ route('admin.policy.create',['bank'=>$bank->id]) }}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Добавить Полис</a>

        <!--    <a href="{{ route('admin.policy.create',$bank) }}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Добавить Полис</a> -->


            <table class="table table-striped">
            <thead>
            <th>Описание Полиса</th>
            <th>Маска Полиса</th>
            <th>Тип продукта</th>
            <th class="text-right">Действие</th>
            </thead>
            <tbody>




            @forelse($policy as $pol)


                <tr>
                    <td><a href="{{ route('admin.policy.show',$pol) }}">{{$pol->name_policy}}</a></td>
                    <td>{{$pol->regex_policy}}</td>
                    <td>{{$pol->type_product}}</td>
                    <td class="text-right">
                        <form onsubmit="if(confirm('Удалить?')){return true}else{ return false}" action="{{ route('admin.policy.destroy',$pol ,['bank_id'=>$bank->id]) }}" method="post">
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-default" href="{{ route('admin.policy.edit',$pol,$bank) }}"><i class="fa fa-edit"></i> </a>
                            <button type="submit" class="btn"><i class="fa fa-trash-o"></i> </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center"><h2>Данные отсуствуют</h2></td>
                </tr>
            @endforelse
            </tbody>
            <tbody>
            </tbody>
        </table>

    </div>
@endsection
