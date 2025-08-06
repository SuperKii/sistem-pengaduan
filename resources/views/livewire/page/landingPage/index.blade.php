<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perum Indah Lestari</title>

    <!-- Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cuprum:wght@500;600;700&family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets_landing_page/css/style.css') }}">

    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon + svg">

    <link rel="preload" as="image" href="assets_landing_page/images/hero-banner.png">
</head>

<body>

    <header class="header" data-header>
        <div class="container">
            {{-- <img src="assets_landing_page/images/hero-banner.jfif" style="width: 75px" alt="" srcset=""> --}}
            <a href="" class="logo">Perum Indah Lestari</a>

            <nav class="navbar" data-navbar>
                <div class="wrapper">
                    <a href="#" class="logo">Perum Indah Lestari</a>
                </div>
            </nav>

            <a href="{{ route('login') }}" class="btn-outline">Login</a>

            <div class="overlay" data-nav-toggler data-overlay></div>
        </div>
    </header>

    <main>
        <article>
            <section class="section hero" id="home" aria-label="hero">
                <div class="container">

                    <div class="hero-content">
                        <p class="hero-subtitle has-before">Selamat Datang Di Sistem Pengaduan Perum Indah Lestari</p>

                        <h1 class="h1 hero-title">Sistem Pengaduan</h1>

                        <p class="hero-text">
                            Sistem Pengaduan Perum Indah Lestari adalah sebuah platform digital yang dirancang untuk
                            mempermudah warga dalam menyampaikan keluhan, laporan, atau masukan terkait fasilitas dan
                            pelayanan lingkungan di wilayah Perumahan Indah Lestari.
                        </p>
                    </div>

                    <figure class="hero-banner has-before img-holder" style="--width:650; --height:650;">
                        <img src="assets_landing_page/images/hero-banner.jfif" width="650" height="650"
                            alt="hero banner" class="img-cover">
                    </figure>
                </div>
            </section>
        </article>
    </main>

    <!---Footer-->
    <footer class="footer">
        <div class="footer-bottom">
            <div class="container">
                <p class="copyright">
                    &copy; 2025 PT. Bumi Hidup | All Rights Reserved by <a href=""
                        class="copyright-link">KiiE</a> </a>
                </p>

                <ul class="footer-bottom-list">
                    <li>
                        <a href="#" class="footer-bottom-link">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="footer-bottom-link">Terms of Use</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('assets_landing_page/js/script.js') }}"></script>

</body>

</html>
