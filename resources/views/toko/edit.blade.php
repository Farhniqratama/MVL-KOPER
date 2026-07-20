@extends('layouts.default')
@section('title', __( 'Edit Toko' ))
@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="title nk-block-title">Edit Toko</h4>
                        @include('layouts.partials.notification')
                    </div>
                </div>
                <div class="card card-bordered card-preview" style="padding: 30px;">
                    <div class="card-inner">
                        <div class="preview-block">
                            <form method="POST" action="{{ URL::to('do-update-toko/'.$data->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Nama Toko</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="nama_toko" class="form-control" value="{{ $data->nama_toko }}" required placeholder="Input Nama Toko">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Cabang</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="cabang" class="form-control" value="{{ $data->cabang }}" required placeholder="Input Cabang">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">No Telepon</label>
                                            <div class="form-control-wrap">
                                                <input type="number" name="no_telp" class="form-control" value="{{ $data->no_telp }}" required placeholder="Input No Telepon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Alamat</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="alamat" class="form-control" value="{{ $data->alamat }}" required placeholder="Input Alamat">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="map" style="width: 100%; height: 500px;"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="default-01">Latitude</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="lat" id="lat" value="{{ $data->lat }}" placeholder="Input Lat" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="default-01">Longitude</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="lng" id="lng" value="{{ $data->lng }}" placeholder="Input Longitude" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" style="margin-top: 15px;">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function initialize() {
        // Creating map object
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: new google.maps.LatLng({{ $data->lat }}, {{ $data->lng }}),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        // creates a draggable marker to the given coords
        var vMarker = new google.maps.Marker({
            position: new google.maps.LatLng({{ $data->lat }}, {{ $data->lng }}),
            draggable: true
        });
        // adds a listener to the marker
        // gets the coords when drag event ends
        // then updates the input with the new coords
        google.maps.event.addListener(vMarker, 'dragend', function (evt) {
            $("#lat").val(evt.latLng.lat().toFixed(6));
            $("#lng").val(evt.latLng.lng().toFixed(6));
            map.panTo(evt.latLng);
        });
        // centers the map on markers coords
        map.setCenter(vMarker.position);
        // adds the marker on the map
        vMarker.setMap(map);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endsection