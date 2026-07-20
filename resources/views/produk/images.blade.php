@extends('layouts.default')
@section('title', __( 'Produk' ))
@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        @include('layouts.partials.notification')
                    </div>
                </div>
                <div class="card card-bordered card-preview" style="padding: 30px;">
                    <div class="card-inner">
                        <table class="table table-borderless">
                            <tr>
                                <td style="width:150px;" class="pl-0"><b>Nama Produk</b></td>
                                <td style="width:5px;">:</td>
                                <td>{{ $product->nama_produk }}</td>
                                <td></td>
                                <td></td>
                                <td><span><a href="#uploadModel" data-bs-toggle="modal" class="btn btn-primary"
                                            style="float: right;">Tambah Data <i class="menu-icon tf-icons bx bx-plus"
                                                style="margin-left: 5px;"></i></a></span></td>
                            </tr>
                        </table>
                        <hr>
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Image</th>
                                    <th>Is Thumbnail</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data AS $key => $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset('upload/produk/'.$value->gambar) }}" style="width:100px;">
                                    </td>
                                    <td>
                                        @if($value->is_thumbnails == 1)
                                        <i class="menu-icon tf-icons bx bx-check"></i> <b>Current Thumbnails</b>
                                        @else
                                        <a href="{{ URL::to('set-as-thumbnail/'.$value->id.'/'.$product->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="menu-icon tf-icons bx bx-check"></i> Set as Thumbnail
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ URL::to('delete-products-images/'.$value->id.'/'.$product->id) }}"
                                            class="btn btn-danger" onclick="return confirm('Are you sure.?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" id="uploadModel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <i class="menu-icon tf-icons bx bx-x" style="font-size:2.5rem;float: right;"></i>
            </a>
            <div class="modal-body">
                <form method="POST" action="{{ URL::to('do-upload-images/'.$product->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="imageInput">Images</label>
                        <input type="file" class="form-control" id="imageInput" name="images[]" multiple
                            accept="image/*">
                    </div>
                    <div id="imagePreviewContainer"></div>
                    <br>
                    <div id="croppedImagePreview"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="cropAndUploadImages()">Crop and
                            Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Cropper.js CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<!-- Cropper.js JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script type="text/javascript">
    let croppers = {};  // Object to hold multiple cropper instances
    let imagePreviewContainer = document.getElementById('imagePreviewContainer');
    let croppedImagePreviewContainer = document.getElementById('croppedImagePreview');

    document.getElementById('imageInput').addEventListener('change', function(event) {
        let files = event.target.files;
        imagePreviewContainer.innerHTML = ''; // Clear previous previews
        croppers = {}; // Reset croppers

        if (files.length === 0) return;

        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            if (file && file.type.startsWith('image/')) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let previewWrapper = document.createElement('div');
                    previewWrapper.classList.add('image-preview-wrapper');

                    let image = document.createElement('img');
                    image.src = e.target.result;
                    image.classList.add('preview-image');

                    let cropContainer = document.createElement('div');
                    cropContainer.classList.add('crop-container');
                    cropContainer.appendChild(image);
                    previewWrapper.appendChild(cropContainer);
                    imagePreviewContainer.appendChild(previewWrapper);

                    let cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 1,
                        scalable: true,
                        cropBoxResizable: true
                    });

                    croppers[file.name] = cropper;
                };
                reader.readAsDataURL(file);
            }
        }
    });

    function cropAndUploadImages() {
        let formData = new FormData();
        let files = document.getElementById('imageInput').files;
        
        if (Object.keys(croppers).length === 0) {
            alert('Silakan pilih gambar untuk di-crop terlebih dahulu.');
            return;
        }

        croppedImagePreviewContainer.innerHTML = ''; // Clear previous cropped images
        let promises = [];

        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            let cropper = croppers[file.name];

            if (cropper) {
                let canvas = cropper.getCroppedCanvas();

                if (canvas) {
                    let promise = new Promise(resolve => {
                        canvas.toBlob(function(blob) {
                            formData.append('cropped_images[]', blob, file.name);

                            // Display cropped images before uploading
                            let croppedImage = document.createElement('img');
                            croppedImage.src = URL.createObjectURL(blob);
                            croppedImage.classList.add('cropped-preview-image');
                            croppedImagePreviewContainer.appendChild(croppedImage);

                            resolve();
                        }, 'image/jpeg');
                    });

                    promises.push(promise);
                }
            }
        }

        Promise.all(promises).then(() => {
            formData.append('_token', '{{ csrf_token() }}');

            fetch("{{ URL::to('do-upload-images/'.$product->id) }}", {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (!response.ok) throw new Error('Upload gagal');
                location.reload();
                return response.json();
            })
            .then(data => {
                alert('Gambar berhasil di-upload');
                location.reload();
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
            });
        });
    }

    function more_images() {
        let moreImageContainer = document.createElement('div');
        moreImageContainer.classList.add('form-group');
        moreImageContainer.innerHTML = `
            <label>Images <a href="#" style="color:red;" onclick="remove_images(this)">[Remove]</a></label>
            <input type="file" class="form-control-file extra-image" name="images[]" accept="image/*">
        `;
        document.getElementById("imagePreviewContainer").appendChild(moreImageContainer);
    }

    function remove_images(element) {
        element.parentElement.parentElement.remove();
    }
</script>

<style>
    .image-preview-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
    }

    .crop-container {
        width: 100%;
        max-width: 250px;
        border: 1px solid #ccc;
        padding: 5px;
    }

    .preview-image {
        width: 100%;
        height: auto;
    }

    .cropped-preview-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin: 5px;
        border: 1px solid #ddd;
    }
</style>
@endsection