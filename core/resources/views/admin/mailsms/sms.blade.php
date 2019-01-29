@extends('admin.layout.master')

@section('body')
	<div class="page-content-wrapper">
		<div class="page-content">

			<h3 class="page-title uppercase bold"> {{$page_title}}

			</h3>
			<hr>
			<div class="portlet light bordered">
				<div class="portlet-title green">
					<div class="caption font-dark">
						<i class="icon-settings font-dark"></i>
						<span class="caption-subject bold uppercase">SMS Template</span>
					</div>
					<div class="tools"></div>
				</div>
				<div class="portlet-body">
					<div class="table-scrollable">
						<table class="table table-striped table-hover">
							<thead>
							<tr>
								<th> # </th>
								<th> CODE </th>
								<th> DESCRIPTION </th>
							</tr>
							</thead>
							<tbody>


							<tr>
								<td> 1 </td>
								<td> <pre>&#123;&#123;message&#125;&#125;</pre> </td>
								<td> Details Text From Script</td>
							</tr>

							<tr>
								<td> 2 </td>
								<td> <pre>&#123;&#123;number&#125;&#125;</pre> </td>
								<td> Users Number. Will Pull From Database</td>
							</tr>



							</tbody>
						</table>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-envelope font-blue-sharp"></i>
								<span class="caption-subject font-blue-sharp bold uppercase">SMS Api</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form role="form" method="POST" action="{{route('sms.update')}}" >
								{{ csrf_field() }}
								<div class="form-body">
									<div class="form-group">
										<label>SMS API</label>
										<input type="text" name="smsapi" id="smsapi" class="form-control" value="{{$temp->smsapi}}">
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn green btn-block btn-lg">Update</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>






	
	@endsection

@section('js')
	<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
	<script type="text/javascript">
        new nicEditor().panelInstance('smsapi');
	</script>
@stop