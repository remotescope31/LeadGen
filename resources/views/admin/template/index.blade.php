@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{ route('admin.template.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Создать смс темплейт</a>

        <table class="table table-striped">
            <thead>
            <th>Темплейт</th>

            <th class="text-right">Действие</th>
            </thead>
            <tbody>
            @forelse($templates as $templateone)


                <tr>
                    <td><a href="{{ route('admin.template.edit',$templateone) }}">{{$templateone->templetesmsname}}</a></td>

                                      <td class="text-right">
                        <form onsubmit="if(confirm('Удалить?')){return true}else{ return false}" action="{{ route('admin.template.destroy',$templateone) }}" method="post">
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-default" href="{{ route('admin.template.edit',$templateone) }}"><i class="fa fa-edit"></i> </a>
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
                        {{$templates->links()}}
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection
