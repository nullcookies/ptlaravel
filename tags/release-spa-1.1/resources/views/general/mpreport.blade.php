@extends("common.default")

@section('breadcrumbs', Breadcrumbs::render('mpReport'))

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3 ">
                @include('admin/leftSidebar')
            </div>
            <div class="col-md-9 equal_to_sidebar_mrgn">
                <h3>MP Report</h3>

                <div >
                    <table id="grid">

                        <thead>
                        <tr>
                            <th>MP ID</th>
                            <th>Name</th>
                            <th>MP Email</th>
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
                        @if(isset($mps) && !empty($mps))
                            @foreach($mps as $mp)
                                <tr>
                                    <td>{{$mp->MC_ID}}</td>
                                    <td>{{$mp->name}}</td>
                                    <td>{{$mp->MC_Email}}</td>
                                    <td>{{$mp->target_revenue}}</td>
                                    <td>{{$mp->commission}}</td>
                                    <td>{{$mp->bonus}}</td>
                                    <td>{{$mp->Relationship_Analysis}}</td>
                                    <td>{{$mp->brand}}</td>
                                    <td>{{$mp->Since_Sale}}</td>
                                    <td>{{$mp->YTD_Sale}}</td>
                                    <td>{{$mp->revenue}}</td>
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