@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{ route('admin.bank.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Создать Банк</a>

        <table class="table table-striped">
            <thead>
            <th>Банк</th>
            <th>Телефон</th>
            <th class="text-right">Действие</th>
            </thead>
            <tbody>
            @forelse($banks as $bank)


                <tr>
                    <td><a href="{{ route('admin.bank.show',$bank) }}">{{$bank->name}}</a></td>
                    <td>{{$bank->phone}}</td>
                                      <td class="text-right">
                        <form onsubmit="if(confirm('Удалить?')){return true}else{ return false}" action="{{ route('admin.bank.destroy',$bank) }}" method="post">
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-default" href="{{ route('admin.bank.edit',$bank) }}"><i class="fa fa-edit"></i> </a>
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
            <tr>
                <td colspan="5">
                    <ul class="pagination pull-right">
                        {{$banks->links()}}
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection
