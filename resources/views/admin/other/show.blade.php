@extends('layouts.app')

@section('content')
    <script>
    $(document).ready(function(){

        $.ajax({
            url: '{{ url('realclientinfo') }}',
            type: 'get',
            data: {id_client: {{$other->id_client}},id_policy: {{$other->id_policy}}},
            success: function(response){
                // Add response in Modal body
                $('#realclientinfo').html(response);

            }
        });


    });
    </script>
    <div class="container">

        <p>  ID Агента который внес изменения = {{$other->id_agent}}</p>
        <p>Время внесения изменений = {{date("d/m/Y H:i:s ",strtotime($other->dateupdate))}}</p>

        @if($other->oldfio != $other->newfio )
        <p>Фио изменено с  = {{$other->oldfio}} на = {{$other->newfio}}</p>
        @endif

        @if($other->olddatebirthd != $other->newdatebirthd )
        <p>Дата рождения с  = {{date("d/m/Y",strtotime($other->olddatebirthd))}} на = {{date("d/m/Y",strtotime($other->newdatebirthd))}}</p>
        @endif

        @if($other->oldpolicy_name != $other->newpolicy_name )
        <p>Полис с  = {{$other->oldpolicy_name}} на = {{$other->newpolicy_name}}</p>
        @endif

        @if($other->olddatepolicy != $other->newdatepolicy )
        <p>Дата полиса с  = {{date("d/m/Y",strtotime($other->olddatepolicy))}} на = {{date("d/m/Y",strtotime($other->newdatepolicy))}}</p>
        @endif

        @if($other->uniqueid )
            <p>Разговор прослушать <a href="/monitor/{{$other->uniqueid}}.mp3">{{$other->uniqueid}} </a></p>
        @endif
        <p id="realclientinfo"></p>


        <p id="realseconddatabaseclient"></p>

        <form onsubmit="if(confirm('Удалить?')){return true}else{ return false}" action="{{ route('admin.other.destroy',$other) }}" method="post">
            {{ method_field('DELETE') }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <button type="submit" class="btn btn-primary pull-right">Пометить как прочитано</button>


        </form>

        <form onsubmit="if(confirm('Откатить?')){return true}else{ return false}" action="{{ route('admin.other.destroy',$other) }}" method="post">
            {{ method_field('DELETE') }}

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <input type="hidden" name="otkat" value="1">


            <button type="submit" class="btn btn-primary pull-right">Откатить изменения</button>


        </form>

        <form action="{{ route('admin.other.index')}}" method="get">
                      <button type="submit" class="btn btn-primary pull-right">Вернуться</button>


        </form>


    </div>
@endsection
