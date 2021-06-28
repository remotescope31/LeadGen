@extends('layouts.app')



@section('content')

    <div class="container-fluid">
        <!-- Script -->
        <!--

                   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

                     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


                           <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

                   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        -->




        <script type="text/javascript">
            $( function() {
                $('#region').autocomplete({
                    source: '{{ url('search_region') }}',
                    minlenght: 1,
                    autoFocus: true,

                });
            });
        </script>


        <script>
            $( function() {
                var availableOtkaz = [
                    "Дорого",
                    "Уже есть страхование",
                    "Навязали страхование",
                    "Досрочное погашение"
                ];
                $( "#otkaz" ).autocomplete({
                    source: availableOtkaz
                });
            } );
        </script>




        <script type="text/javascript">
            $( function() {
                $('#city').autocomplete({
                    source: '{{ url('search_city') }}',
                    minlenght: 1,
                    autoFocus: true,

                });
            });
        </script>

        <script>

            function validateForm() {
                var x = $('#uniqueid').val();
              //  console.log(x);
                if (x == "") {
                    alert("Нельзя сохранять без звонка");
                    return false;
                }
            }



            function clearData(){
                $("#fio").val("");
                $("#datebirthd").val("");
                $("#numberpolicy").val("");
                $("#datepolicy").val("");
                $("#numberphone").val("");
                $("#summstrah").val("");
                $("#summkred").val("");
                $("#srokdogov").val("");
                $("#region").val("");
                $("#city").val("");
                $("#comment1").val(0).change();
                $("#comment2").val("");

                $("#bankselect").val(0).change();


                $("#rodstvenniki").val("");
                $("#color1").val(0).change();
                $("#color2").val(0).change();

                $("#basic-addon88").text("");

                $("#reshenie").val('');
                $("#udergal").val('');
                $("#otkaz").val('');
                $("#udergal1").hide();
                $("#otkaz1").hide();

                $("#id_client").val("");
                $("#id_database").val("");
                $("#id_policy").val("");
              //  $("#uniqueid").val("");

                $('#policyinfochange').html("");
                $('#clientinfochange').html("");
                $('#smsinfo').html("");
            }

            $(document).ready(function(){

                document.getElementById('client').onkeydown = function(e) {

                    if (e.keyCode === 13) {
                        event.preventDefault();
                        return false;
                    }
                    return true;
                }

                $('input').attr('autocomplete','off');


                $("#newclient").click(function(){
                    clearData();
                });
            });
        </script>

        <script>
            var id_client;
            var id_database;

            function check_fio_birthd()
            {
                var valid = false;

                var fio = $('#fio').val();

                if(fio.length>0)
                {
                    return true;
                }else{
                    alert('Для Поиска по ФИО должно быть заполнено поле фио');
                    return false;
                }


            }



            $(document).ready(function(){


                 $.ajax({
                    url: '{{ url('search_banklisting') }}',
                    type: 'get',
                    success: function(response){

                        var len = response.length;

                        $("#bankselect").empty();

                        $("#bankselect").append("<option selected value=\"0\">Выберите Банк</option>");
                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var name = response[i]['name'];

                            $("#bankselect").append("<option value='"+id+"'>"+name+"</option>");

                        }



                    }
                });








                        function newMsg(data){



                            if(data.data == "yes"){


                                phone = $.parseJSON(data.fromnumber);
                                $("#uniqueid").val(data.uniqueid);

                                // AJAX request
                                $.ajax({
                                    url: '{{ url('search_phone') }}',
                                    type: 'get',
                                    data: {phone: phone},
                                    success: function(response){
                                        // Add response in Modal body
                                        $('#empModal').find('.modal-body').html(response);
                                        //$('.modal-body').html(response);

                                        // Display Modal
                                        $('#empModal').modal('show');
                                    }
                                });




                            }}
                        setInterval(function(){
                                $.ajax({
                                        url: "{{ url('search_newcall') }}",
                                        type: "get",
                                        dataType: "json",
                                        success: newMsg
                                });
                            },2000)











                // AJAX request
                $.ajax({
                    url: '{{ url('searchcolorinfo') }}',
                    type: 'get',
                    success: function(response){
                        // Add response in Modal body
                        $('#accordionExample').html(response);

                    }
                });









                $("#summstrah").change(function(){
                    if($('#summstrah').val() && $('#srokdogov').val()) {
                        $("#basic-addon88").text('В месяц '+($('#summstrah').val() / $('#srokdogov').val()).toFixed(2)+ ';  В день '+($('#summstrah').val() / $('#srokdogov').val()/30).toFixed(2));
                        }else{ $("#basic-addon88").text("");

                    }
                });

                $("#srokdogov").change(function(){
                    if($('#summstrah').val() && $('#srokdogov').val()) {
                        $("#basic-addon88").text('В месяц '+($('#summstrah').val() / $('#srokdogov').val()).toFixed(2)+ ';  В день '+($('#summstrah').val() / $('#srokdogov').val()/30).toFixed(2));
                    }else{ $("#basic-addon88").text("");

                    }
                });


//comment1
                $.ajax({
                    url: '{{ url('search_comment1listing') }}',
                    type: 'get',
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;

                        $("#comment1").empty();
                        $("#comment1").append("<option selected value=\"0\">Выберите предустановленный комментарий</option>");

                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var name = response[i]['comment1'];

                            $("#comment1").append("<option value='" + name + "'>" + name + "</option>");

                        }
                    }
                });
//color1
                $.ajax({
                    url: '{{ url('search_color1listing') }}',
                    type: 'get',
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;

                        $("#color1").empty();
                        $("#color1").append("<option selected value=\"0\">Выберите первичный цвет</option>");

                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var name = response[i]['color1'];

                            $("#color1").append("<option value='" + name + "'>" + name + "</option>");

                        }
                    }
                });
//color2
                $.ajax({
                    url: '{{ url('search_color2listing') }}',
                    type: 'get',
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;

                        $("#color2").empty();
                        $("#color2").append("<option selected value=\"0\">Выберите вторичный цвет</option>");

                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var name = response[i]['color2'];

                            $("#color2").append("<option value='" + name + "'>" + name + "</option>");

                        }
                    }
                });


///////////////////////////
                $('body').on('click','#search_phone', function(){

                    clearData();

                    id_client=$(this).attr("data")
                    id_database=$(this).attr("database")
                    id_policy=$(this).attr("id_policy")


                    $('#empModal').modal('hide');


                    $("#numberphone").val($("#search_phone").text());






                    $.ajax({
                        url: '{{ url('search_banklisting') }}',
                        type: 'get',
                        success: function(response){

                            var len = response.length;

                            $("#bankselect").empty();

                            if(bankselect==0) {
                                $("#bankselect").append("<option selected value=\"0\">Выберите Банк</option>");
                            }else{
                                $("#bankselect").append("<option value=\"0\">Выберите Банк</option>");
                            }
                            for( var i = 0; i<len; i++){
                                var id = response[i]['id'];
                                var name = response[i]['name'];
                                if(bankselect==id) {
                                    $("#bankselect").append("<option selected value='" + id + "'>" + name + "</option>");
                                }else{
                                    $("#bankselect").append("<option value='" + id + "'>" + name + "</option>");
                                }
                            }



                        }
                    });



                });

//////////////////////////////////////////

                $('body').on('click','tbody td', function(){

                  //  alert('event on  new_wl');


                if($(this).attr("data")=='client') return;
                if($(this).attr("data")=='policy') return;
                if($(this).attr("data")=='infoproduct') return;
                if($(this).attr("data")==undefined) return;

                if($(this).attr("regex")=='regex')
                {
                    id_product=$(this).attr("data")

                    temp_bank=$(this).attr("bank")
                    $("#bankselect1").show()
                    $("#bankselect").val(temp_bank).change();
                    $("#policyselect").val(id_product);

                    // AJAX request
                    $.ajax({
                        url: '{{ url('searchinfoproduct') }}',
                        type: 'get',
                        data: {id_product: id_product},
                        success: function(response){
                            // Add response in Modal body
                            $('#productinfo').html(response);

                        }
                    });

                    $('#empModalproduct').modal('hide');
                    return;
                }




                    clearData();

                    id_client=$(this).attr("data")
                    id_database=$(this).attr("database")
                    id_policy=$(this).attr("id_policy")

                    $("#id_client").val(id_client);
                    $("#id_database").val(id_database);
                    $("#id_policy").val(id_policy);



                    //console.log(id_client);
                    // console.log(id_database);
                    // console.log(id_policy);

                    //info policy change comments
                    if(id_policy && id_database!=2)
                    {
                        // AJAX request
                        $.ajax({
                            url: '{{ url('searchinfopolicy') }}',
                            type: 'get',
                            data: {id_policy: id_policy},
                            success: function(response){
                                // Add response in Modal body
                                $('#policyinfochange').html(response);

                            }
                        });
                    }

                    if(id_client && id_database!=2)
                    {
                        // AJAX request
                        $.ajax({
                            url: '{{ url('searchinfoclient') }}',
                            type: 'get',
                            data: {id_client: id_client},
                            success: function(response){
                                // Add response in Modal body
                                $('#clientinfochange').html(response);

                            }
                        });
                    }

                    $('#empModal').modal('hide');


                    // AJAX request
                    $.ajax({
                        url: '{{ url('search_client') }}',
                        type: 'get',
                        dataType: 'JSON',
                        data: {id_client: id_client,id_database:id_database,id_policy:id_policy},
                        success: function (response) {

                            //  for(var key in response) {
                            //    $('#msgid').append(key);
                            //    $('#msgid').append('=' + data[key] + '<br />');

                            $("#fio").val(response.fio);
                            $("#datebirthd").val(response.data_rog);
                            $("#color1").val(response.color1).change();





                            $("#numberphone").val(response.phone);


                            $("#numberpolicy").val(response.polis);
                            $("#datepolicy").val(response.data_polis);

                            $("#summkred").val(response.sum_kred);
                            $("#summstrah").val(response.sum_strah);
                            $("#srokdogov").val(response.srok_dogov);

                            $("#region").val(response.region);
                            $("#city").val(response.city);


                            $("#comment1").val(response.comment1).change();
                            $("#comment2").val(response.comment2);
                            $("#rodstvenniki").val(response.rodstvenniki);


                            $("#bankselect1").show();


                            bankselect=$.parseJSON(response.bankselect);


                            $("#reshenie").val(response.reshenie);


                            if( $("#reshenie").val() == "Подумать" || $("#reshenie").val() == '')
                            {
                                $("#udergal").val('');
                                $("#otkaz").val('');
                                $("#udergal1").hide();
                                $("#otkaz1").hide();
                            }
                            if( $("#reshenie").val() == 'Остаться')
                            {
                                $("#udergal").val('');
                                $("#otkaz").val('');
                                $("#udergal1").show();
                                $("#otkaz1").hide();
                                $("#udergal").val(response.udergal);
                            }
                            if( $("#reshenie").val() == "Расторгнуть")
                            {
                                $("#udergal").val('');
                                $("#otkaz").val('');
                                $("#udergal1").hide();
                                $("#otkaz1").show();
                                $("#otkaz").val(response.otkaz)
                            }


// umm in day

                            //   console.log($('#summstrah').val());
                            //  console.log($('#srokdogov').val());
                            //    $("#basic-addon88").val(($('#summstrah').val()/$('#srokdogov').val()));
                            if($('#summstrah').val() && $('#srokdogov').val()) {
                                $("#basic-addon88").text('В месяц '+($('#summstrah').val() / $('#srokdogov').val()).toFixed(2)+ ';  В день '+($('#summstrah').val() / $('#srokdogov').val()/30).toFixed(2));
                            }else{ $("#basic-addon88").text("");

                            }




                            ///sms search jn phone number
                            $.ajax({
                                url: '{{ url('search_smsonphone') }}',
                                type: 'get',
                                data: {phone:$("#numberphone").val()},
                                dataType: 'json',
                                success:function(response){

                                    var len = response.length;


                                }
                            });









                            $.ajax({
                                url: '{{ url('search_banklisting') }}',
                                type: 'get',
                                success: function(response){

                                    var len = response.length;

                                    $("#bankselect").empty();

                                    if(bankselect==0) {
                                        $("#bankselect").append("<option selected value=\"0\">Выберите Банк</option>");
                                    }else{
                                        $("#bankselect").append("<option value=\"0\">Выберите Банк</option>");
                                    }
                                    for( var i = 0; i<len; i++){
                                        var id = response[i]['id'];
                                        var name = response[i]['name'];
                                        if(bankselect==id) {
                                            $("#bankselect").append("<option selected value='" + id + "'>" + name + "</option>");
                                        }else{
                                            $("#bankselect").append("<option value='" + id + "'>" + name + "</option>");
                                        }
                                    }



                                }
                            });



                            //  }


                        }
                    });

                });


                $("#basic-addon4").dblclick(function(){

                    var numbepolicy = $('#numberpolicy').val();

                    // AJAX request
                    $.ajax({
                        url: '{{ url('search_policy') }}',
                        type: 'get',
                        data: {policy: numbepolicy},
                        success: function(response){
                            // Add response in Modal body
                            $('#empModal').find('.modal-body').html(response);
                            //$('modal-body').html(response);

                            // Display Modal
                            $('#empModal').modal('show');
                        }
                    });


                });


                $("#basic-addon45").dblclick(function(){

                    var numbepolicy = $('#numberpolicy').val();

                    $('#productinfo').html("");
                    // AJAX request
                    $.ajax({
                        url: '{{ url('search_regexproduct') }}',
                        type: 'get',
                        data: {policy: numbepolicy},
                        success: function(response){
                            // Add response in Modal body
                            $('#empModalproduct').find('.modal-body').html(response);
                            //$('modal-body').html(response);

                            // Display Modal
                            $('#empModalproduct').modal('show');
                        }
                    });


                });




                $("#basic-addon6").dblclick(function(){

                    var phone = $('#numberphone').val();

                    // AJAX request
                    $.ajax({
                        url: '{{ url('search_phone') }}',
                        type: 'get',
                        data: {phone: phone},
                        success: function(response){
                            // Add response in Modal body


                            $('#empModal').find('.modal-body').html(response);
                           // $('.modal-body').html(response);

                            // Display Modal
                            $('#empModal').modal('show');
                        }
                    });


                });

                $("#basic-addon66").dblclick(function(){

                    //  console.log(id_database);


                    $("#addphone1").show();

                });

                $("#basic-addon666").click(function() {

                    if (id_client > 0 && id_database==1) {

                        // AJAX request
                        $.ajax({
                            url: '{{ url('add_phone') }}',
                            type: 'get',
                            dataType: 'JSON',
                            data: {id_client: id_client, id_database: id_database, phone: $('#addphone').val()},
                            success: function (response) {


                            }
                        });


                        $("#addphone1").hide();
                    } else {
                        alert("Дополнительный номер сохранится при сохранении клиента")
                    }
                }   );



                $("#basic-addon2").dblclick(function(){

                    var fio = $('#fio').val();

                    if(check_fio_birthd())
                    {
                        // AJAX request
                        $.ajax({
                            url: '{{ url('search_fio') }}',
                            type: 'get',
                            data: {fio: fio},
                            success: function(response){
                                // Add response in Modal body
                                $('#empModal').find('.modal-body').html(response);
                                //$('.modal-body').html(response);

                                // Display Modal
                                $('#empModal').modal('show');
                            }
                        });

                    }else{

                    }


                });

                $("#numberpolicy").dblclick(function(){


                    $("#bankselect1").show();


                    $.ajax({
                        url: '{{ url('search_banklisting') }}',
                        type: 'get',
                        success: function(response){

                            var len = response.length;

                            $("#bankselect").empty();

                            $("#bankselect").append("<option selected value=\"0\">Выберите Банк</option>");
                            for( var i = 0; i<len; i++){
                                var id = response[i]['id'];
                                var name = response[i]['name'];

                                $("#bankselect").append("<option value='"+id+"'>"+name+"</option>");

                            }



                        }
                    });

                });

                $("#basic-addon44").dblclick(function(){

                    $("#numberpolicy").val('Отсутствует полис на руках');
                    $("#bankselect1").show();


                    $.ajax({
                        url: '{{ url('search_banklisting') }}',
                        type: 'get',
                        success: function(response){

                            var len = response.length;

                            $("#bankselect").empty();

                            $("#bankselect").append("<option selected value=\"0\">Выберите Банк</option>");
                            for( var i = 0; i<len; i++){
                                var id = response[i]['id'];
                                var name = response[i]['name'];

                                $("#bankselect").append("<option value='"+id+"'>"+name+"</option>");

                            }



                        }
                    });

                });



                $("#reshenie").change(function(){
                    var reshenieid = $(this).val();

                    if( reshenieid == "Подумать" || reshenieid == '')
                    {
                        $("#udergal").val('');
                        $("#otkaz").val('');
                        $("#udergal1").hide();
                        $("#otkaz1").hide();
                    }
                    if( reshenieid == 'Остаться')
                    {
                        $("#udergal").val('');
                        $("#otkaz").val('');
                        $("#udergal1").show();
                        $("#otkaz1").hide();
                    }
                    if( reshenieid == "Расторгнуть")
                    {
                        $("#udergal").val('');
                        $("#otkaz").val('');
                        $("#udergal1").hide();
                        $("#otkaz1").show();
                    }



                });



            });


            <!-- Modal SMS -->
            $(function(){
                $('#myFormSubmit').click(function(e){
                    e.preventDefault();
                    $('#formResults').text($('#myForm').serialize());
                    $("#errorsms").html("");

                    $.post('search_sendsms',
                       $('#myForm').serialize(),
                       function(data, status, xhr){



                           if(data.data == "no"){

                              // console.log(data.texterror);

                              // phone = $.parseJSON(data.fromnumber);
                               $("#errorsms").html(data.texterror);

                             }else{
                               $("#modalSendSms").modal("hide");
                           }






                       },'json');

                });
            });


            $(document).ready(function(){


                $("#sms").click(function(){
                    $("#errorsms").html("");
                    $("#numberphonesms").val($("#numberphone").val());
                    $("#modalSendSms").modal("show");

                    $.ajax({
                        url: '{{ url('search_templetesms') }}',
                        type: 'get',
                        success: function(response){

                            var len = response.length;

                            $("#templatesms").empty();

                            $("#templatesms").append("<option selected value=\"0\">Выберите темплейт</option>");
                            for( var i = 0; i<len; i++){
                                var id = response[i]['id'];
                                var name = response[i]['name'];

                                $("#templatesms").append("<option value='"+id+"'>"+name+"</option>");

                            }



                        }
                    });






                });


                $("#templatesms").change(function(){
                    var templatesmsid = $(this).val();

                    $.ajax({
                        url: '{{ url('search_templetesms') }}',
                        type: 'get',
                        dataType: 'json',
                        success:function(response){

                            var len = response.length;

                            $("#textsms").empty();


                            for( var i = 0; i<len; i++){

                                var id = response[i]['id'];
                                var name = response[i]['description'];

                                if(id==templatesmsid)
                                {
                                    $("#textsms").val(name);

                                }


                            }


                        }
                    });
                });


            });
        </script>

        <!-- Modal -->
        <div class="modal fade" id="empModal" role="dialog">
            <div class="modal-dialog  modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Информация о клиенте</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    </div>

                </div>
            </div>
        </div>


        <!-- Modal продукт -->
        <div class="modal fade" id="empModalproduct" role="dialog">
            <div class="modal-dialog  modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Информация о продуктах</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal SMS -->
        <div id="modalSendSms" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="myModalLabel">смс</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="myForm" method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Номер телефона" aria-label="Номер телефона" name="numberphonesms" id="numberphonesms" >

                            </div>

                            <div class="input-group mb-3">
                                <select class="custom-select" name="templatesms" id="templatesms">
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="textsms">Текст СМС</label>
                                <textarea class="form-control" id="textsms" rows="10" name="textsms" placeholder="Текст СМС"  required></textarea>
                            </div>
                            <p id="errorsms"></p>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button id="myFormSubmit" class="btn rounded-right" type="submit">Отослать смс</button>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>

                    </div>
                </div>
            </div>
        </div>
















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

                        <button type="button" class="btn btn-primary" id="newclient" name="newclient">Новый клиент</button>

                         <button type="button" class="btn btn-primary" id="sms">СМС</button>

                        </br></br>


                            @if (Auth::user()->role == 0)
                        <form id="client" =name="client" action="{{ route('client.store') }}" onsubmit="return validateForm()" method="post">
                            @else
                         <form id="client" name="client"  action="{{ route('client.store') }}" method="post">
                            @endif

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="ФИО Клиента" aria-label="ФИО Клиента" name="fio" id="fio" aria-describedby="basic-addon2" required>
                                <div class="input-group-append" >
                                    <span class="input-group-text alert-success" id="basic-addon2">ФИО Клиента</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="День рождения" aria-label="День рождения" name="datebirthd" id="datebirthd" aria-describedby="basic-addon3" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon3">День рождения</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Номер полиса" aria-label="Номер полиса" name="numberpolicy" id="numberpolicy" aria-describedby="basic-addon4">
                                <div class="input-group-append">
                                    <span class="input-group-text alert-success" id="basic-addon4">Номер полиса</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text alert-success" id="basic-addon44">Нет на руках</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text alert-success" id="basic-addon45">Продукты</span>
                                </div>
                            </div>

                            <div class="input-group mb-3" id="bankselect1" style="display: none;">
                                <select class="custom-select" name="bankselect" id="bankselect">
                                    <option selected value="0">Выберите Банк</option>
                                </select>
                            </div>


                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Дата полиса" aria-label="Дата полиса" name="datepolicy" id="datepolicy" aria-describedby="basic-addon5">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon5">Дата полиса</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Номер телефона" aria-label="Номер телефона" name="numberphone" id="numberphone" aria-describedby="basic-addon6">
                                <div class="input-group-append">
                                    <span class="input-group-text alert-success" id="basic-addon6">Номер телефона</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text alert-success" id="basic-addon66">Добавить номер</span>
                                </div>
                            </div>

                            <div class="input-group mb-3" id="addphone1" style="display: none;">
                                <input type="text" class="form-control" placeholder="Добавить номер" aria-label="Добавить номер" name="addphone" id="addphone" aria-describedby="basic-addon666">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon666">Сохранить номер</span>
                                </div>
                            </div>


                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Сумма страхования" aria-label="Сумма страхования" name="summstrah" id="summstrah" aria-describedby="basic-addon7">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon7">Сумма страхования</span>
                                </div>
                            </div>


                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Сумма кредита" aria-label="Сумма кредита" name="summkred" id="summkred" aria-describedby="basic-addon8">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon8">Сумма кредита</span>
                                </div>

                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Срок договора" aria-label="Срок договора" name="srokdogov" id="srokdogov" aria-describedby="basic-addon81">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon81">Срок договора</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon88" name="basic-addon88"></span>
                                </div>
                            </div>


                            <!--
                                                                    <div class="col-lg-6">

                                                                        <div class="form-group">
                                                                       <input type="text" name="region" autocomplete="off" id="region" placeholder="Enter country name" class="form-control">
                                                                        </div>
                                                                        <div id="region_list"></div>
                                                                    </div>
                            -->
                            <!--
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" autocomplete="off"  placeholder="Регион" aria-label="Регион" name="region" id="region" aria-describedby="region_list">
                                                                    <div id="region_list"></div>

                                                            </div>
-->

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Регион" autocomplete="off" aria-label="Регион" name="region" id="region" aria-describedby="basic-addon9">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon9">Регион</span>
                                </div>
                            </div>





                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Город" aria-label="Город" name="city" id="city" aria-describedby="basic-addon10">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon10">Город</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <select class="custom-select" name="comment1" id="comment1">

                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Комментарий" aria-label="Комментарий" name="comment2" id="comment2" aria-describedby="basic-addon111">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon111">Комментарий</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Родственники" aria-label="Родственники" name="rodstvenniki" id="rodstvenniki" aria-describedby="basic-addon111">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon111">Родственники</span>
                                </div>
                            </div>


                            <div class="input-group mb-3">
                                <select class="custom-select" name="color1" id="color1">
                                    <!--
                                     <option selected value="">Выберите базовый цвет</option>
                                     <option value="Красный">Красный</option>
                                     <option value="Синий">Синий</option>
                                     <option value="Желтый">Желтый</option>
                                     <option value="Зеленый">Зеленый</option>
                                     -->
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <select class="custom-select" name="color2" id="color2">
                                    <!--
                                    <option selected value="">Выберите вторичный цвет</option>
                                    <option value="Красный">Красный</option>
                                    <option value="Синий">Синий</option>
                                    <option value="Желтый">Желтый</option>
                                    <option value="Зеленый">Зеленый</option>
                                    -->
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <select class="custom-select" name="reshenie" id="reshenie">
                                    <option selected value="">Выберите решение</option>
                                    <option value="Подумать">Подумать</option>
                                    <option value="Остаться">Остаться</option>
                                    <option value="Расторгнуть">Расторгнуть</option>
                                </select>
                            </div>
                            <div class="input-group mb-3" id="udergal1" style="display: none;">
                                <input type="text" class="form-control" placeholder="Как удержали" aria-label="Как удержали" name="udergal" id="udergal" aria-describedby="basic-addon12">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon12">Как удержали</span>
                                </div>
                            </div>

                            <div class="input-group mb-3" id="otkaz1" style="display: none;">
                                <input type="text" class="form-control" placeholder="Причина отказа" aria-label="Причина отказа" name="otkaz" id="otkaz" aria-describedby="basic-addon13">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon13">Причина отказа</span>
                                </div>
                            </div>


                            <input type="hidden" name="id_client" id="id_client" value="">
                            <input type="hidden" name="id_database" id="id_database" value="">
                            <input type="hidden" name="id_policy" id="id_policy" value="">
                            <input type="hidden" name="uniqueid" id="uniqueid" value="">
                            <input type="hidden" name="policyselect" id="policyselect" value="">

                             <input class="btn btn-primary" name="save" type="submit"   value="Сохранить">
                        </form>


                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Информация</div>
                    <div class="card-body">



                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Описание цвета
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">

                                        <table border="1" class="dcf-table dcf-table-responsive dcf-table-bordered dcf-table-striped dcf-w-100%">
                                            <caption></caption>
                                            <thead>

                                            <tr>
                                                <th scope="col" data-label="Красный">Красный</th>
                                                <th scope="col" data-label="Желтый">Желтый</th>
                                                <th scope="col" data-label="Синий">Синий</th>
                                                <th scope="col" data-label="Зеленый">Зеленый</th>
                                            </tr>

                                            </thead>
                                            <tbody>

                                            <tr>
                                                <td data-label="Красный"></td>
                                                <td data-label="Желтый"></td>
                                                <td data-label="Синий"></td>
                                                <td data-label="Зеленый"></td>
                                            </tr>


                                            <tr>
                                                <td data-label="Красный">Базовые страхи
                                                </td>
                                                <td data-label="Желтый"></td>
                                                <td data-label="Синий"></td>
                                                <td data-label="Зеленый"></td>
                                            </tr>


                                            <tr>
                                                <td data-label="Красный">Потеря ресурса </br>
                                                    Нарушение традиций</br>
                                                    Потеря контроля</br>
                                                    Неопределенность</br>
                                                    Беспорядок/хаос</td>
                                                <td data-label="Желтый">Лишение статуса</br>
                                                    Лишение ресурса</br>
                                                    Ограничение свободы</br>
                                                    Быть как все</br>
                                                    Логика</br>
                                                    Монотонность</br>
                                                    Труд (усилие)
                                                </td>
                                                <td data-label="Синий">Потеря цели</br>
                                                    Потеря времени</br>
                                                    Безответственность</br>
                                                    Потеря территории</br>
                                                    Низкая эффективность</td>
                                                <td data-label="Зеленый">Ответственность</br>
                                                    Риск</br>
                                                    Несостоятельность в глазах других</br>
                                                    Резкое и громкое
                                                </td>
                                            </tr>


                                            <tr>
                                                <td data-label="Красный">Базовые ценности
                                                </td>
                                                <td data-label="Желтый"></td>
                                                <td data-label="Синий"></td>
                                                <td data-label="Зеленый"></td>
                                            </tr>


                                            <tr>
                                                <td data-label="Красный">Удержание</br>
                                                    Накопление</br>
                                                    Контроль</br>
                                                    Безопасность</br>
                                                    Стабильность</br>
                                                    Традиции</br>
                                                    Порядок</br>
                                                    Процедуры</td>
                                                <td data-label="Желтый">Статус</br>
                                                    Новизна</br>
                                                    Разнообразие</br>
                                                    Свобода</td>
                                                <td data-label="Синий">Время</br>
                                                    Цель</br>
                                                    Эффективность</br>
                                                    Индивидуальность</br>
                                                    Ответственность</br>
                                                    Идеи</td>
                                                <td data-label="Зеленый">Миролюбие</br>
                                                    Благополучие</br>
                                                    Защищенность</br>
                                                    Социальная принадлежность</br>
                                                    Забота</br>
                                                    Идеалы</br>
                                                    Тонкая эстетика</td>
                                            </tr>


                                            <tr>
                                                <td data-label="Красный">Ценностные слова
                                                </td>
                                                <td data-label="Желтый"></td>
                                                <td data-label="Синий"></td>
                                                <td data-label="Зеленый"></td>
                                            </tr>


                                            <tr>
                                                <td data-label="Красный">Экономно</br>
                                                    Контроль</br>
                                                    Постоянство</br>
                                                    Стабильность</br>
                                                    Большинство</br>
                                                    Выгодный</br>
                                                    Весомый</br>
                                                    Конкретный</br>
                                                    Уверенность</br>
                                                    Эксперт</td>
                                                <td data-label="Желтый">Для вас</br>
                                                    Редкость</br>
                                                    Как хотите</br>
                                                    Легко</br>
                                                    Свободно</br>
                                                    Отличный</br>
                                                    Превосходный</br>
                                                    Особенный</br>
                                                    Уникальный
                                                </td>
                                                <td data-label="Синий">Индивидуальность</br>
                                                    Уверенность</br>
                                                    Своевременность</br>
                                                    Точность</br>
                                                    Выгода</br>
                                                    Результат</td>
                                                <td data-label="Зеленый">Защита</br>
                                                    Понимание</br>
                                                    Поддержка</br>
                                                    Комфортно</br>
                                                    Представьте</br>
                                                    Поможем</br>
                                                    Обеспечим</br>
                                                    Заботимся</br>
                                                    Аккуратно</br>
                                                    Вместе
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>



                                    </div>
                                </div>
                            </div>
                        </div>



                        <p class="card-text">
                            разное инфо {{date('H:i:s')}}
                        <p id="smsinfo"></p>
                        <p id="productinfo"></p>
                        <p id="clientinfochange"></p>
                        <p id="policyinfochange"></p>
                        </p>
                    </div>

                </div>
            </div>



        </div>
    </div>
@endsection
