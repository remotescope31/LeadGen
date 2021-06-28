
@extends('layouts.app')


@section('content')
    <script type="text/javascript">

        $(document).ready(function() {
            $.ajax({
                url: '{{ url('search_banklisting') }}',
                type: 'get',
                success: function (response) {

                    var len = response.length;

                    $("#bankselect").empty();

                    if (bankselect == 0) {
                        $("#bankselect").append("<option selected value=\"0\">Выберите Банк</option>");
                    } else {
                        $("#bankselect").append("<option value=\"0\">Выберите Банк</option>");
                    }
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        if (bankselect == id) {
                            $("#bankselect").append("<option selected value='" + id + "'>" + name + "</option>");
                        } else {
                            $("#bankselect").append("<option value='" + id + "'>" + name + "</option>");
                        }
                    }


                }
            });

        });
    </script>
    <div class="container">

        <div class="container mt-5">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-12 m-auto">

                    @if(Session::has("success"))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>Success!</strong> {{Session::get("success")}}
                        </div>
                    @elseif(Session::has("failed"))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>Alert!</strong> {{Session::get("failed")}}
                        </div>

                    @endif
                    <form method="post" action="{{url('admin/parse-csv')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card shadow">
                            <div class="card-header">
                                <h4> Импорт CSV Файла в базу АСЖ </h4>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <input type="file" name="csv_file" class="form-control">
                                    {!!$errors->first("csv_file", '<small class="text-danger">Необходим файл данных csv</small>') !!}
                                </div>
                                <div class="input-group mb-2" id="bankselect1" >
                                    <select class="custom-select" name="bankselect" id="bankselect">
                                        <option selected value="0">Выберите Банк</option>
                                    </select>
                                </div>

                            </div>



                            <div class="card-footer">
                                <button type="submit" class="btn btn-success" name="submit">Импорт данных</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    </div>
@endsection
