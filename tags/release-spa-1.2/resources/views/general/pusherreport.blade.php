@extends("common.default")

@section('breadcrumbs', Breadcrumbs::render('pusherReport'))

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3 ">
                @include('admin/leftSidebar')
            </div>
            <div class="col-md-9 equal_to_sidebar_mrgn">
                <h3>Pusher Report</h3>
                <div>
                    <table id="grid">

                        <thead>
                        <tr>
                            <th>Pusher ID</th>
                            <th>Name</th>
                            <th>Pusher Email</th>
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
                        @if(isset($pushers) && !empty($pushers))
                            @foreach($pushers as $pusher)
                                <tr>
                                    <td>{{$pusher->MC_ID}}</td>
                                    <td>{{$pusher->name}}</td>
                                    <td>{{$pusher->MC_Email}}</td>
                                    <td>{{$pusher->target_revenue}}</td>
                                    <td>{{$pusher->commission}}</td>
                                    <td>{{$pusher->bonus}}</td>
                                    <td>{{$pusher->Relationship_Analysis}}</td>
                                    <td>{{$pusher->brand}}</td>
                                    <td>{{$pusher->Since_Sale}}</td>
                                    <td>{{$pusher->YTD_Sale}}</td>
                                    <td>{{$pusher->revenue}}</td>
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