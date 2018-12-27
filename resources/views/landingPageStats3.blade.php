@extends('layouts.app')

@section('template_title')
  Showing Users
@endsection

@section('template_linked_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }

    </style>
@endsection

@section('content')
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/components.css')}}"/>
    
    <link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
    <!-- end of global styles-->
        <!--Plugin styles-->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/c3/css/c3.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/toastr/css/toastr.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/switchery/css/switchery.min.css')}}" />
    <!--page level styles-->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/pages/new_dashboard.css')}}"/>
    <div class="container">
    <div class="modal fade" id="message" role="dialog" style="padding-left: 15px; position: absolute; top: 14%; overflow: visible;">
        <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Showing Inquiry</h4>
        </div>
        <div class="modal-body">
          <h5 id="messageAuthor"></h5>
          <h5 id="messageEmail"></h5>
          <h5 id="messagePhone"></h5>
          <h5 id="messageDates">
            <span id="date1"></span> <br> <span id="date2"></span>
          </h5>
          <p id="modalMessage"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>
        <style type="text/css">
        .top_cards .fa-stack {
            font-size: 30px;
            padding: 17px 60px;
        }
        .fa-stack {
            position: relative;
            display: inline-block;
            width: 2em;
            height: 2em;
            line-height: 2em;
            vertical-align: middle;
        }
        </style>
        <div class="row">
           

            <div class="col-md-3" style="margin: auto;">
                <div class="bg-mint top_cards">
                    <div class="row icon_margin_left">
                        <div class="col-lg-5  col-5 icon_padd_left">
                            <div class="float-left">
                                <span class="fa-stack fa-sm">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-eye fa-stack-1x fa-inverse text-success visit_icon" style="color: #0fb0c0 !important;"></i>
                                </span>
                            </div>
                        </div>
                    <div class="col-lg-7 col-7 icon_padd_right">
                        <div class="float-right cards_content">
                            <span class="number_val" id="visitors_count">{{ count($messages) }}</span>
                            <i class="fa fa-eye fa-stack-1x fa-inverse text-success visit_icon"></i>
                            <br>
                            <span class="card_description">Leads</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style=" padding-bottom: 3em;">

                        <div style="float:left;">
                            Landing Page Leads (People who have entered their info)                          
                        </div>

                        <div style="float:right;color: #00c0ef;">
                            <a href="/landingPage3Stats"> Return To All Properties</a>             
                        </div>
                        
                    </div> 

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <thead>
                                    <tr>
                                        
                                        <th>Name</th>
                                        <th class="hidden-xs">Email</th>
                                        <th class="hidden-xs">Phone</th>
                                        <th class="hidden-xs">First Preferred Date</th>
                                        <th class="hidden-xs">Second Preferred Date</th>
                                        
                                        <th class="hidden-sm hidden-xs hidden-md">Time Sent</th>
                                        <th></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                        <tr>
                                            <td>{{$message->name}}</td>
                                            <td class="hidden-xs"><a href="mailto:{{ $message->email }}" title="email {{ $message->email }}">{{ $message->email }}</a></td>
                                            <td class="">{{$message->phone}}</td>
                                            <td class="hidden-xs">{{$message->firstDate}}</div>
                                                <td class="hidden-xs">{{$message->secondDate}}</div>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$message->timeStamp}}</td>
                                            
                                            @if(strlen($message->message) > 2)
                                                <td><button id="{{$message->id}}" class="viewButton btn btn-primary">View Message</button></td>
                                            @else
                                                No Message
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <script type="text/javascript">
        $(document).ready(function(){
            
            var messJson = JSON.stringify(<?php echo $smallMesssageArray; ?>);
            var messArray = JSON.parse(messJson);
            $('.viewButton').click(function(){
                var id = $(this).attr('id');//propertyId from button id
                for (var i = 0; i < messArray.length; i++) {
                    console.log(messArray[1]);
                    if( messArray[i]['id'] == id){
                        //alert('FOUND '+messArray[i]);
                        $('#messageAuthor').html('Name: '+messArray[i]['name']);
                        $('#messageEmail').html('Email: '+messArray[i]['email']);
                        $('#messagePhone').html('Phone: '+messArray[i]['phone']);
                        $('#messagePhone').html('Phone: '+messArray[i]['phone']);
                        $('#date1').html('Prefered Showing Date: '+messArray[i]['firstDate']);
                        $('#date2').html('Secondary Showing Date: '+messArray[i]['secondDate']);

                        
                        $('#modalMessage').html(messArray[i]['message']);
                        i = messArray.length +1;
                       $('#message').modal('show');

                    }
                };
            });
            
        });
    </script>

@endsection

@section('footer_scripts')


    {{--
        @include('scripts.tooltips')
    --}}
@endsection

