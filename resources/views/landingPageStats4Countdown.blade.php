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
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <div class="bg-success top_cards">
                    <div class="row icon_margin_left">
                        <div class="col-lg-5  col-5 icon_padd_left">
                            <div class="float-left">
                                <span class="fa-stack fa-sm">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-eye fa-stack-1x fa-inverse text-success visit_icon"></i>
                                </span>
                            </div>
                        </div>
                    <div class="col-lg-7 col-7 icon_padd_right">
                        <div class="float-right cards_content">
                            <span class="number_val" id="visitors_count">{{ $views }}</span><i class="fa fa-long-arrow-up fa-2x"></i>
                            <br>
                            <span class="card_description">Page Views</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="bg-mint top_cards">
                    <div class="row icon_margin_left">
                        <div class="col-lg-5  col-5 icon_padd_left">
                            <div class="float-left">
                                <span class="fa-stack fa-sm">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-user fa-stack-1x fa-inverse text-mint visit_icon"></i>
                                </span>
                            </div>
                        </div>
                    <div class="col-lg-7 col-7 icon_padd_right">
                        <div class="float-right cards_content">
                            <span class="number_val" id="visitors_count">{{ count($leads) }}</span><i class="fa fa-long-arrow-up fa-2x"></i>
                            <br>
                            <span class="card_description">Leads</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Landing Page Leads (People who have entered their info)                          
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <thead>
                                    <tr>
                                        
                                        <th class="">Email</th>
                                        
                                        
                                        
                                        <th class="">Created</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leads as $lead)
                                        <tr>
                                            
                                            <td class=""><a href="mailto:{{ $user->email }}" title="email {{ $user->email }}">{{ $lead->email }}</a></td>
                                          
                                            
                                            
                                            <td class="hidden-xs hidden-md">{{$lead->date}}</td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="/lp4Output">
                                <button class="btn btn-primary">Download Spreadsheet</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')

  
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    {{--
        @include('scripts.tooltips')
    --}}
@endsection
