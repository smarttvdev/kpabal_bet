@extends('user')
@section('content')
	<section class="section-padding section-background  ">
		<div class="container">

			<div class="row">
				<div class="col-md-8 col-md-offset-2">

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Deposit via {{$page_title}}</h3>
						</div>

						<div class="panel-body">

							<div  class="col-md-8 col-md-offset-2 text-center">
								<h6> PLEASE SEND EXACTLY <span> {{ $bitcoin['amount'] }}</span> BTC</h6>
								<h6>TO <span> {{ $bitcoin['sendto'] }}</span></h6>
								<br><br>
								{!! $bitcoin['code'] !!}
								<br><br>
								<h4 style="font-weight:bold;">SCAN TO SEND</h4>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>



@endsection