@extends('layouts.default')
@section('title', __( 'Edit Banner' ))
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="title nk-block-title">Edit Banner</h4>
                        @include('layouts.partials.notification')
                    </div>
                </div>
                <div class="card card-bordered card-preview" style="padding: 30px;">
                    <div class="card-inner">
                        <div class="preview-block">
                            <form method="POST" action="{{ URL::to('do-update-banner/'.$data->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Banner</label>
                                            <span style="color: red; font-size: 12px; font-weight: normal;margin-left: 20px;">*Fill in the fields below to change the banner</span>
                                            <div class="form-control-wrap">
                                                <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <img id="preview" style="display:none;max-width: 100%; margin-top: 10px;" alt="Preview Image">
                                    </div>

                                    <div class="col-sm-12" style="margin-top: 15px;">
                                        <div class="form-group">
                                            <button type="button" id="cropButton" class="btn btn-secondary">Crop</button>
                                        </div>
                                    </div>

                                    <!-- Crop Image Area -->
                                    <div class="col-sm-12" id="cropArea" style="margin-top: 20px; display: none;">
                                        <img id="cropImage" style="width: 100%; max-height: 400px;" alt="Crop Image">
                                    </div>

                                    <!-- Save Crop -->
                                    <div class="col-sm-12" id="saveCropArea" style="margin-top: 20px; display: none;">
                                        <button type="button" id="saveCrop" class="btn btn-primary">Save Changes</button>
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
    let cropper;
    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('preview');
    const cropImage = document.getElementById('cropImage');
    const cropArea = document.getElementById('cropArea');
    const saveCropArea = document.getElementById('saveCropArea');
    const saveCrop = document.getElementById('saveCrop');
    const cropButton = document.getElementById('cropButton');

    // Tampilkan gambar preview dan inisialisasi cropper
    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                // Sembunyikan preview sebelum gambar dipilih
                preview.style.display = 'none';

                // Tampilkan gambar hasil baca setelah file dipilih
                preview.src = event.target.result;
                preview.style.display = 'block';  // Menampilkan gambar preview

                cropImage.src = event.target.result; // Mengatur gambar untuk cropper
                cropArea.style.display = 'block';  // Menampilkan area crop
                saveCropArea.style.display = 'none'; // Sembunyikan tombol simpan sebelum crop

                // Hancurkan cropper lama jika ada
                if (cropper) {
                    cropper.destroy();
                }

                // Inisialisasi Cropper.js
                cropper = new Cropper(cropImage, {
                    aspectRatio: 16 / 9,
                    viewMode: 1,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    // Tampilkan tombol simpan setelah crop selesai
    cropButton.addEventListener('click', () => {
        const canvas = cropper.getCroppedCanvas({
            width: 800,  // Sesuaikan ukuran crop
            height: 450,
        });

        // Menampilkan tombol simpan setelah crop
        saveCropArea.style.display = 'block';

        // Gambar yang sudah dipotong
        canvas.toBlob((blob) => {
            const url = URL.createObjectURL(blob);
            preview.src = url;  // Menampilkan gambar hasil crop
        });
    });

    // Simpan dan upload gambar setelah crop
    saveCrop.addEventListener('click', () => {
        const croppedCanvas = cropper.getCroppedCanvas({
            width: 800,  // Sesuaikan ukuran crop
            height: 450,
        });
        croppedCanvas.toBlob((blob) => {
            const formData = new FormData();
            formData.append('image', blob, 'cropped.jpg');
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ URL::to('do-update-banner/'.$data->id) }}', {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    //alert('Image uploaded successfully!');
                    window.location.href = '/banner';
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });
    });

    function reloadpageto(page) {
        // Menavigasi ke URL dengan parameter 'banner'
        window.location.href = '/' + page;  // Misalnya: '/banner'
    }
</script>
@endsection