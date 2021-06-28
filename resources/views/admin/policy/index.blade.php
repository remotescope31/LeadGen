@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{ route('admin.polis.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i>Создать Банк</a>

      {{dump($polis)}}

    </div>
@endsection
