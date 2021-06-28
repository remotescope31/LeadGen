@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{ route('admin.comment1.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Создать Дополнительный предустановленный комментарий</a>

        <table class="table table-striped">
            <thead>
            <th>Предустановленные комментарии</th>

            <th class="text-right">Действие</th>
            </thead>
            <tbody>
            @forelse($comment1s as $comment1)


                <tr>
                    <td><a href="{{ route('admin.comment1.edit',$comment1) }}">{{$comment1->comment1}}</a></td>

                                      <td class="text-right">
                        <form onsubmit="if(confirm('Удалить?')){return true}else{ return false}" action="{{ route('admin.comment1.destroy',$comment1) }}" method="post">
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-default" href="{{ route('admin.comment1.edit',$comment1) }}"><i class="fa fa-edit"></i> </a>
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
                        {{$comment1s->links()}}
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection
