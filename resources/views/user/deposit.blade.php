@extends('user')
@section('content')
    @include('partials.breadcrumb')

    <section class="section-padding section-background section-bg-clr1" id="min-height-deposit">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                        @include('errors.error')
                </div>
            </div>

            <div class="row">
                @foreach($gates as $gate)
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">{{$gate->name}}</h4>
                            </div>
                            <div class="panel-body text-center bg-black">
                                <img src="{{asset('assets/images/gateway')}}/{{$gate->id}}.jpg" style="width:100%">
                            </div>
                            <div class="panel-footer bg-black bdr-top">
                                <button class="btn btn-primary btn-block bg-sky" data-toggle="modal"
                                        data-target="#depositModal{{$gate->id}}"><strong>Deposit Now</strong>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--Buy Modal -->
                    <div id="depositModal{{$gate->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Deposit via <strong>{{$gate->name}}</strong></h4>
                                </div>

                                <form method="post" action="{{route('deposit.data-insert')}}">
                                    <div class="modal-body">
                                        {{csrf_field()}}

                                        <input type="hidden" name="gateway" value="{{$gate->id}}">
                                        <label class="col-md-12"><strong style="text-transform: uppercase;">DEPOSIT
                                                AMOUNT</strong>
                                            <span class="">({{ $gate->minamo }} - {{$gate->maxamo }}
                                                ) {{$basic->currency}}
                                                <br>
                                                Charged {{ $gate->fixed_charge }} {{$basic->currency}}
                                                + {{ $gate->percent_charge }}
                                                %</span>
                                        </label>
                                        <hr/>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="amount" class="form-control input-lg"
                                                       id="amount"
                                                       placeholder=" Enter Amount" required>
                                                <span class="input-group-addon">{{$basic->currency}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-danger " data-dismiss="modal">Close
                                        </button>
                                        <button type="submit" class="btn btn-primary ">Preview</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        (function ($) {
            $(window).on('resize', function () {
                var bodyHeight = $(window).height();
                $('#min-height-deposit').css('min-height', parseInt(bodyHeight) - 650);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-deposit').css('min-height', parseInt(bodyHeight) - 650);
            console.log(bodyHeight)


        }(jQuery))
    </script>
@stop