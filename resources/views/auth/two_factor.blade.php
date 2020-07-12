@extends('layouts.app')

@section('content')
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-md-7 ">
                <img src="{{ url('img/'. 'login_vector.png') }}" style="width:500px;margin-top: 50px;">
            </div>
            <div class="col-5 pull-right" style="margin-right:-180px">
                <div class="" style="padding-bottom:50px; padding-top:30px">
                    <div style="display:flex; justify-content:center;"><img src="{{ url('img/'. 'login.png') }}" style="width:150px; border-radius: 50%;"></div>


                    <div class="card-body">

                        <form method="POST" action="{{ route('login.update',0) }}">
                            @csrf
                            {{ method_field('PUT') }}

                            <div class="row">
                                <div class="col">
                                    <center><b style="font-size: 25px;">Two Factor Authentication</b></center>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                </div>
                                <div class="col-10">
                                    <div style="font-size: 17px;font-family: 'Droid Sans Mono';color: rgba(0, 0, 0, 0.5)"><b>An 6-digit code has been sent to {{$contact}}</b></div>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-top:30px;">
                                <div class="col-2">
                                    <input type="hidden" value="{{$code}}" name="code"/>
                                    <input type="hidden" value="{{$contact}}" name="contact"/>
                                    <input  type="text" style="height: 40px;text-align: center" id="no_01" name="no_01" maxlength="1" class="form-control @error('number') is-invalid @enderror" autocomplete="off"  >
                                </div>
                                <div class="col-2">
                                    <input style="height: 40px;text-align: center" maxlength="1" type="text"  id="no_02" name="no_02" class="form-control @error('number') is-invalid @enderror" autocomplete="off"  >
                                </div>
                                <div class="col-2">
                                    <input  type="text" style="height: 40px;text-align: center" maxlength="1" id="no_03" name="no_03" class="form-control @error('number') is-invalid @enderror" autocomplete="off"  >
                                </div>
                                <div class="col-2">
                                    <input  type="text" style="height: 40px;text-align: center" maxlength="1" id="no_04" name="no_04" class="form-control @error('number') is-invalid @enderror" autocomplete="off"  >
                                </div>
                                <div class="col-2">
                                    <input  type="text" style="height: 40px;text-align: center" maxlength="1" id="no_05" name="no_05" class="form-control @error('number') is-invalid @enderror" autocomplete="off"  >
                                </div>
                                <div class="col-2">
                                    <input  type="text" style="height: 40px;text-align: center" maxlength="1" id="no_06" name="no_06" class="form-control @error('number') is-invalid @enderror" autocomplete="off"  >
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    @error('no_01')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                </div>
                                <div class="col-10">
                                    <div style="font-size: 17px;font-family: monospace;color: rgba(0, 0, 0, 0.3)"><b>This code will expire in <span class="countdown" style="color: red">5:00</span></b></div>
                                </div>
                            </div>

                            <div class="form-group row mb-0 " >
                                <div class="col float-right">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 20px;width: 100%">
                                        {{ __('Verify') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-jquery')
    <script>
        $(document).ready(function() {
            $('#no_01').focus()
            $("#no_01").on("keyup", function() {
                var value = $(this).val();
                if(value != null && value != ""){
                    $('#no_02').focus()
                }
            });
            $("#no_02").on("keyup", function() {
                var value = $(this).val();
                if(value != null && value != ""){
                    $('#no_03').focus()
                }else{
                    $('#no_01').focus()
                }
            });
            $("#no_03").on("keyup", function() {
                var value = $(this).val();
                if(value != null && value != ""){
                    $('#no_04').focus()
                }else{
                    $('#no_02').focus()
                }
            });
            $("#no_04").on("keyup", function() {
                var value = $(this).val();
                if(value != null && value != ""){
                    $('#no_05').focus()
                }else{
                    $('#no_03').focus()
                }
            });
            $("#no_05").on("keyup", function() {
                var value = $(this).val();
                if(value != null && value != ""){
                    $('#no_06').focus()
                }else{
                    $('#no_04').focus()
                }
            });
            $("#no_06").on("keyup", function() {
                var value = $(this).val();
                if(value != null && value != ""){

                }else{
                    $('#no_05').focus()
                }
            });

        });
        var timer2 = "5:00";
        var interval = setInterval(function() {


            var timer = timer2.split(':');
            //by parsing integer, I avoid all extra string processing
            var minutes = parseInt(timer[0], 10);
            var seconds = parseInt(timer[1], 10);
            --seconds;
            minutes = (seconds < 0) ? --minutes : minutes;
            if (minutes < 0) clearInterval(interval);
            seconds = (seconds < 0) ? 59 : seconds;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            //minutes = (minutes < 10) ?  minutes : minutes;
            $('.countdown').html(minutes + ':' + seconds);

            timer2 = minutes + ':' + seconds;
        }, 1000);
    </script>
@endsection
