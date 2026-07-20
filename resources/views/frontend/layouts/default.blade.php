<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Porto – Bootstrap eCommerce Template">
    <meta name="author" content="SW-THEMES">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('parfume') }}/assets/images/icons/favicon.png">
    <script>
        WebFontConfig = {
            google: {
                families: ['Open+Sans:300,400,600,700,800', 'Poppins:300,400,500,600,700']
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = '{{ asset("parfume") }}/assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('{{ asset('service-worker.js') }}')
                .then(() => console.log('Service Worker registered'))
                .catch((error) => console.log('Service Worker registration failed:', error));
        }
    </script>
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('parfume') }}/assets/css/bootstrap.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('parfume') }}/assets/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('parfume') }}/assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('parfume') }}/assets/css/demo6.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('parfume') }}/assets/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('parfume') }}/assets/vendor/fontawesome-free/css/all.min.css">
    <style>
        /* Suitcase Theme Overrides (Monochrome, Minimalist, Batik Background) */
        body { 
            font-family: 'Open Sans', sans-serif; 
            color: #333; 
            background-color: #ffffff;
            background-image: url('{{ asset("upload/batik_bg.png") }}');
            background-repeat: repeat;
            background-attachment: fixed;
        }
        .header { background: #fff !important; border-bottom: 1px solid #eaeaea; }
        .feature-box, .testimonial, .product-default {
            background-color: #fff !important;
            box-shadow: 0 8px 25px rgba(0,0,0,0.04);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid transparent;
        }
        .feature-box:hover, .testimonial:hover, .product-default:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;
            border-color: #eaeaea;
        }
        .product-default figure {
            overflow: hidden;
            border-radius: 8px;
        }
        .product-default figure img {
            transition: transform 0.6s ease !important;
        }
        .product-default:hover figure img {
            transform: scale(1.08) !important;
        }
        .btn-outline-dark { border-color: #222 !important; color: #222 !important; border-width: 2px !important; text-transform: uppercase; font-weight: 700;}
        .btn-outline-dark:hover { background-color: #222 !important; color: #fff !important; }
        .product-price { color: #111 !important; font-weight: 700; }
        .btn-add-cart { background-color: #222 !important; color: #fff !important; border-color: #222 !important; text-transform: uppercase; letter-spacing: 1px;}
        .btn-add-cart:hover { background-color: #444 !important; }
        .btn-icon-group .btn-icon { color: #222 !important; }
        .product-title a { color: #333 !important; font-weight: 600; }
        .product-title a:hover { color: #000 !important; }
        .section-title { font-weight: 800; letter-spacing: -0.5px; text-transform: uppercase; color: #111; }
        .banner-content h3 { font-weight: 800; letter-spacing: 1px; color: #111; }
        .bg-img { background-color: #ffffff !important; }
        .product-default figure img, .product-image img { width: 100% !important; height: auto !important; aspect-ratio: 1 / 1 !important; object-fit: contain !important; background-color: #fff; }
        .header-dropdown>a:after {
            display: none !important;
        }

        /* Modern Slider Revamp CSS */
        .home-slider .home-slide {
            position: relative;
        }
        .home-slider .slide-bg {
            object-fit: cover !important;
            height: 100vh !important;
            min-height: 500px;
        }
        .home-slide::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.45);
            pointer-events: none;
            z-index: 1;
        }
        .modern-slide-content {
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
            z-index: 2;
            color: #fff;
            max-width: 600px;
        }
        .modern-slide-subtitle {
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: #ccc;
        }
        .modern-slide-title {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            color: #fff;
            text-transform: uppercase;
        }
        .modern-slide-btn {
            background-color: transparent !important;
            border: 2px solid #fff !important;
            color: #fff !important;
            padding: 15px 35px;
            font-size: 1.2rem;
            font-weight: 700;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        .modern-slide-btn:hover {
            background-color: #fff !important;
            color: #000 !important;
        }

        /* Banner 5 Override */
        .banner-5 {
            background-image: url('{{ asset("uploads/banner/suitcase_banner_half.png") }}') !important;
            background-size: cover;
            background-position: center;
        }



        .inner-quickview figure .btn-keranjang {
            position: absolute;
            padding: 0.8rem 1.4rem;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            color: #fff;
            background-color: #ff7272;
            font-size: 1.3rem;
            font-weight: 400;
            letter-spacing: 0.025em;
            font-family: Poppins, sans-serif;
            text-transform: uppercase;
            visibility: hidden;
            opacity: 0;
            transform: none;
            margin: 0;
            border: none;
            line-height: 1.82;
            transition: padding-top 0.2s, padding-bottom 0.2s;
            z-index: 2;
        }

        .pagination {
            justify-self: center;
            margin-top: 20px;
        }

        /* Sticky Navbar Category Dropdown */
        .sticky-category {
            position: relative;
        }

        .sticky-category-dropdown {
            display: none;
            position: absolute;
            bottom: 50px;
            /* Adjust to position above navbar */
            left: 0;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            list-style: none;
            padding: 10px;
            min-width: 160px;
            z-index: 1001;
        }

        .sticky-category-dropdown li {
            padding: 10px;
            font-size: 14px;
        }

        .sticky-category-dropdown li a {
            text-decoration: none;
            color: #333;
            display: block;
        }

        .sticky-category-dropdown li:hover {
            background: #ffffff;
        }

        /* Fix for mobile responsiveness */
        @media (max-width: 768px) {
            .sticky-category-dropdown {
                bottom: 40px;
                left: 50%;
                transform: translateX(-50%);
                min-width: 180px;
            }
        }
    </style>
    <style>
        /* Chat Button */
        #chat-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        #chat-button {
            background: #000;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            font-size: 16px;
            font-weight: bold;
            cursor: grab;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease, transform 0.2s ease;
            gap: 8px;
        }

        .chat-icon {
            font-size: 18px;
        }

        /* Hover Effect */
        #chat-button:hover {
            background: #333;
            transform: scale(1.05);
        }

        /* Chat Window */
        #chat-window {
            display: none;
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 320px;
            height: 420px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            font-family: Arial, sans-serif;
            overflow: hidden;
            border: 1px solid #ccc;
        }

        /* Chat Header */
        #chat-header {
            background: #000;
            color: white;
            padding: 10px;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: grab;
            height: 50px;
            box-sizing: border-box;
        }

        #chat-close {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        /* Chat Messages */
        #chat-messages {
            height: 310px;
            overflow-y: auto;
            padding: 10px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }

        /* Chat Input */
        #chat-form {
            display: flex;
            padding: 10px;
            background: white;
            border-top: 1px solid #ccc;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            box-sizing: border-box;
        }

        #chat-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
        }

        #chat-send {
            margin-left: 10px;
            padding: 10px 15px;
            background: #000;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        #chat-send:hover {
            background: #333;
        }

        /* Mobile Optimization */
        @media (max-width: 768px) {
            #chat-button {
                font-size: 14px;
                padding: 8px 12px;
            }

            .chat-icon {
                font-size: 16px;
            }

            #chat-window {
                width: 90%;
                right: 5%;
            }
        }

        .sender,
        .receiver {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 18px;
            margin: 5px 0;
            font-size: 14px;
            word-wrap: break-word;
            word-break: break-word;
        }

        .sender {
            background: #000;
            color: #fff;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        .receiver {
            background: #fff;
            color: #000;
            border: 1px solid #eaeaea;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }
    </style>
</head>

<body class="wide">
    <div class="page-wrapper">
        <header class="header" style="background:#ffffff;">
            @include('frontend.layouts.partials.navbar')
        </header>
        <!-- End .header -->

        <main class="main">
            @yield('content')
        </main>
        <!-- End .main -->

        <footer class="footer appear-animate">

            @include('frontend.layouts.partials.footer')
            <!-- End .footer-middle -->
        </footer>
        <!-- End .footer -->
    </div>
    <!-- End .page-wrapper -->

    <div class="loading-overlay">
        <div class="bounce-loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <div class="mobile-menu-overlay"></div>
    <!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="fa fa-times"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="active"><a href="{{ URL::to('/') }}" class="pl-4">Beranda</a></li>
                    <li><a href="{{ URL::to('list-produk') }}">Produk</a></li>
                    <li class="">
                        <a href="#" class="sf-with-ul">Kategori</a>
                        @php $dataCategories = getKategori(); @endphp
                        <ul style="display: none;">
                            @foreach ($dataCategories as $dc)
                            <li><a href="{{ URL::to('produk-by-kategori/'.$dc->id) }}">{{ $dc->nama_kategori }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @if(!empty(session('auth_user')))
                    <li><a href="{{ URL::to('histori-transaksi') }}">Pesanan</a></li>
                    @endif
                </ul>
                <ul class="mobile-menu">
                    @if(!empty(session('auth_user')))
                    <li><a href="{{ URL::to('profil') }}" class="">Profil</a></li>
                    <li><a href="{{ URL::to('logout-user') }}" class="">Logout</a></li>
                    @else
                    <li><a href="{{ URL::to('login-user') }}" class="">Masuk</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    <!-- End .mobile-menu-container -->

    <div class="sticky-navbar">
        <div class="sticky-info">
            <a href="{{ URL::to('/') }}">
                <i class="icon-home"></i>Beranda
            </a>
        </div>
        <div class="sticky-info">
            <a href="{{ URL::to('list-produk') }}" class="">
                <i class="icon-bag-3"></i>Produk
            </a>
        </div>
        <div class="sticky-info sticky-category">
            <a href="javascript:void(0);" id="sticky-category-button">
                <i class="icon-bars"></i> Kategori
            </a>
            <ul id="sticky-category-menu" class="sticky-category-dropdown">
                @foreach ($dataCategories as $dc)
                <li>
                    <a href="{{ URL::to('produk-by-kategori/'.$dc->id) }}">
                        {{ $dc->nama_kategori }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const categoryButton = document.getElementById('sticky-category-button');
                const categoryMenu = document.getElementById('sticky-category-menu');
        
                categoryButton.addEventListener('click', function (event) {
                    event.stopPropagation(); // Prevent immediate closing
                    categoryMenu.style.display = (categoryMenu.style.display === 'block') ? 'none' : 'block';
                });
        
                // Close dropdown when clicking outside
                document.addEventListener('click', function (event) {
                    if (!categoryButton.contains(event.target) && !categoryMenu.contains(event.target)) {
                        categoryMenu.style.display = 'none';
                    }
                });
            });
        </script>

        <div class="sticky-info">
            @if(!empty(session('auth_user')))
            <a href="{{ URL::to('profil') }}" class="">
                <i class="icon-user-2"></i>Account
            </a>
            @else
            <a href="{{ URL::to('login-user') }}" class="">
                <i class="icon-user-2"></i>Login
            </a>
            @endif
        </div>
        @php
        $authUser = session('auth_user') ?? []; // Ensure it's an array
        $pelangganId = isset($authUser['pelanggan_id']) ? $authUser['pelanggan_id'] : null;
        $dataCartNya = $pelangganId ? getCart($pelangganId) ?? [] : [];
        $cartCount = count($dataCartNya);
        @endphp

        <div class="sticky-info">
            <a href="{{ URL::to('cart') }}" class="">
                <i class="icon-shopping-cart position-relative">
                    @if($cartCount > 0)
                    <span class="cart-count badge-circle">{{ $cartCount }}</span>
                    @endif
                </i>Cart
            </a>
        </div>
    </div>
    <!-- End .newsletter-popup -->

    <!-- Scroll to Top Button -->
    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

    @if(!empty(session('auth_user')))
    <div id="chat-container">
        <button id="chat-button">
            <i class="fas fa-comment-alt chat-icon"></i>
            <span class="chat-text">Chat Admin</span>
        </button>
    </div>
    @endif

    <!-- Chat Window -->
    <div id="chat-window">
        <div id="chat-header">
            <span>Chat Admin</span>
            <button id="chat-close">&times;</button>
        </div>
        <div id="chat-messages"></div>
        <form id="chat-form">
            <input type="text" id="chat-input" placeholder="Type a message">
            <button type="submit" id="chat-send">Send</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chatButton = document.getElementById('chat-button');
            const chatWindow = document.getElementById('chat-window');
            const chatClose = document.getElementById('chat-close');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');
    
            let isDragging = false;
            let startX, startY, initialX, initialY;
    
            // Open Chat Window
            chatButton.addEventListener('click', () => {
                chatWindow.style.display = 'block';
            });
    
            // Close Chat Window
            chatClose.addEventListener('click', () => {
                chatWindow.style.display = 'none';
            });
    
            // Fetch Messages
            async function loadMessages() {
                try {
                    const response = await fetch('/messages');
                    const messages = await response.json();
                    chatMessages.innerHTML = '';
    
                    messages.forEach(msg => {
                        const messageElement = document.createElement('div');
                        messageElement.classList.add(msg.chat_sender ? 'sender' : 'receiver');
                        messageElement.textContent = msg.chat_sender ?? msg.chat_receiver;
                        chatMessages.appendChild(messageElement);
                    });
    
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                } catch (error) {
                    console.error('Error loading messages:', error);
                }
            }
    
            // Send Message
            chatForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const message = chatInput.value.trim();
    
                if (message === '') return;
    
                try {
                    const response = await fetch('/send-messages', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ message }),
                    });
    
                    if (!response.ok) {
                        console.error('Error sending message:', await response.text());
                        return;
                    }
    
                    chatInput.value = '';
                    loadMessages();
                } catch (error) {
                    console.error('Error sending message:', error);
                }
            });
    
            // Refresh Messages Every 3 Seconds
            setInterval(loadMessages, 3000);
            loadMessages();
    
            // Make Chat Button Draggable & Snap to Side
            function makeButtonDraggable(button) {
                function startDrag(e) {
                    isDragging = true;
                    startX = e.type.includes("mouse") ? e.clientX : e.touches[0].clientX;
                    startY = e.type.includes("mouse") ? e.clientY : e.touches[0].clientY;
                    const rect = button.getBoundingClientRect();
                    initialX = rect.left;
                    initialY = rect.top;
    
                    document.addEventListener("mousemove", moveButton);
                    document.addEventListener("mouseup", stopDrag);
                    document.addEventListener("touchmove", moveButton, { passive: false });
                    document.addEventListener("touchend", stopDrag);
                }
    
                function moveButton(e) {
                    if (!isDragging) return;
                    e.preventDefault();
    
                    let currentX = e.type.includes("mouse") ? e.clientX : e.touches[0].clientX;
                    let currentY = e.type.includes("mouse") ? e.clientY : e.touches[0].clientY;
    
                    let newX = initialX + (currentX - startX);
                    let newY = initialY + (currentY - startY);
    
                    // Ensure the button stays within the viewport
                    newX = Math.max(0, Math.min(newX, window.innerWidth - button.offsetWidth));
                    newY = Math.max(0, Math.min(newY, window.innerHeight - button.offsetHeight));
    
                    button.style.position = "fixed";
                    button.style.left = `${newX}px`;
                    button.style.top = `${newY}px`;
                }
    
                function stopDrag() {
                    if (!isDragging) return;
                    isDragging = false;
                    document.removeEventListener("mousemove", moveButton);
                    document.removeEventListener("mouseup", stopDrag);
                    document.removeEventListener("touchmove", moveButton);
                    document.removeEventListener("touchend", stopDrag);
    
                    // Snap the button to the closest side (left or right)
                    const buttonRect = button.getBoundingClientRect();
                    const middleX = window.innerWidth / 2;
                    let finalX = buttonRect.left < middleX ? 10 : window.innerWidth - button.offsetWidth - 10; // Snap left or right
    
                    button.style.left = `${finalX}px`;
                    button.style.transition = "left 0.2s ease-out"; // Smooth transition
                    setTimeout(() => {
                        button.style.transition = ""; // Reset transition
                    }, 200);
                }
    
                button.addEventListener("mousedown", startDrag);
                button.addEventListener("touchstart", startDrag, { passive: true });
            }
    
            // Enable Draggable Chat Button with Auto-Snap
            makeButtonDraggable(chatButton);
        });
    </script>
    <script src="{{ asset('parfume') }}/assets/js/jquery.min.js"></script>
    <script src="{{ asset('parfume') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('parfume') }}/assets/js/plugins.min.js"></script>
    <script src="{{ asset('parfume') }}/assets/js/jquery.appear.min.js"></script>
    <!-- Main JS File -->
    <script src="{{ asset('parfume') }}/assets/js/main.min.js"></script>
</body>

</html>