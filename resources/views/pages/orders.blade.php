@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')
    
        <script type="text/javascript" src="{{asset('js/jscolor.js')}}"></script>
        
        <input type="hidden" name="userID" value="{{ $user->id }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-primary @role('admin', true) panel-info  @endrole">
                    <div class="panel-heading">
                      Orders
                    </div>

                    <div class="panel-body">
                        <div class="row" style="background:#3097d14d;">
                            <div class="col-md-1"><strong>Product Name</strong></div>
                            <div class="col-md-1"><strong>Price, QTY</strong></div>
                            <div class="col-md-2"><strong>Name/Phone/Email</strong></div>
                            <div class="col-md-2"><strong>Street</strong></div>
                            <div class="col-md-1"><strong>City</strong></div>
                            <div class="col-md-1"><strong>State</strong></div>
                            <div class="col-md-1"><strong>Zip</strong></div>
                            <div class="col-md-1"><strong>Country</strong></div>
                            <div class="col-md-1"><strong>Shipping Plan</strong></div>
                            <div class="col-md-1"><strong>Created</strong></div>
                        </div>
                        <?php $odd = false; ?>
                        @foreach($ordersActive as $order)
                            <div class="row" <?php if($odd == true){ echo 'style="background:#3097d14d;"'; } ?> >
                                <div class="col-md-1">{{$order->productName}}</div>
                                <div class="col-md-1">{{$order->price}}, x{{$order->qty}}</div>
                                <div class="col-md-2">{{$order->firstName}} {{$order->lastName}}
                                    <br>
                                    <strong>phone1:</strong>{{$order->phone1}}
                                    <br> <strong>phone2:</strong>{{$order->phone2}}
                                    <br><strong>Email:</strong>{{$order->email}}
                                </div>
                                <div class="col-md-2">{{$order->streetAddress}}</div>
                                <div class="col-md-1">{{$order->city}}</div>
                                <div class="col-md-1">{{$order->state}} {{$order->customState}}</div>
                                <div class="col-md-1">{{$order->zip}}</div>
                                <div class="col-md-1">{{$order->country}}</div>
                                <div class="col-md-1">
                                
                                    @foreach($shippingPlans as $plan)
                                        @if($plan->id == $order->shippingPlan)
                                            {{$plan->name}} - {{$plan->price}}
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-md-1">{{$order->created}}</div>
                            </div>

                            <?php if($odd == false){$odd = true;}else{$odd = false;} ?>

                        @endforeach
                    </div>
                   

                    </div>
                </div>


            </div>
            
        </div>


    </div>

    




@endsection

@section('footer_scripts')

    @include('scripts.updateBackgroundDZ')


@endsection