@extends('frontend.layouts.default')
@section('title', __('Profil Saya'))
@section('content')

<div class="container account-container custom-account-container mt-5">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3 order-0">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <!-- Profile Image - Centered & Circular -->
                    <div class="profile-img-container">
                        <img src="{{ asset('user2.png') }}" class="profile-img">
                    </div>
                    <h5 class="mt-2">{{ $detailData->nama }}</h5>
                    <ul class="nav flex-column mt-3">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#edit" role="tab">Akun Saya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#address" role="tab">Alamat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="{{ URL::to('logout-user') }}">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="col-lg-9 order-lg-last order-1">
            <div class="tab-content">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
                @endif

                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        @if(session('success'))
                            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                            toast.show();
                        @endif
                    });
                </script>
                <!-- Profile Edit Section -->
                <div class="tab-pane fade show active" id="edit" role="tabpanel">
                    <div class="card shadow-sm border-0 p-4">
                        <h4 class="mb-3"><i class="icon-user"></i> Profil Saya</h4>
                        <form action="{{ URL::to('update-profile') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" value="{{ $detailData->nama }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $detailData->email }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>No Telepon</label>
                                <input type="text" class="form-control" name="no_telp"
                                    value="{{ $detailData->no_telp }}" required>
                            </div>

                            <!-- Password Change Section -->
                            <div class="password-section mt-4">
                                <h5 class="text-uppercase">Ubah Kata Sandi</h5>
                                <div class="form-group">
                                    <label>Kata Sandi Saat Ini</label>
                                    <input type="password" class="form-control" name="acc-password">
                                </div>
                                <div class="form-group">
                                    <label>Kata Sandi Baru</label>
                                    <input type="password" class="form-control" name="newPassword">
                                </div>
                                <div class="form-group">
                                    <label>Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" class="form-control" name="confirmNewPassword">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark btn-block mt-3">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>

                <!-- Address Edit Section -->
                <div class="tab-pane fade" id="address" role="tabpanel">
                    <div class="card shadow-sm border-0 p-4">
                        <h4 class="mb-3"><i class="sicon-location-pin"></i> Alamat Saya</h4>
                        <form action="{{ URL::to('update-alamat-profile') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Provinsi</label>
                                <select name="provinsi_id" id="provinsi_id" class="form-control" required onchange="fetchCities(this.value)">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach($provinsi as $vp)
                                    <option value="{{ $vp->id }}" @if(!empty($alamat) && $alamat->provinsi_id ==
                                        $vp->id) selected @endif>{{ $vp->province_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Kota/Kabupaten</label>
                                <select name="kota_id" id="city" class="form-control" required>
                                    <option value="">-- Pilih Kota --</option>
                                    @if(!empty($alamat))
                                    @foreach($kota as $vp)
                                    <option value="{{ $vp->id }}" @if($alamat->kota_id == $vp->id) selected @endif>{{
                                        $vp->city_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Alamat Lengkap</label>
                                <input type="text" class="form-control" name="alamat_lengkap"
                                    value="{{ $alamat->alamat_lengkap ?? '' }}" required>
                            </div>

                            <div class="form-group">
                                <label>Kode Pos</label>
                                <input type="text" class="form-control" name="kode_pos"
                                    value="{{ $alamat->kode_pos ?? '' }}" required>
                            </div>

                            <button type="submit" class="btn btn-dark btn-block mt-3">Simpan Alamat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- End .col-lg-9 -->
    </div><!-- End .row -->
</div><!-- End .container -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchCities(provinceID) {
        if(provinceID) {
            $.ajax({
                url: "{{ url('getCity') }}/" + provinceID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#city').empty();
                    $('#city').append('<option value="">-- Pilih Kota --</option>');
                    $.each(data, function(key, value) {
                        $('#city').append('<option value="'+ value.id +'">'+ value.city_name +'</option>');
                    });
                },
                error:function(err) {
                    console.log("Gagal memuat kota", err);
                }
            });
        } else {
            $('#city').empty();
            $('#city').append('<option value="">-- Pilih Kota --</option>');
        }
    }
</script>

<!-- Custom CSS -->
<style>
    /* Centering and Symmetric Profile Image */
    .profile-img-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    .profile-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        /* Ensures the image remains circular without distortion */
        border: 3px solid #ddd;
        /* Optional border */
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .profile-img {
            width: 80px;
            height: 80px;
        }
    }
</style>

@endsection