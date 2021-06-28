@extends('layouts.app')

@section('content')
    <div class="container">

<a href="{{ route('admin.user_managment.users.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Создать пользователя</a>

<table class="table table-striped">
    <thead>
    <th>ФИО</th>
    <th>Никнэйм</th>
    <th>Внутренний номер</th>
    <th>Роль</th>
    <th class="text-right">Действие</th>
    </thead>
    <tbody>
    @forelse($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->nickname}}</td>
            <td>{{$user->internalphone ?? ""}}</td>
            <td>@switch($user->role)
                    @case(0)
                    Агент
                    @break
                    @case(1)
                    Менеджер
                    @break
                    @case(2)
                    Администратор
                    @break
                    @case(3)
                    SUPER Администратор
                    @break
                    @default
                    UNKNOWN
                @endswitch</td>
            <td class="text-right">
                <form onsubmit="if(confirm('Удалить?')){return true}else{ return false}" action="{{ route('admin.user_managment.users.destroy',$user) }}" method="post">
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a class="btn btn-default" href="{{ route('admin.user_managment.users.edit',$user) }}"><i class="fa fa-edit"></i> </a>
                    <button type="submit" class="btn"><i class="fa fa-trash-o"></i> </button>
                </form>
            </td>
        </tr>
    @empty
    <tr>
        <td colspan=5" class="text-center"><h2>Данные отсуствуют</h2></td>
    </tr>
    @endforelse
    </tbody>
<tbody>
<tr>
    <td colspan="5">
        <ul class="pagination pull-right">
            {{$users->links()}}
        </ul>
    </td>
</tr>
</tbody>
</table>

    </div>
@endsection
