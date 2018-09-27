@extends("common.default")
@section("content")
<style>
.cont{
    padding:0;
    width:500px;
}
.col_md{
    width:500px;
    border:1px solid white;
}
@media only screen and (device-width: 768px){
    .cont{
        width:100%;
    }
    .col_md{
        width:100%;
    }
}
@media (min-width: 481px) and (max-width: 767px) {
.cont{
        width:100%;
    }
     .col_md{
        width:100%;
    }
}
@media (min-width: 320px) and (max-width: 480px) {
.cont{
        width:100%;
    }
     .col_md{
        width:100%;
    }
}
@media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) 
and (orientation : landscape) { 
.cont{
        width:100%;
    }
}
</style>
<body>
{!! $content !!}
</body>
@stop