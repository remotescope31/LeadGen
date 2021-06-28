@extends('layouts.app')

@section('content')



    <script>
        var user;
        var group;


        ( function( factory ) {
            if ( typeof define === "function" && define.amd ) {

                // AMD. Register as an anonymous module.
                define( [ "../widgets/datepicker" ], factory );
            } else {

                // Browser globals
                factory( jQuery.datepicker );
            }
        }( function( datepicker ) {

            datepicker.regional.ru = {
                closeText: "Закрыть",
                prevText: "&#x3C;Пред",
                nextText: "След&#x3E;",
                currentText: "Сегодня",
                monthNames: [ "Январь","Февраль","Март","Апрель","Май","Июнь",
                    "Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь" ],
                monthNamesShort: [ "Янв","Фев","Мар","Апр","Май","Июн",
                    "Июл","Авг","Сен","Окт","Ноя","Дек" ],
                dayNames: [ "воскресенье","понедельник","вторник","среда","четверг","пятница","суббота" ],
                dayNamesShort: [ "вск","пнд","втр","срд","чтв","птн","сбт" ],
                dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ],
                weekHeader: "Нед",
                dateFormat: "dd/mm/yy",
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: "" };
            datepicker.setDefaults( datepicker.regional.ru );

            return datepicker.regional.ru;

        } ) );
    </script>
    <script>
        function removeElement(e,name) {
            let button = e.target;
            let field = button.previousSibling;
            let div = button.parentElement;
            let br = button.nextSibling;
            div.removeChild(button);
            div.removeChild(field);
            div.removeChild(br);


            let allElements = document.getElementById(name);
            let inputs = allElements.getElementsByTagName("input");
            for(i=0;i<inputs.length;i++){
                inputs[i].setAttribute('id', name + (i+1));
                ///  inputs[i].setAttribute('value', (i+1));
                inputs[i].nextSibling.setAttribute('id', name+'r' + (i+1));
            }
        }

        function add(name,list) {





            let allElements = document.getElementById(name);
            let reqs_id = allElements.getElementsByTagName("select").length;

            reqs_id++;

            //create textbox
            let input = document.createElement('select');
            input.type = "select";
            input.setAttribute("class", "custom-select");
            input.setAttribute('id', name + reqs_id);
            input.setAttribute('name', name + reqs_id);
            //  input.setAttribute('value', reqs_id);
            input.innerHTML = list;

            let reqs = document.getElementById(name);


            //create remove button
            let remove = document.createElement('button');
            remove.setAttribute('id', name +'r' + reqs_id);
            var name=name;
            remove.onclick = function(e,$name) {
                //alert($name);
                removeElement(e,name);
            };
            remove.setAttribute("type", "button");
            remove.innerHTML = "Remove";

            //append elements
            reqs.appendChild(input);
            reqs.appendChild(remove);
            let br = document.createElement("br");
            reqs.appendChild(br);




        }





        $('body').on('click','#create_excel', function(){



            var page = "{{url('admin/report_agent_call_csv')}}?" + $('#report_agent').serialize();
            window.location = page;



        });








        $( function() {





            var dateFormat = "dd/mm/yy",
                from = $( "#from" )
                    .datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        numberOfMonths: 1

                    })
                    .on( "change", function() {
                        to.datepicker( "option", "minDate", getDate( this ) );
                    }),
                to = $( "#to" ).datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1
                })
                    .on( "change", function() {
                        from.datepicker( "option", "maxDate", getDate( this ) );
                    });

            function getDate( element ) {
                var date;
                try {
                    date = $.datepicker.parseDate( dateFormat, element.value );
                } catch( error ) {
                    date = null;
                }

                return date;
            }

        } );



        $(document).ready(function(){
            $('input').attr('autocomplete','off');



            $.ajax({
                url: '{{ url('search_user') }}',
                type: 'get',
                success: function(response){

                    user = response;
                }
            });
            $.ajax({
                url: '{{ url('search_group') }}',
                type: 'get',
                success: function(response){
                    group = response;

                }
            });



        });

        $(function(){
            $('#myFormSubmit').click(function(e){





                e.preventDefault();
                //  $('#formResults').text($('#report_agent').serialize());

                //
                $("#errorsms").html("");

                $.post('{{url('admin/report_agent_call_')}}',
                    $('#report_agent').serialize(),

                    function(data, status, xhr){



                        $("#formFinal").html(data.message);


                    },'json').done(function(data) {
                    $("#formFinal").html(data);
                });
            });



        });








    </script>

    <div class="container">

        <form id="report_agent" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label for="from">От</label>
            <input type="text" id="from" name="from">
            <label for="to">до</label>
            <input type="text" id="to" name="to">

            <div id="reqs">
                <h3>Операторы</h3>
                <button type="button" value="Add" onclick="javascript:add('reqs',user);">Add</button>
                <br>
            </div>



            <div id="group">
                <h3>Группы</h3>
                <button type="button" value="Add" onclick="javascript:add('group',group);">Add</button>
                <br>
            </div>


            <div id="timecall" class="summkred">
                <h3>Длительность разговора</h3>
                <input type="text" id="timecall_from" name="timecall_from">--<input type="text" id="timecall_to" name="timecall_to">
                <br>
            </div>



            <div>

                <button type="submit" id="myFormSubmit" class="btn btn-success" name="submit">Выбор</button>

            </div>


        </form>



        <p id="formResults"></p>
        <p id="formFinal"></p>



    </div>
@endsection
