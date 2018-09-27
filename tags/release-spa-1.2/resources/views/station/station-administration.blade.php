@extends("common.default")

<!-- @section('breadcrumbs', Breadcrumbs::render('BuyerMgmt'))
 -->
 @section("content")
    <section class="">
        <!--Begin station Administration Container-->
        <div class="container">
            @include('admin/panelHeading')
            <div class="equal_to_sidebar_mrgn">
                <h2>Geographical Analysis</h2>
                <div id="map" class="row" style=" height: 600px"></div>

                <br>

                {!! Form::open(['class'=>'form','id'=>'google_map_form']) !!}
                <div class="col-md-4">
                    <label>Coordinate</label>
                    </br>
                    <div class="input-group input-group-sm">
                        <input required="required" class="form-control search-key" placeholder="Search"
                               name="search_key_word"
                               type="text">
                        <span class="input-group-btn">
                            <button type="button" value="coordinate" class="btn btn-default map-search"><span
                                        class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                    <br>
                    <label>Role</label>
                    </br>
                    <div class="input-group input-group-sm">
                        <select name="role" id="role" class="form-control country search-key">
                            <option value="station">Station</option>
                            <option value="merchant">Merchant</option>
                            <option value="both">Both</option>
                        </select>
                        <span class="input-group-btn">
                            <button type="button" value="role" class="btn btn-default map-search"><span
                                        class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                    <br>
                </div>
                <div class="col-md-4">
                    <label>Country</label>
                    </br>
                    <div class="input-group input-group-sm">
                        {!! Form::select('country',App\Models\Country::lists('name','code'), null, ['class'=>'form-control country search-key', 'id' => 'countries']) !!}
                        <span class="input-group-btn">
                            <button type="button" value="country" class="btn btn-default map-search"><span
                                        class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                    <br>
                    <label>City</label>
                    </br>
                    <div class="input-group input-group-sm">
                        {!! Form::select('city',App\Models\City::lists('name','state_code'), null, ['class'=>'form-control city search-key', 'id' => 'cities']) !!}
                        <span class="input-group-btn">
                            <button type="button" value="cities" class="btn btn-default map-search"><span
                                        class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                    <br>
                </div>
                <div class="col-md-4">
                    <label>State</label>
                    </br>
                    <div class="input-group input-group-sm">
                        {!! Form::select('states',App\Models\State::lists('name','code'), null, ['class'=>'form-control state search-key', 'id' => 'states']) !!}
                        <span class="input-group-btn">
                            <button type="button" value="state" class="btn btn-default map-search"><span
                                        class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                    <br>
                    <label>Area</label>
                    </br>
                    <div class="input-group input-group-sm">
                        {!! Form::select('area',App\Models\Area::lists('name','id'), null, ['class'=>'form-control areas search-key', 'id' => 'areas']) !!}
                        <span class="input-group-btn">
                            <button type="button" value="city" class="btn btn-default map-search"><span
                                        class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                    <div><br style="margin-bottom: 20px"></div>
                </div>
                {!! Form::close() !!}


                <table id="example" class="table table-bordered" cellspacing="0" width="100%" >
                    <thead style="background-color: rgba(189, 19, 18, 0.95); color: white">
                    <tr>
                        <th colspan="3">Station</th>
                        <th colspan="4">Sales</th>
                        <th colspan="3">Inventory</th>
                        <th colspan="3">Connection</th>
                        <th colspan="4">Geographical</th>
                        <th colspan="2">Distribution</th>
                    </tr>
                    <tr>
                        <th class="no-sort">No</th>
                        <th>&nbsp;Name</th>
                        <th>&nbsp;ID</th>
                        <th>Since</th>
                        <th>YTD</th>
                        <th>MTD</th>
                        <th>Monthly&nbsp;Average</th>
                        <th>Item</th>
                        <th>High&nbsp;&gt;30%</th>
                        <th>Low&nbsp;&lt;30%</th>
                        <th>Distributor</th>
                        <th>Active</th>
                        <th>Passive</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Area</th>
                        <th>D&nbsp;Address</th>
                        <th>DC&nbsp;Code</th>
                    </tr>
                    </thead>
                </table>
                <br><br>
            </div>
        </div>

    </section>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgjJ1IH8yzDhaEwNKD1RQEpSDU58V70LE"></script>
    <script>
        document.getElementById('states').disabled = true;
        document.getElementById('cities').disabled = true;
        document.getElementById('areas').disabled = true;

        $(document).ready(function () {

            //Getting Ajax end point
            var STATION_END_POINS = {
                getAreasByCountryURL: "{!!route('get-areas-by-country')!!}",
                getMapDataURL: "{!!route('get-map-data')!!}",
                getMapDataURLMerchant: "{!!route('get-map-data-merchant')!!}", 
				getMapDataURLBoth: "{!!route('get-map-data-both')!!}",
                getStaionsDataURL: "{!! route('get-stations-data-for-table') !!}",
                getMerchantsDataURL: "{!! route('get-merchants-data-for-table') !!}",
				getBothDataURL: "{!! route('get-both-data-for-table') !!}"
            };

            stationProcessor(STATION_END_POINS);

           // var div = $('#example').parents('div').first();
            //$(div).addClass('table-responsive');
            $('#example').wrap('<div class="col-xs-12 table-responsive" style="padding-left:0px"></div>');

            $('#countries').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#countries option:selected').text();
                    // $('#states_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/state',
                        data: {code: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            document.getElementById('states').disabled = false;
                            if (responseData != "") {
                                $('#states').html(responseData);
                                console.log(responseData);
                            }
                            else {
                                $('#states').empty();
                                // $('#select2-states-container').empty();
                            }
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-cities-container').empty();
                    $('#cities').html('<option value="" selected>Choose Option</option>');
                }
            });

            $('#states').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    //var text = $('#states option:selected').text();
                    //$('#states_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/city',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            document.getElementById('cities').disabled = false;
                            if (responseData != "") {
                                $('#cities').html(responseData);
                                console.log(responseData);
                            }
                            else {
                                $('#cities').empty();
                                // $('#select2-cities-container').empty();
                            }
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-cities-container').empty();
                    $('#cities').html('<option value="" selected>Choose Option</option>');
                }
            });

            $('#cities').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    // var text = $('#cities option:selected').text();
                    // $('#cities_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/area',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            document.getElementById('areas').disabled = false;
                            if (responseData != "") {
                                $('#areas').html(responseData);
                            }
                            else {
                                $('#areas').empty();
                                // $('#select2-areas-container').empty();
                            }
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-areas-container').empty();
                    $('#areas').html('<option value="" selected>Choose Option</option>');
                }
            });

        });

    </script>

    {{--Custom JS for Lable Marker on Google Map--}}
    <script src="{{asset('/js/custom-gmaps.js')}}"></script>
@stop
