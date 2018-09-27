<?php 
use App\Http\Controllers\UtilityController;
?>
@extends("common.default")

@section('css')
    .paymentTable{ background : #30849B;  color : #fff; }
    .table-bordered > tbody > tr > td,
    table.dataTable tfoot th, table.dataTable tfoot td {
    padding: 10px 8px 6px 9px !important;
    border:none;
    }

    .paymentTable th { text-align : center !important }

    .modal-fullscreen{
    margin: 0;
    margin-right: auto;
    margin-left: auto;
    width: 95% !important;
    }
    @media (min-width: 768px) {
    .modal-fullscreen{
    width: 750px;
    }
    }
    @media (min-width: 992px) {
    .modal-fullscreen{
    width: 970px;
    }
    }
    @media (min-width: 1200px) {
    .modal-fullscreen{
    width: 1170px;
    }


@stop
{{--{{ dd($employees) }}--}}
@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                @include('admin/panelHeading')
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="main">
                    <div class="">
                        <div class="main-container">
                            <div class="row payment-area">
                                <div class="col-md-12">
                                    @if(Session::has('error_msg'))
                                        <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
                                    @elseif(Session::has('success_msg'))
                                        <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
                                    @endif
                                    {{-- Employee View Table --}}
                                    <h2>Payment: Employee</h2>
                                    <br>
                                    {!! Form::open(array('url'=>'/payemployee')) !!}
                                    <table class="table table-responsive" id='employeeTable' width="1340px">
                                        <thead>
                                        <tr class='paymentTable'>
                                            <th class='text-center bmedium'>Postion</th>
                                            <th class='text-center bmedium'>Status</th>
                                            <th class='text-center blarge'>Annual&nbsp;Income</th>
                                            <th class='text-center blarge'>Monthly&nbsp;Income</th>
                                            <th class='text-center bmedium'>-&nbsp;LHDN&nbsp;(PCB)</th>
                                            <th class='text-center bmedium'>-&nbsp;KWSP/EPF</th>
                                            <th class='text-center bmedium'>-&nbsp;SOCSO</th>
                                            <th class='text-center blarge' style="background-color: #000;">Outstanding</th>
											<th class='text-center blarge' style="background-color: #CCC;">Employer&nbsp;EPF</th>
											<th class='text-center blarge' style="background-color: #CCC;">Employer&nbsp;SOCSO</th>
                                        </tr>
                                        </thead>
                                        @if(isset($employees) and !is_null($employees))
                                            <tbody>
                                            @def $i = 1
                                            @for($w=0;$w<sizeof($employees[0]);$w++)
                                                <tr>
                                                    <td class='com text-center'>
                                                        {!! $employees[0][$w]->position !!}
                                                    </td>
													
                                                    <td class='pay text-center'>
                                                        {!! $employees[0][$w]->status !!}
                                                    </td>
                                                    <td>
                                                        <span class="pull-left">
                                                        {!! $employees[0][$w]->currency !!}
                                                        </span>
                                                        <span class="pull-right">
                                                        {!! number_format($employees[0][$w]->annual_income,2) !!}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="pull-left">
                                                        {!! $employees[0][$w]->currency !!}
                                                        </span>
                                                        <span class="pull-right">
                                                        {!! number_format($employees[0][$w]->monthly_income,2) !!}
                                                        </span>
                                                    </td>                                                        													
                                                    <td>
                                                        <span class="pull-left">
                                                        {!! $employees[0][$w]->currency !!}
                                                        </span>
                                                        <span class="pull-right">
 															@if(isset($employees[1][$w]['pcb']))
																{{number_format($employees[1][$w]['pcb'],2)}}
															@else 
																0.00
															@endif                                                        
                                                        </span>
                                                    </td>                                                    
													<td>
                                                        <span class="pull-left">
                                                        {!! $employees[0][$w]->currency !!}
                                                        </span>
                                                        <span class="pull-right">
 															@if(isset($employees[1][$w]['epf']))
																{{number_format($employees[1][$w]['epf'],2)}}
															@else 
																0.00
															@endif                                                        
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="pull-left">
                                                        {!! $employees[0][$w]->currency !!}
                                                        </span>
                                                        <span class="pull-right">
															@if(isset($employees[1][$w]['socso']))
																{{number_format($employees[1][$w]['socso'],2)}}
															@else 
																0.00
															@endif                                                         
                                                        </span>
                                                    </td>
                                                    <td class='text-center'>
                                                        <span class="pull-left">
                                                        {!! $employees[0][$w]->currency !!}
                                                        </span>
														<?php
															$eepf = 0;
															$esocso = 0;
															if(isset($employees[1][$w]['eepf'])){
																$eepf = $employees[1][$w]['eepf'];
															}
															if(isset($employees[1][$w]['esocso'])){
																$esocso = $employees[1][$w]['esocso'];
															}
															$outstanding = $employees[0][$w]->monthly_income - ($eepf + $esocso);
														?>
                                                        <span class="pull-right">
														{{ number_format($outstanding,2) }}
                                                        </span>                                                   
                                                    </td>
                                                    <td class="text-center">
                                                          <span class="pull-left">
                                                        {!! $employees[0][$w]->currency !!}
                                                        </span>
                                                        <span class="pull-right">
  															@if(isset($employees[1][$w]['epf']))
																{{number_format($employees[1][$w]['eepf'],2)}}
															@else 
																0.00
															@endif                                                         
                                                        </span>                                                        
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="pull-left">
                                                        {!! $employees[0][$w]->currency !!}
                                                        </span>
                                                        <span class="pull-right">
  															@if(isset($employees[1][$w]['esocso']))
																{{number_format($employees[1][$w]['esocso'],2)}}
															@else 
																0.00
															@endif                                                         
                                                        </span>                                                           
                                                    </td>												
                                                </tr>
                                            @endfor
                                            </tbody>
                                        @endif
                                    </table>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </div>

    <!-- Order Modal -->
    <div class="modal fade myModal" id="empModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='empClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>User Information</h3>
                    </h4>
                </div>
                <div class='modal-body'>

                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#employeeTable').DataTable({
                "scrollX": true,
				"columnDefs": [
					{"targets": "no-sort", "orderable": false},
					{"targets": "medium", "width": "80px"},
					{"targets": "large",  "width": "120px"},
					{"targets": "bsmall",  "width": "20px"},
					{"targets": "approv", "width": "180px"}, //Approval buttons
					{"targets": "blarge", "width": "200px"}, // *Names
					{"targets": "clarge", "width": "250px"},
					{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
				]
            });

            $('.emp_id').click(function(){
                $('body').css('padding','0px');
                var route = $(this).attr('data-val');
                $.ajax({
                    type : "GET",
                    url : route,
                    success : function(response){
                        $('#empModal').find('.modal-body').html(response);
                        $('#empModal').modal('show');
                    }
                })
            })
            $('table th:first').removeClass('sorting_asc');
        })
    </script>

    @yield('left_sidebar_scripts')
@stop

