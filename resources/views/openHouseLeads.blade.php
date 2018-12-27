@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')
    


    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-primary @role('admin', true) panel-info  @endrole">
                    <div class="panel-heading">
                        Open Houses Landing Pages
                    </div>

                    <div class="panel-body">
                        
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="row">
                            <div class="col-md-12"><h4>Your Properties</h4></div>
                        </div>

                        @if(count($properties) > 0)
                          <div class="row margin1px bottomBorder1 bottomBorder1">
                                <div class="col-md-5">Address</div>
                                <div class="col-md-4">Property Link</div>
                                <div class="col-md-2">Messages</div>
                                <div class="col-md-1">Visits</div>
                          </div>
                        @endif
                        <div class="row vert-offset-bottom-1 margin1px">
                            <div class="col-md-12">
                              <?php $oddEven = 0;?>
                              @foreach($properties as $prop)
                                @if($oddEven == 0)
                                  <div class="row propertyRow">
                                    <?php $oddEven = 1;?>
                                @else
                                  <div class="row odd propertyRow">
                                    <?php $oddEven = 0;?>
                                @endif
                                  <div class="col-md-5 paddingTop6px"> {{substr($prop->address, 0 ,30)}}...</div>
                                  <div class="col-md-4"> 
                                  
                                  <a href="specificOpenHouesMessages/{{$prop->id}}">
                                    <button type="button"  class="btn btn-success">
                                      View Property Leads
                                    </button>
                                  </a>

                                    
                                  </div>
                                  <div class="col-md-2"> 
                                    <?php 
                                     $countMessages=0;
                                     foreach ($messages as $message) {
                                       if($message->propertyId == $prop->id)
                                       {
                                        $countMessages++;
                                       }
                                     }
                                     echo $countMessages;
                                     ?>
                                  </div>
                                  <div class="col-md-1"> 
                                    
                                     <?php 
                                     $countVisits=0;
                                     foreach ($visits as $visit) {
                                       if($visit->propertyId == $prop->id)
                                       {
                                        $countVisits++;
                                       }
                                     }
                                     echo $countVisits;
                                     ?>
                                  </div>
                                </div>
                                
                              @endforeach
                            </div>
                        </div>

                    </div><!-- Panel Body-->

                </div>


            </div>
            
        </div>


    </div>

    

@endsection

@section('footer_scripts')

    


@endsection