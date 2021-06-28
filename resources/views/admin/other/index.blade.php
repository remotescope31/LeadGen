@extends('layouts.app')

@section('content')
    <div class="container">

       Просмотр сделаных важных изменений

        <table class="table table-striped">
            <thead>
            <th>id клиента</th>
            <th>id полиса</th>
            <th>id agent</th>
            <th>время изменения</th>
            </thead>
            <tbody>
            @forelse($others as $other)



                <tr>
                    <td><a href="{{ route('admin.other.show',$other) }}">{{$other->id_client}}</a></td>
                    <td>{{$other->id_policy}}</td>
                    <td>{{$other->id_agent}}</td>
                    <td>{{date("d/m/Y H:i:s ",strtotime($other->dateupdate))}}</td>

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
                        {{$others->links()}}
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection
