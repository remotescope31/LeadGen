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
               $(document).ready(function(){
                   $("#newclient").click(function(){
                       //alert("The paragraph was double-clicked.");

                       $("#fio").attr('readonly', true); // Disable it.

                   });
               });
           </script>
           <script>
               $(document).ready(function(){
                   $("#basic-addon6").dblclick(function(){

                       var phone = $('#numberphone').val();;

                       // AJAX request
                       $.ajax({
                           url: '{{ url('search_phone') }}',
                           type: 'get',
                           data: {phone: phone},
                           success: function(response){
                               // Add response in Modal body
                               $('.modal-body').html(response);

                               // Display Modal
                               $('#empModal').modal('show');
                           }
                       });


                   });
               });
           </script>

           <!-- Modal -->
           <div class="modal fade" id="empModal" role="dialog">
               <div class="modal-dialog">

                   <!-- Modal content-->
                   <div class="modal-content">
                       <div class="modal-header">
                           <h4 class="modal-title">User Info</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                       </div>
                       <div class="modal-body">

                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       </div>
                   </div>
               </div>
           </div>



















           <div class="row container">
            <div class="col-md-8 ">




                <div class="card">
                    <div class="card-header">Admi Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <button type="button" class="btn btn-primary" id="newclient" name="newclient">?????????? ????????????</button>
                            <button type="button" class="btn btn-secondary">????????????????</button>
                    </br></br>



                            <form  action="" method="post">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="?????? ??????????????" aria-label="?????? ??????????????" name="fio" id="fio" aria-describedby="basic-addon2" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">?????? ??????????????</span>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="???????? ????????????????" aria-label="???????? ????????????????" name="datebirthd" id="datebirthd" aria-describedby="basic-addon3" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon3">???????? ????????????????</span>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="?????????? ????????????" aria-label="?????????? ????????????" name="numberpolicy" id="numberpolicy" aria-describedby="basic-addon4">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon4">?????????? ????????????</span>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="???????? ????????????" aria-label="???????? ????????????" name="datepolicy" id="datepolicy" aria-describedby="basic-addon5">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon5">???????? ????????????</span>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="?????????? ????????????????" aria-label="?????????? ????????????????" name="numberphone" id="numberphone" aria-describedby="basic-addon6">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon6">?????????? ????????????????</span>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="?????????? ??????????????????????" aria-label="?????????? ??????????????????????" name="summstrah" id="summstrah" aria-describedby="basic-addon7">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon7">?????????? ??????????????????????</span>
                                    </div>
                                </div>


                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="?????????? ??????????????" aria-label="?????????? ??????????????" name="summkred" id="summkred" aria-describedby="basic-addon8">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon8">?????????? ??????????????</span>
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
                                                                    <input type="text" class="form-control" autocomplete="off"  placeholder="????????????" aria-label="????????????" name="region" id="region" aria-describedby="region_list">
                                                                        <div id="region_list"></div>

                                                                </div>
   -->

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="????????????" autocomplete="off" aria-label="????????????" name="region" id="region" aria-describedby="basic-addon9">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon9">????????????</span>
                                    </div>
                                </div>





                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control" placeholder="??????????" aria-label="??????????" name="city" id="city" aria-describedby="basic-addon10">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text" id="basic-addon10">??????????</span>
                                                                    </div>
                                                                </div>

                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control" placeholder="??????????????????????" aria-label="??????????????????????" name="comment" id="comment" aria-describedby="basic-addon11">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text" id="basic-addon10">??????????????????????</span>
                                                                    </div>
                                                                </div>



                                                                <input class="btn btn-primary" type="submit" value="??????????????????">

                                                            </form>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
@endsection
