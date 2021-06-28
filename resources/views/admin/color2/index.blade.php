@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{ route('admin.color2.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Создать Базовый цвет</a>

        <table class="table table-striped">
            <thead>
            <th>Вторичный цвет</th>
            <th>Описание</th>
            <th class="text-right">Действие</th>
            </thead>
            <tbody>
            @forelse($color2s as $color2)


                <tr>
                    <td><a href="{{ route('admin.color2.edit',$color2) }}">{{$color2->color2}}</a></td>
                    <td>{{$color2->description}}</td>
                                      <td class="text-right">
                        <form onsubmit="if(confirm('Удалить?')){return true}else{ return false}" action="{{ route('admin.color2.destroy',$color2) }}" method="post">
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-default" href="{{ route('admin.color2.edit',$color2) }}"><i class="fa fa-edit"></i> </a>
                            <button type="submit" class="btn"><i class="fa fa-trash-o"></i> </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center"><h2>Данные отсуствуют</h2></td>
                </tr>
            @endforelse
            </tbody>
            <tbody>
            <tr>
                <td colspan="5">
                    <ul class="pagination pull-right">
                        {{$color2s->links()}}
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection
