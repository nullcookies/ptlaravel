@extends("common.default")

@section('breadcrumbs', Breadcrumbs::render('mcReport'))

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3 ">
                @include('admin/leftSidebar')
            </div>
            <div class="col-md-9 equal_to_sidebar_mrgn">
                <h3>MC Report</h3>
                <div >
                    <table id="grid">

                        <thead>
                            <tr>
                                <th>MC ID</th>
                                <th>Name</th>
                                <th>MC Email</th>
                                <th>Target Revenue</th>
                                <th>Commission</th>
                                <th>Bonus</th>
                                <th>Relationship Analysis</th>
                                <th>Brand</th>
                                <th>Since Sale</th>
                                <th>YTD Sale</th>
                                <th>Revenue</th>
                                <th>Item Clicked</th>
                                <th>Item Sold</th>
                                <th>Complaints</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($mcs) && !empty($mcs))
                                @foreach($mcs as $mc)
                                <tr>
                                    <td>{{$mc->MC_ID}}</td>
                                    <td>{{$mc->name}}</td>
                                    <td>{{$mc->MC_Email}}</td>
                                    <td>{{$mc->target_revenue}}</td>
                                    <td>{{$mc->commission}}</td>
                                    <td>{{$mc->bonus}}</td>
                                    <td>{{$mc->Relationship_Analysis}}</td>
                                    <td>{{$mc->brand}}</td>
                                    <td>{{$mc->Since_Sale}}</td>
                                    <td>{{$mc->YTD_Sale}}</td>
                                    <td>{{$mc->revenue}}</td>
                                    <td>{{$mp->item_clicked}}</td>
                                    <td>{{$mp->item_sold}}</td>
                                    <td>{{$mp->complaints}}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfooter>

                        </tfooter>
                    </table>
                </div>
            </div>{{--col-md-9 end--}}
        </div>{{--row end--}}
    </div> {{--container end--}}
@endsection