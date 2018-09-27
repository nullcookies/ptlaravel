@extends("common.default")

 @section("content")
    <section class="">
        <!--Begin station Administration Container-->
        <div class="container">
            <div class="row">
            <div data-spy="scroll" style="display: none;" class="static-tab">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                    <div class="floor-directory">
                        
                    </div>
                </div>
                <div class="catlist col-sm-11 col-sm-offset-1">
                    <hr>
                    
                    

                
            <div class="col-md-12 equal_to_sidebar_mrgn">
                <h1>Google Map XXXX</h1>
                <div id="map" class="row" style=" height: 600px"></div>
    
                <br>

                {!! Form::open(['class'=>'form','id'=>'google_map_form']) !!}
                <div class="col-md-6">
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
                    <label>Country</label>
                    </br>

                    <div class="input-group input-group-sm">
                        {!! Form::select('country',App\Models\Country::lists('name','code'), null, ['class'=>'form-control country search-key']) !!}

                        <span class="input-group-btn">
                    <button type="button" value="country" class="btn btn-default map-search"><span
                                class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
                    </div>
                    <br>
                </div>
                <div class="col-md-6">
                    <label>State</label>
                    </br>
                    <div class="input-group input-group-sm">
                        <input required="required" class="form-control search-key" placeholder="Search"
                               name="search_key_word"
                               type="text">
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
                        <select class="form-control search-key area" name="area">
                            <option selected>Select an Area</option>
                        </select>
                <span class="input-group-btn">
                    <button type="button" value="city" class="btn btn-default map-search"><span
                                class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
                    </div>
                    <br>
                </div>

                {!! Form::close() !!}
    
                <table id="example" class="display" cellspacing="0" width="100%" style="font-size: 70%">
                    <thead style="background-color: rgba(189, 19, 18, 0.95); color: white">
                    <tr>
                        <th colspan="3">Station MASTER</th>
                        <th >FOOD</th>
                        <th >BHC</th>
                        <th colspan="6">FURNITURE</th>
                        <th colspan="3">Admin</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Station ID</th>
                        <th>Station Name</th>
                        <th>Area</th>
                        <th>Address</th>
                        <th>Co-ordinate</th>
                        <th>Shop size</th>
                        <th>Property Owner</th>
                        <th>Business Owner</th>
                        <th>Business Name</th>
                        <th>Type</th>
                        <th>INitiator</th>
                        <th>Capacity</th>
                        <th>Delivery</th>
                    </tr>
                    </thead>
                </table>

            </div>
                    </div>
        </div>
        </div>

    </section>
   
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgjJ1IH8yzDhaEwNKD1RQEpSDU58V70LE"></script>
    <script>

        $(document).ready(function () {

            //Getting Ajax end point
            var STATION_END_POINS = {
                getAreasByCountryURL: "{!!route('get-areas-by-country')!!}",
                getMapDataURL: "{!!route('get-map-data')!!}",
                getStaionsDataURL: "{!! route('get-stations-admin-data-for-table') !!}"
            };

            stationProcessor(STATION_END_POINS);


        });

    </script>

    {{--Custom JS for Lable Marker on Google Map--}}
    <script src="{{asset('/js/custom-gmaps.js')}}"></script>
@stop
