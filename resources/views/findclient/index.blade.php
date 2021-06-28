@extends('layouts.app')



@section('content')

    <div class="container-fluid">


        <script>
            $(document).ready(function() {


                function check_fio_birthd() {
                    var valid = false;

                    var fio = $('#fio').val();
                    var datebirthd = $('#datebirthd').val();

                    if (fio.length > 0 && datebirthd.length>0) {
                        return true;
                    } else {
                        alert('Для Поиска по ФИО и дате рождения должно быть заполнены оба поля');
                        return false;
                    }


                }


                function check_numberpolicy() {
                    var valid = false;

                    var numberpolicy = $('#numberpolicy').val();


                    if (numberpolicy.length > 0 ) {
                        return true;
                    } else {
                        alert('Для Поиска по номеру полиса заполните поле полиса');
                        return false;
                    }


                }

                function check_numberphone() {
                    var valid = false;

                    var numberphone = $('#numberphone').val();


                    if (numberphone.length > 0) {
                        return true;
                    } else {
                        alert('Для Поиска по номеру телефона заполните поле телефона');
                        return false;
                    }


                }

                $("#basic-addon3").dblclick(function () {

                    var fio = $('#fio').val();
                    var datebirthd = $('#datebirthd').val();
                    if (check_fio_birthd()) {
                        // AJAX request
                        $.ajax({
                            url: '{{ url('search_callinfo') }}',
                            type: 'get',
                            data: {fio: fio,datebirthd:datebirthd},
                            success: function (response) {

                                //
                                $('#clientinfo').html(response);
                            }
                        });

                    } else {

                    }


                });

                $("#basic-addon4").dblclick(function () {

                    var numberpolicy = $('#numberpolicy').val();

                    if (check_numberpolicy()) {
                        // AJAX request
                        $.ajax({
                            url: '{{ url('search_callinfo') }}',
                            type: 'get',
                            data: {numberpolicy: numberpolicy},
                            success: function (response) {

                                //
                                $('#clientinfo').html(response);
                            }
                        });

                    } else {

                    }


                });
                $("#basic-addon6").dblclick(function () {

                    var numberphone = $('#numberphone').val();

                    if (check_numberphone()) {
                        // AJAX request
                        $.ajax({
                            url: '{{ url('search_callinfo') }}',
                            type: 'get',
                            data: {numberphone: numberphone},
                            success: function (response) {

                                $('#clientinfo').html(response);

                            }
                        });

                    } else {

                    }


                });

            });
        </script>




        <div class="row ">
            <div class="col-md-6 ">




                <div class="card">
                    <div class="card-header"></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="ФИО Клиента" aria-label="ФИО Клиента" name="fio" id="fio" aria-describedby="basic-addon2" required>
                                <div class="input-group-append" >
                                    <span class="input-group-text" id="basic-addon2">ФИО Клиента</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="День рождения" aria-label="День рождения" name="datebirthd" id="datebirthd" aria-describedby="basic-addon3" required>
                                <div class="input-group-append">
                                    <span class="input-group-text  alert-success" id="basic-addon3">День рождения</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Номер полиса" aria-label="Номер полиса" name="numberpolicy" id="numberpolicy" aria-describedby="basic-addon4">
                                <div class="input-group-append">
                                    <span class="input-group-text alert-success" id="basic-addon4">Поиск по номеру полиса</span>
                                </div>
                             </div>



                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Номер телефона" aria-label="Номер телефона" name="numberphone" id="numberphone" aria-describedby="basic-addon6">
                                <div class="input-group-append">
                                    <span class="input-group-text alert-success" id="basic-addon6">Поиск по номеру телефона</span>
                                </div>
                            </div>











                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Информация</div>
                    <div class="card-body">







                        <p class="card-text">
                            разное инфо

                        <p id="clientinfo"></p>
                        </p>
                    </div>

                </div>
            </div>



        </div>





    </div>
@endsection
