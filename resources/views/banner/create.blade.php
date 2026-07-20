@extends('layouts.default')
@section('title', __( 'Tambah Banner' ))
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="title nk-block-title">Tambah Banner</h4>
                        @include('layouts.partials.notification')
                    </div>
                </div>
                <div class="card card-bordered card-preview" style="padding: 30px;">
                    <div class="card-inner">
                        <div class="preview-block">
                            <form id="bannerForm" method="POST" action="{{ URL::to('/do-add-banner') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Upload Banner</label>
                                            <div class="form-control-wrap">
                                                <input type="file" id="imageInput" class="form-control" accept="image/*"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <img id="preview" style="display:none;max-width: 100%; margin-top: 10px;"
                                            alt="Preview Image">
                                    </div>

                                    <div class="col-sm-12" style="margin-top: 15px;">
                                        <div class="form-group">
                                            <button type="button" id="cropButton"
                                                class="btn btn-secondary">Crop</button>
                                        </div>
                                    </div>

                                    <!-- Crop Image Area -->
                                    <div class="col-sm-12" id="cropArea" style="margin-top: 20px; display: none;">
                                        <img id="cropImage" style="width: 100%; max-height: 400px;" alt="Crop Image">
                                    </div>

                                    <!-- Save Crop -->
                                    <div class="col-sm-12" id="saveCropArea" style="margin-top: 20px; display: none;">
                                        <button type="button" id="saveCrop" class="btn btn-primary">Upload</button>
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

    // Display preview and initialize Cropper.js
    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                preview.style.display = 'none';

                // Set the image source for both preview and cropping
                preview.src = event.target.result;
                preview.style.display = 'block';
                cropImage.src = event.target.result;
                cropArea.style.display = 'block';
                saveCropArea.style.display = 'none';

                // Destroy existing cropper instance if any
                if (cropper) {
                    cropper.destroy();
                }

                // Initialize Cropper.js with high-quality settings
                cropper = new Cropper(cropImage, {
                    aspectRatio: 16 / 9,
                    viewMode: 1,
                    scalable: true,
                    zoomable: true,
                    responsive: true,
                    restore: false,
                    checkCrossOrigin: false,
                    checkOrientation: false,
                    imageSmoothingEnabled: true,  // Ensures smooth edges
                });
            };
            reader.readAsDataURL(file);
        }
    });

    // Crop Image & Maintain High Quality
    cropButton.addEventListener('click', () => {
        const canvas = cropper.getCroppedCanvas({
            width: 1920,  // Set high resolution width
            height: 1080, // Set high resolution height
            imageSmoothingEnabled: true, // Ensures better quality
        });

        saveCropArea.style.display = 'block';

        // Convert canvas to Blob to maintain quality
        canvas.toBlob((blob) => {
            const url = URL.createObjectURL(blob);
            preview.src = url;
        }, "image/jpeg", 1.0); // Maximum quality
    });

    // Save & Upload the Cropped Image
    saveCrop.addEventListener('click', () => {
        const croppedCanvas = cropper.getCroppedCanvas({
            width: 1920, // High resolution
            height: 1080,
            imageSmoothingEnabled: true,
        });

        croppedCanvas.toBlob((blob) => {
            const formData = new FormData();
            formData.append('image', blob, 'banner.jpg');
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ URL::to('/do-add-banner') }}', {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    window.location.href = '/banner';
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }, "image/jpeg", 1.0); // Ensuring maximum quality
    });
</script>



@endsection