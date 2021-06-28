@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{ route('admin.color1.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Создать Базовый цвет</a>

        <table class="table table-striped">
            <thead>
            <th>Базовый цвет</th>

            <th class="text-right">Действие</th>
            </thead>
            <tbody>
            @forelse($color1s as $color1)


                <tr>
                    <td><a href="{{ route('admin.color1.edit',$color1) }}">{{$color1->color1}}</a></td>

                                      <td class="text-right">
                        <form onsubmit="if(confirm('Удалить?')){return true}else{ return false}" action="{{ route('admin.color1.destroy',$color1) }}" method="post">
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-default" href="{{ route('admin.color1.edit',$color1) }}"><i class="fa fa-edit"></i> </a>
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
                        {{$color1s->links()}}
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection
