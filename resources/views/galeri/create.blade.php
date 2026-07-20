@extends('layouts.default')
@section('title', __( 'Tambah Galeri' ))
@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="title nk-block-title">Tambah Galeri</h4>
                        @include('layouts.partials.notification')
                    </div>
                </div>
                <div class="card card-bordered card-preview" style="padding: 30px;">
                    <div class="card-inner">
                        <div class="preview-block">
                            <form method="POST" action="{{ URL::to('/do-add-galeri') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Gambar</label>
                                            <div class="form-control-wrap">
                                                <input type="file" name="images[]" class="form-control" required placeholder="Input Nama Gedung">
                                            </div>
                                        </div>
                                        <div id="more_image"></div>
                                    </div>
                                    <div class="col-sm-12" style="margin-top: 15px;">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-warning" onclick="more_images()">Add More Image</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
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

<script type="text/javascript">
    no = 1;
    function more_images()
    {
        var _html_image = '<div id="image-col-'+no+'"><hr>\
        <div class="form-group">\
            <label>Images (<a href="#" style="color:red;" onclick="remove_images('+no+')">remove<a>)</label>\
            <input type="file" class="form-control-file" name="images[]" required="">\
        </div></div>';
        $("#more_image").append(_html_image);
        no+=1;
    }

    function remove_images(number)
    {
        $("#image-col-"+number).remove();
    }
</script>
@endsection