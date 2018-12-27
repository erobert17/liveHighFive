@extends('layouts.app')

@section('template_title')
	{{ $user->name }}'s Profile
@endsection

@section('template_fastload_css')

	#map-canvas{
		min-height: 300px;
		height: 100%;
		width: 100%;
	}

@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading tableHeaderBlue">

						Account Settings

					</div>
					<div class="row vert-offset-top-2 vert-offset-bottom-2">
						<div class="col-md-2 col-md-offset-3">
							<strong>Your industries</strong>
							
						</div>

						<div class="col-md-4">
							<form mehtod="POST" action="/updateAccountSettings">
								@foreach($industries as $ind)
									@if(in_array($ind->number, $userIndustries) )

										<input type="checkbox" name="{{$ind->name}}" value="{{$ind->number}}" checked> {{$ind->name}}<br>
									@else
										<input type="checkbox" name="{{$ind->name}}" value="{{$ind->number}}"> {{$ind->name}}<br> 
									@endif

								@endforeach	
								<button type="submit" class="btn btn-success">Update</button>
							</form>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		

		</div>
	</div>
@endsection

@section('footer_scripts')

	@include('scripts.google-maps-geocode-and-map')

@endsection