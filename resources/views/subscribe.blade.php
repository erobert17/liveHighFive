
@extends('layouts.app')

@section('template_title')
    See Message
@endsection

@section('head')
@endsection



<div class="modal fade modal-danger" id="cancelSubscription" style="margin-top: 6em;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="padding: 3em;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Confirm Cancel Subscription</h4>
        </div>
        <div class="modal-body">
          <p>If you continue your existing subscription will end at the end of the current billing month.</p>
        </div>
        <div class="modal-footer">
          {!! Form::button('<i class="fa fa-fw fa-close" aria-hidden="true"></i> Never Mind', array('class' => 'btn btn-outline pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
          <a href="/cancel"><button class="btn btn-danger pull-right btn-flat" type="button" id="confirm"><i class="fa fa-fw fa-trash-o" aria-hidden="true"></i> Cancel Your Subscription</button></a>
        </div>
      </div>
    </div>
  </div>


@section('content')

 <div class="container">

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="panel panel-primary @role('admin', true) panel-info  @endrole">
             
            @if( isset($canceled) )
              <div class="alert alert-warning">
                <span class="glyphicon glyphicon-record"></span> <strong>Warning</strong>
                <hr class="message-inner-separator">
                <p>Your subscription has been canceled. It will stay active until the end of the current billing cycle.</p>
              </div>
            @endif

            @if( !isset($subscribed) || $subscribed == false )<!-- never subscribed -->
              
              <div class="panel-heading">
                Time to Subscribe
              </div>

                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="padding-top:1em;">
                    <label>Select a subscription type</label>
                    <p>You can currently access <strong><a href="/allLandingPages">your landing page</a></strong> and get it setup but, your land page link will only work for others after you're subscribed.</p>
                  </div>
                  <div class="col-md-1"></div>
                </div>

                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-5 vert-offset-top-1" style="padding-bottom:1em;">
                  
                  <select class="form-control subscription" style="min-height: 3em;">
                    <?php $optionNumber = 1; ?>
                    @foreach($subscriptionTypes as $types)
                      <option class="price" value="{{$optionNumber}}">${{$types->price}} / {{$types->period}} ({{$types->pagesText}})</option>
                      <?php $optionNumber++;?>
                    @endforeach
                  </select>

                  <div class="col-md-5"></div>

                  </div>
                  <div class="col-md-1"></div>
                </div>

                <?php $optionNumber = 1; ?>
                  @foreach($subscriptionTypes as $types)
                    <?php $price = str_replace('.', '', $types->price); ?>
                    @if($optionNumber == 1)
                      <div class="row paymentDiv" id="{{$optionNumber}}" >
                    @else
                      <div class="row paymentDiv" id="{{$optionNumber}}" style="display:none;">
                    @endif
                      <?php
                      $dollars = str_replace('$', '', $types->price);  // get rid of the dollar sign
                      $cents_as_float = $dollars * 100;  // multiply by 100 (it becomes float)
                      $cents_as_string = (string) $cents_as_float;  // convert float to string
                      $cents = (int) $cents_as_string;  // convert string to integer
                      ?>
                      <div class="col-md-1"></div>
                      <div class="col-md-10">
                        <form action="/subscribe" method="POST">
                          {{ csrf_field() }}
                          <input type="hidden" name="price" value="{{$types->price}}">
                          <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="pk_test_TouVQvnhSUNrSVZyk56ROjhG"
                            data-name="Growyourleads.com"
                            data-description="{{$types->period}} subscription"
                            data-amount="{{$cents}}"
                            data-email="{{ $user->email }}"
                            data-locale="auto">
                          </script>
                        </form>
                      </div>
                      <div class="col-md-1"></div>
                    </div>
                    <?php $optionNumber++;?>
                  @endforeach

                  <script type="text/javascript">
                    $(document).ready(function(){
                      
                      //automatically hide all buttons

                      $('.subscription').on('change', function(){
                        $('.paymentDiv').each(function(){
                          $(this).css('display', 'none');
                        })
                       
                        var optionValue = $(this).val();
                        $('#'+optionValue).css('display','block');

                      });

                    });
                  </script>
                <!--
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-10 vert-offset-top-1" style="padding-bottom:1em;">
                    <p>A monthly subscription of $9.99 will activate your landing page link so others can access it.</p>
                    <p>You can currently access <strong><a href="/allLandingPages">your landing page</a></strong> and get it setup but, your land page link will only work for others after you're subscribed.</p>
                    <br>
                    <form action="/subscribe" method="POST">
                      {{ csrf_field() }}
                      <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="pk_test_TouVQvnhSUNrSVZyk56ROjhG"
                        data-name="Andrew's Boilerplate App"
                        data-description="Premium Monthly Subscription"
                        data-amount="999"
                        data-email="{{ $user->email }}"
                        data-locale="auto">
                      </script>
                    </form>
                  </div>
                  <div class="col-md-1"></div>
                </div>
              -->


            @else<!-- either subscribed or grace -->
              <div class="panel-heading">
                  Manage Your Subscription
                </div>

                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-10 vert-offset-top-1" style="padding-bottom:1em;">
                    
                    @if($grace == true && $freeTrial == false)
                      <p>***Your subscription has been canceled***</p>
                      @if($endsAt != null)
                        <p>This will take affect at the end of the current billing cycle({{$endsAt}}).</p>
                      @else
                        <p>This will take affect at the end of the current billing cycle.</p>
                      @endif
                    @elseif($freeTrial == true)
                      <p>You are on a free trial that ends {{$endsAt}}.</p>
                    @else
                      <p>You are currently subscribed for your custom landing page.</p>
                      <p>Your subscription is ${{$price}} {{$term}}.</p>
                    
                      <button type="button" class="btn btn-danger" onclick="showCancelModal()">Cancel Your Subscription</button>
                      <script type="text/javascript">
                      function showCancelModal(){
                        $('#cancelSubscription').modal('show');
                      }
                      </script>
                    @endif
                    
                  </div>
                  <div class="col-md-1"></div>
                </div>

            @endif
          </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>


@endsection

