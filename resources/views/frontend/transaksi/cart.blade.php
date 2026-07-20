@extends('frontend.layouts.default')
@section('title', __( 'Cart' ))
@section('content')

<style>
    .empty-cart-container {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        padding: 50px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
        margin-bottom: 50px;
        /* Added space at the bottom */
    }

    .empty-cart-icon {
        font-size: 60px;
        color: #007bff;
        margin-bottom: 15px;
    }

    .empty-cart-text {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .empty-cart-subtext {
        font-size: 16px;
        color: #666;
        margin-bottom: 20px;
    }

    .empty-cart-btn {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
    }
</style>

<div class="container-fluid mt-7">
    <div class="row">
        <div class="col-lg-12">
            <div class="cart-table-container">
                @if(count($dataCart) > 0)
                <!-- Check if cart has data -->
                <table class="table table-cart">
                    <thead>
                        <tr>
                            <th class="thumbnail-col"></th>
                            <th class="product-col">Produk</th>
                            <th class="price-col">Harga</th>
                            <th class="qty-col">Quantity</th>
                            <th class="text-right">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($dataCart as $key => $value)
                        @php $total+= $value->harga * $value->qty; @endphp
                        <tr class="product-row">
                            <td>
                                <figure class="product-image-container">
                                    <a href="{{ URL::to('produk-detail/'.$value->produk_id) }}" class="product-image">
                                        <img src="{{ asset('upload/produk/'.$value->gambar) }}" alt="product"
                                            style="width:100px;">
                                    </a>
                                    <a href="{{ URL::to('delete-cart/'.$value->id) }}" class="btn-remove icon-cancel"
                                        title="Remove Product"></a>
                                </figure>
                            </td>
                            <td class="product-col" style="align-content: center;">
                                <h5 class="product-title">
                                    <a href="{{ URL::to('produk-detail/'.$value->produk_id) }}">{{ $value->nama_produk
                                        }}</a>
                                </h5>
                            </td>
                            <td style="align-content: center;">
                                <span class="amount" data-id="{{ $value->id }}" data-price="{{ $value->harga }}">
                                    <bdi><span>Rp </span>{{ number_format($value->harga, 0, ',', '.') }}</bdi>
                                </span>
                            </td>
                            <td style="align-content: center;">
                                <div class="quantity">
                                    <button class="quantity-minus qty-btn" data-id="{{ $value->id }}">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input type="number" class="qty-input" value="{{ $value->qty }}" min="1" max="99"
                                        data-id="{{ $value->id }}" readonly>
                                    <button class="quantity-plus qty-btn" data-id="{{ $value->id }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-right" style="align-content: center;">
                                <span class="total-payment" data-id="{{ $value->id }}"><bdi><span>Rp </span>{{
                                        number_format($value->harga * $value->qty, 0, ',', '.') }}</bdi></span>
                            </td>
                            <td class="text-right" style="align-content: center;">
                                <a href="{{ URL::to('delete-cart/'.$value->id) }}"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Checkout Button -->
                <div class="checkout-methods mt-4 mb-6" style="width: 100%;">
                    <a href="{{ URL::to('checkout') }}" class="btn btn-block btn-dark" style="font-weight: bold; padding: 15px;">Lanjut Checkout
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>

                @else
                <!-- Styled Empty Cart Section -->
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="empty-cart-container">
                        <i class="fas fa-shopping-cart empty-cart-icon"></i>
                        <p class="empty-cart-text">🛒 Your Cart is Empty</p>
                        <p class="empty-cart-subtext">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ URL::to('/') }}" class="btn btn-primary empty-cart-btn">Continue Shopping</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $(".quantity-minus").off("click").on("click", function (event) {
            event.preventDefault();

            const id = $(this).data("id");
            const input = $(`.qty-input[data-id="${id}"]`);
            let qty = parseInt(input.val()) || 0; 

            if (qty > 1) {
                qty -= 1; 
            }
            input.val(qty);
            const price = parseFloat($(`.amount[data-id="${id}"]`).data("price")) || 0;
            const newTotal = price * qty;
            $(`.total-payment[data-id="${id}"]`).text(formatRupiah(newTotal));
            updateQty(id, qty, newTotal);
        });

        $(".quantity-plus").off("click").on("click", function (event) {
            event.preventDefault();

            const id = $(this).data("id");
            const input = $(`.qty-input[data-id="${id}"]`);
            let qty = parseInt(input.val()) || 0; 
            if (qty < 99) {
                qty += 1; 
            }
            input.val(qty); 
            const price = parseFloat($(`.amount[data-id="${id}"]`).data("price")) || 0;

            const newTotal = price * qty;

            $(`.total-payment[data-id="${id}"]`).text(formatRupiah(newTotal));

            updateQty(id, qty, newTotal);
        });

        function updateQty(id, qty, total) {
            $.ajax({
                url: "{{ URL::to('update-quantity') }}", 
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    id: id,
                    qty: qty,
                    total: total
                },
                success: function (response) {
                    console.log("Quantity and total updated successfully!", response);
                },
                error: function (xhr) {
                    console.error("Error updating quantity", xhr.responseText);
                }
            });
        }

        function formatRupiah(angka) {
            return angka.toLocaleString("id-ID", { style: "currency", currency: "IDR" }).replace("IDR", "Rp ");
        }
    });
</script>

@endsection