<!-- Modal layout -->
<div class="modal fade" id="Modal{{$modal_name}}" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog modal-lg" role="document" >

        <div class="modal-content">

            @include('popup.header')

            <div class="modal-body">

                @yield('modal-content')

            </div>

            @include('popup.footer')

        </div>

    </div>

</div>

@yield('modal-script')
