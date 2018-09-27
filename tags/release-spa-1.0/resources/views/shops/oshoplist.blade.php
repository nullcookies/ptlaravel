@extends("common.default")

@section("content")
    <style>
        .brandlist ul {
            list-style:none;
        }
        .brandlist ul li {

        }

        .brandlist ul li a{
            color:#000;
        }
        .brandlist .custom-border {
            margin-top: 20px !important;
            margin-bottom: 20px !important;

            border-top: 1px solid #eeeeee !important;
            clear:both;
        }
    </style>
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">

                <div data-spy="scroll" class="static-tab" style="display: none;">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active"><a href="#AD">A-D</a></li>
                        <li role="presentation"><a href="#EH">E-H</a></li>
                        <li role="presentation"><a href="#IL">I-L</a></li>
                        <li role="presentation"><a href="#MP">M-P</a></li>
                        <li role="presentation"><a href="#QT">Q-T</a></li>
                        <li role="presentation"><a href="#UX">U-X</a></li>
                        <li role="presentation"><a href="#YZ">Y-Z</a></li>
                    </ul>
                </div>

                <div class="col-sm-11 col-sm-offset-1">
					{!! Breadcrumbs::renderIfExists() !!}
                    <p>&nbsp;</p>
                    <div id="all-floors">
                        <div class="brandlist">
                            <h1>O-Shops</h1>
                            <?php $count = 0; ?>
                            @foreach($merchants as $key => $merchant)
                                <?php $count++ ?>
                                    @if($firstLetter != substr(ucfirst($merchant->oshop_name), 0, 1))
                                        <?php $firstLetter =  substr(ucfirst($merchant->oshop_name), 0, 1); ?>
                                        @if(!$firstRun)
                                            </li>
                                            </ul>
                                            </div>
                                        @else
                                            <?php $firstRun = false ?>
                                        @endif

                                        <?php

                                        switch($firstLetter){
                                            case in_array($firstLetter, $letters['AD']):
                                                echo '<div id="AD" class="col-md-12">';
                                                break;
                                            case in_array($firstLetter, $letters['EH']):
                                                echo '<div id="EH" class="col-md-12">';
                                                break;
                                            case in_array($firstLetter, $letters['IL']):
                                                echo '<div id="IL" class="col-md-12">';
                                                break;
                                            case in_array($firstLetter, $letters['MP']):
                                                echo '<div id="MP" class="col-md-12">';
                                                break;
                                            case in_array($firstLetter, $letters['QT']):
                                                echo '<div id="QT" class="col-md-12">';
                                                break;
                                            case in_array($firstLetter, $letters['UX']):
                                                echo '<div id="UX" class="col-md-12">';
                                                break;
                                            case in_array($firstLetter, $letters['YZ']):
                                                echo '<div id="YZ" class="col-md-12">';
                                                break;
											default:
                                                echo '<div id="09" class="col-md-12">';
                                        }

                                        ?>
										<h3 style="text-align:left;margin-bottom:0">{{ $firstLetter }}</h3>
                                        <ul style="font-size:130%">
                                    @endif
                                        @if(!empty( $merchant->oshop_name ) )
                                                <li><a href="{{ route('oshop.one', [$merchant->id]) }}">{{ $merchant->oshop_name }}</a></li>
                                        @endif
                            @endforeach
                            <p>&nbsp;</p>
                            </li>
                            </ul>
                            </div>
                            <div class="custom-border"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
