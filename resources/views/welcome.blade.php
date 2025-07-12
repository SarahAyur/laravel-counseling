<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SAAC - Student Academic Advisory Center</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Tailwind CSS code */
        </style>
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
</head>
<body class="bg-gray-50 overflow-x-hidden">
<!-- Header 1 - Logo and Social Media -->
<div class="bg-[#63003a]">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center border-b">
        <!-- Logo -->
        <img
            src="{{ file_exists(public_path('logo_saac.png'))
        ? asset('logo_saac.png')
        : 'https://raw.githubusercontent.com/rstubryan/laravel-counseling-bucket/refs/heads/master/logo_saac.png' }}"
            alt="SAAC Logo" class="h-10">
        <!-- Social Media -->
        <div class="flex items-center gap-6 text-white">
            <span class="font-medium hidden sm:inline">Follow us</span>
            <div class="flex gap-4">
                <a href="https://www.facebook.com/universitasnusaputra"
                   class="text-white hover:text-blue-600 transition-colors">
                    <i class="fab fa-facebook text-xl"></i>
                </a>
                <a href="https://www.instagram.com/nusaputrauniversity"
                   class="text-white hover:text-pink-600 transition-colors">
                    <i class="fab fa-instagram text-xl"></i>
                </a>
                <a href="https://www.linkedin.com/company/nusa-putra-university"
                   class="text-white hover:text-blue-800 transition-colors">
                    <i class="fab fa-linkedin text-xl"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Header 2 - Navigation -->
<div class="bg-white shadow">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-between items-center py-3">
            <!-- Mobile menu button -->
            <div class="block lg:hidden">
                <button
                    class="flex items-center px-3 py-2 border rounded text-gray-700 border-gray-700 hover:text-[#63003a] hover:border-[#63003a]">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links - centered on large screens -->
            <nav class="hidden lg:flex flex-grow items-center justify-center">
                <ul class="flex space-x-8">
                    <li><a href="#hero" class="text-gray-800 hover:text-[#63003a] font-medium">Home</a></li>
                    <li><a href="#about" class="text-gray-800 hover:text-[#63003a] font-medium">About Us</a></li>
                    <li><a href="#services" class="text-gray-800 hover:text-[#63003a] font-medium">Our Services</a></li>
                    <li><a href="#team" class="text-gray-800 hover:text-[#63003a] font-medium">Meet Our Counselors</a>
                    </li>
                    <li><a href="#contact" class="text-gray-800 hover:text-[#63003a] font-medium">Contact</a></li>
                </ul>
            </nav>

            <!-- Buttons -->
            <div class="hidden lg:flex items-center space-x-2">
                <a href="/login"
                   class="flex items-center gap-2 text-[#63003a] px-4 py-2 rounded-md hover:text-[#4b002c] transition-colors">
                    <i class="fas fa-user"></i>
                    <span>Login</span>
                </a>
                <a href="/register"
                   class="border border-[#63003a] text-[#63003a] px-4 py-2 rounded-md hover:bg-[#63003a]/10 transition-colors">
                    Register
                </a>
            </div>
        </div>

        <!-- Mobile Navigation Menu - hidden by default -->
        <div class="hidden w-full pb-3 lg:hidden" id="mobileMenu">
            <ul class="flex flex-col space-y-3">
                <li><a href="#hero" class="text-gray-800 hover:text-[#63003a] font-medium">Home</a></li>
                <li><a href="#about" class="text-gray-800 hover:text-[#63003a] font-medium">About Us</a></li>
                <li><a href="#services" class="text-gray-800 hover:text-[#63003a] font-medium">Our Services</a></li>
                <li><a href="#team" class="text-gray-800 hover:text-[#63003a] font-medium">Meet Our Counselors</a></li>
                <li><a href="#contact" class="text-gray-800 hover:text-[#63003a] font-medium">Contact</a></li>
            </ul>
            <div class="flex flex-col space-y-3 mt-4">
                <a href="/login"
                   class="flex items-center justify-center gap-2 bg-[#63003a] text-white px-4 py-2 rounded-md hover:bg-[#4b002c] transition-colors">
                    <i class="fas fa-user"></i>
                    <span>Login</span>
                </a>
                <a href="/register"
                   class="flex items-center justify-center border border-[#63003a] text-[#63003a] px-4 py-2 rounded-md hover:bg-[#63003a]/10 transition-colors">
                    Register
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<main>
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center text-white flex items-center justify-center"
             style="background-image: url('{{ file_exists(public_path('hero.png'))
        ? asset('hero.png')
        : 'https://raw.githubusercontent.com/rstubryan/laravel-counseling-bucket/refs/heads/master/hero.png' }}'); height: 70vh;"
             id="hero">
        <!-- Standard overlay for text readability -->
        <div class="absolute inset-0 bg-black/30"></div>

        <!-- Bottom fade to black gradient -->
        <div class="absolute inset-x-0 bottom-0 h-1/2"
             style="background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.85) 70%, black 100%);"></div>
        <div class="container mx-auto px-4 py-16 md:py-20 flex flex-col items-center text-center relative z-10">
            <!-- Heading -->
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6 max-w-3xl">
                Student Counseling Unit (SCU) Universitas Nusa Putra
            </h1>

            <!-- Description -->
            <p class="text-lg md:text-xl mb-8 max-w-2xl opacity-90">
                Kami percaya bahwa setiap masalah memiliki solusi. Jangan ragu untuk berbagi dengan kami, karena kami di
                sini untuk mendengarkan dan membantu Anda
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mt-2">
                <a href="/dashboard"
                   class="bg-[#63003a] text-white px-6 py-3 rounded-md hover:bg-[#4b002c] transition-colors">
                    Start Your Healing Journey Today
                </a>
            </div>
        </div>
    </section>

    <!-- Condition when to counsel -->
    <section class="bg-white py-16" id="about">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <!-- Left side - Image (40%) -->
                <div class="w-full md:w-2/5 mb-8 md:mb-0">
                    <img
                        src="{{ file_exists(public_path('left_scu.png'))
        ? asset('left_scu.png')
        : 'https://raw.githubusercontent.com/rstubryan/laravel-counseling-bucket/refs/heads/master/left_scu.png' }}"
                        alt="Student Counseling Unit"
                        class="w-full h-auto lg:max-h-[520px] object-contain rounded-lg">
                </div>

                <!-- Right side - Content (60%) -->
                <div class="w-full md:w-3/5 md:pl-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-[#63003a] mb-6">
                        Saat kondisi bagaimana saya menggunakan layanan SCU?
                    </h2>

                    <p class="text-gray-700 mb-4">
                        Bila kamu akhir-akhir ini, terutama minimal 2 minggu terakhir ini merasakan dua kondisi atau
                        lebih seperti di bawah ini:
                    </p>

                    <ol class="list-decimal pl-5 mb-6 space-y-2 text-gray-700">
                        <li>Sulit untuk konsentrasi dan gampang lupa</li>
                        <li>Menurunnya minat untuk melakukan aktivitas yang biasanya disukai atau dijalani</li>
                        <li>Lebih mudah lelah atau kurang berdaya</li>
                        <li>Perubahan mood atau emosi, jadi gampang sedih, kadang gampang marah, bingung sama perasaan
                            saat ini
                        </li>
                        <li>Sulit untuk bisa tidur, tidur mudah terbangun, mimpi buruk sering muncul, atau tidur terlalu
                            lama
                        </li>
                        <li>Kehilangan nafsu makan atau nafsu makan sangat meningkat</li>
                        <li>Kekhawatiran akan situasi yang akan datang.</li>
                    </ol>

                    <p class="text-gray-700">
                        Silahkan untuk datang ke SCU dan ceritakan apa yang sedang kamu rasakan. Layanan ini free untuk
                        seluruh mahasiswa UNsP.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Services -->
    <section class="bg-[#bd93ab] py-16" id="services">
        <div class="container mx-auto px-4">
            <!-- Section label -->
            <div class="flex justify-center mb-3">
                <span class="bg-[#63003a] text-white text-sm font-medium px-4 py-1 rounded-full">OUR SERVICES</span>
            </div>

            <!-- Section heading -->
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-center text-gray-900 mb-12">
                Get Treatment for all your mental healthcare needs
            </h2>

            <!-- Content area with flex layout -->
            <div class="flex flex-col md:flex-row gap-8 relative">
                <!-- Left side - buttons placed at the bottom -->
                <div class="w-full md:w-1/3 flex flex-col justify-end">
                    <div class="space-y-3 lg:max-w-xs ml-auto">
                        <button
                            class="w-full text-left px-6 py-3 bg-[#63003a] text-white rounded-lg hover:bg-[#4b002c] transition-colors focus:outline-none focus:ring-2 focus:ring-[#63003a] focus:ring-opacity-50 active">
                            Relationship Counseling
                        </button>
                        <button
                            class="w-full text-left px-6 py-3 bg-white text-gray-800 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-[#63003a] focus:ring-opacity-50">
                            Mental health counseling
                        </button>
                        <button
                            class="w-full text-left px-6 py-3 bg-white text-gray-800 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-[#63003a] focus:ring-opacity-50">
                            Academic Stress Counseling
                        </button>
                        <button
                            class="w-full text-left px-6 py-3 bg-white text-gray-800 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-[#63003a] focus:ring-opacity-50">
                            Anxiety Relief Counseling
                        </button>
                        <button
                            class="w-full text-left px-6 py-3 bg-white text-gray-800 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-[#63003a] focus:ring-opacity-50">
                            Deaddiction Counseling
                        </button>
                    </div>
                </div>

                <!-- Center image with floating card -->
                <div class="w-full md:w-2/3 relative">
                    <div class="lg:flex lg:justify-start">
                        <div class="lg:relative lg:max-w-lg">
                            <img
                                src="{{ file_exists(public_path('treatment.png'))
        ? asset('treatment.png')
        : 'https://raw.githubusercontent.com/rstubryan/laravel-counseling-bucket/refs/heads/master/treatment.png' }}"
                                alt="Treatment Services"
                                class="w-full max-w-[100%] h-auto max-h-[700px] rounded-lg">

                            <!-- Floating card - responsive with position change on smaller screens -->
                            <div
                                class="bg-white p-5 rounded-lg shadow-xl lg:absolute lg:-right-80 lg:top-14
                                mt-4 lg:mt-0 w-full lg:w-96 relative">
                                <h3 class="text-xl font-bold text-[#63003a] mb-3">Relationship Counseling</h3>
                                <p class="text-gray-700 text-sm">
                                    Relationship counseling helps students navigate challenges in personal
                                    relationships, whether with family, friends, or romantic partners. Our counselors
                                    provide a safe space to discuss conflicts and develop healthy relationship skills.
                                </p>

                                <!-- Right arrow button positioned at middle right -->
                                <button
                                    class="absolute -right-4 top-1/2 transform -translate-y-1/2 w-8 h-8 bg-[#63003a] rounded-full flex items-center justify-center text-white shadow-lg hover:bg-[#4b002c] transition-colors">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team -->
    <section class="py-16" id="team">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left side - Text content -->
                <div class="w-full lg:w-1/3 flex flex-col justify-center">
                    <!-- Section label -->
                    <div class="mb-3">
                        <span class="bg-[#63003a] text-white text-sm font-medium px-4 py-1 rounded-full">OUR TEAM</span>
                    </div>

                    <!-- Heading -->
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                        Let's meet with our professionals counselor profiles
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-600 mb-8">
                        Our team of experienced counselors brings diverse expertise to support students through various
                        challenges. Each professional is committed to creating a safe space for personal growth and
                        mental wellbeing.
                    </p>

                    <!-- CTA Button -->
                    <div>
                        <a href="#team"
                           class="bg-[#63003a] text-white px-6 py-3 rounded-md hover:bg-[#4b002c] transition-colors inline-flex items-center">
                            Meet More Counselors
                        </a>
                    </div>
                </div>

                <!-- Right side - Counselor cards swiper -->
                <div class="w-full lg:w-2/3">
                    <!-- Swiper container with visible overflow -->
                    <div class="relative">
                        <!-- Swipe indicator on mobile -->
                        <div class="flex items-center justify-center mb-5 lg:hidden">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Swipe to see more
                            <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                        </div>

                        <div class="swiper counselorSwiper overflow-visible">
                            <div class="swiper-wrapper">
                                @forelse($konselors as $konselor)
                                    <!-- Counselor Card -->
                                    <div class="swiper-slide">
                                        <div class="w-full relative rounded-2xl overflow-hidden shadow-lg">
                                            <div class="relative">
                                                @if($konselor->image)
                                                    <img src="{{ asset('storage/' . $konselor->image) }}"
                                                         alt="{{ $konselor->name }}"
                                                         class="w-full rounded-t-2xl object-cover"
                                                         style="height: 400px;">
                                                @else
                                                    <div class="w-full flex items-center justify-center bg-gray-300"
                                                         style="height: 400px;">
                                                        <svg class="w-24 h-24 text-gray-400" fill="none"
                                                             stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                @endif

                                                <!-- Dark gradient overlay -->
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-b from-[#D9D9D9]/0 to-[#630039] opacity-80"></div>

                                                <!-- Content positioned at bottom -->
                                                <div class="absolute bottom-0 left-0 p-6 text-white w-full">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <h3 class="text-xl font-bold mb-1">{{ $konselor->name }}</h3>
                                                            <p class="text-sm">{{ $konselor->is_admin ? 'Admin Konselor' : 'Konselor' }}</p>
                                                        </div>

                                                        <!-- Arrow button -->
                                                        <a href="{{ route('login') }}"
                                                           class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-[#63003a] shadow-lg hover:bg-gray-100 transition-colors ml-4">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <!-- Fallback jika tidak ada konselor -->
                                    <div class="swiper-slide">
                                        <div class="w-full relative rounded-2xl overflow-hidden shadow-lg">
                                            <div class="relative">
                                                <div
                                                    class="w-full flex flex-col items-center justify-center bg-gray-200 p-6"
                                                    style="height: 400px;">
                                                    <svg class="w-16 h-16 text-gray-400 mb-3" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    <p class="text-center text-gray-500">No counselors available at the
                                                        moment</p>
                                                </div>

                                                <!-- Dark gradient overlay - adding for consistent styling -->
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-b from-[#D9D9D9]/0 to-[#630039] opacity-80"></div>

                                                <!-- Empty content area for consistent layout -->
                                                <div class="absolute bottom-0 left-0 p-6 text-white w-full">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <h3 class="text-xl font-bold mb-1">No Counselor</h3>
                                                            <p class="text-sm">Not Available</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Add pagination -->
                            <div class="swiper-pagination mt-5"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row lg:gap-32 gap-12">
                <!-- Left side - Video thumbnail with play button -->
                <div class="w-full lg:w-[500px] flex justify-center items-center">
                    <div class="relative rounded-2xl overflow-hidden w-full">
                        <img src="{{ file_exists(public_path('why_choose_us.png'))
            ? asset('why_choose_us.png')
            : 'https://raw.githubusercontent.com/rstubryan/laravel-counseling-bucket/refs/heads/master/why_choose_us.png' }}"
                             alt="Why Choose Us"
                             class="w-full h-auto object-contain rounded-lg">
                        <!-- Play button overlay -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button
                                class="w-16 h-16 rounded-full bg-white/90 flex items-center justify-center shadow-lg hover:bg-white transition-colors">
                                <i class="fas fa-play text-[#63003a] text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right side - Content -->
                <div class="w-full lg:w-1/2">
                    <!-- Badge -->
                    <div class="mb-3">
                        <span
                            class="bg-[#63003a] text-white text-sm font-medium px-4 py-1 rounded-full">WHY CHOOSE US</span>
                    </div>

                    <!-- Heading -->
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                        Focusing on you, with the best therapeutic care
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-600 mb-8">
                        We provide a safe, confidential environment where students can freely express their concerns.
                        Our approach combines evidence-based practices with compassionate care to help you navigate
                        life's challenges and achieve your full potential.
                    </p>

                    <!-- Four points with icons -->
                    <div class="space-y-6">
                        <!-- Point 1 -->
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-[#63003a]/10 flex items-center justify-center">
                                    <i class="fas fa-check text-[#63003a]"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Personalized Approach</h3>
                                <p class="text-gray-600 text-sm">Each student receives a customized treatment plan based
                                    on their unique needs and challenges.</p>
                            </div>
                        </div>

                        <!-- Point 2 -->
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-[#63003a]/10 flex items-center justify-center">
                                    <i class="fas fa-check text-[#63003a]"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Professional Team</h3>
                                <p class="text-gray-600 text-sm">Our counselors are licensed professionals with
                                    specialized training in student mental health.</p>
                            </div>
                        </div>

                        <!-- Point 3 -->
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-[#63003a]/10 flex items-center justify-center">
                                    <i class="fas fa-check text-[#63003a]"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Years of Experience</h3>
                                <p class="text-gray-600 text-sm">With over 15 years of experience, we've helped
                                    thousands of students overcome various challenges.</p>
                            </div>
                        </div>

                        <!-- Point 4 -->
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-[#63003a]/10 flex items-center justify-center">
                                    <i class="fas fa-check text-[#63003a]"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Dedicated Support</h3>
                                <p class="text-gray-600 text-sm">We provide ongoing support and resources to ensure
                                    continued progress outside of sessions.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quotes -->
    <section class="py-16 bg-gray-50 relative overflow-hidden">
        <!-- Background image (placeholder) -->
        <div class="absolute inset-0 z-0 opacity-30">
            <img src="{{ file_exists(public_path('graduate.png'))
        ? asset('graduate.png')
        : 'https://raw.githubusercontent.com/rstubryan/laravel-counseling-bucket/refs/heads/master/graduate.png' }}"
                 alt="Graduation Background" class="w-full h-full object-cover">
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col lg:flex-row gap-12 items-center">
                <!-- Left side - Heading and decorative elements -->
                <div class="w-full lg:w-1/3">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        Student Counseling Unit Universitas Nusa Putra
                    </h2>

                    <!-- Decorative elements: strip and quote icon -->
                    <div class="flex items-center space-x-4 mb-6">
                        <!-- Decorative strip -->
                        <div class="h-1 bg-[#63003a] w-12"></div>

                        <!-- Quote icon in a circle -->
                        <div class="w-12 h-12 rounded-full bg-[#63003a] flex items-center justify-center text-white">
                            <i class="fas fa-quote-left text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Right side - Quote content -->
                <div class="w-full lg:w-2/3">
                    <!-- Quote text -->
                    <blockquote class="text-xl md:text-2xl text-gray-700 italic mb-6">
                        "Mental health is not a destination, but a process. It's about how you drive, not where you're
                        going. Our goal at SCU is to help students navigate this journey with confidence and
                        resilience."
                    </blockquote>

                    <!-- Author attribution -->
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNtLnYEqvhKKHET_JzfYOv5hZNV1cngGuY_A&s"
                                alt="Quote Author"
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Dr. John Doe</p>
                            <p class="text-sm text-gray-600">A dedicated Counselor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Schedule Your Appointment Today! -->
    <section>
        <!-- No container here so backgrounds can extend full width -->
        <div class="flex flex-col md:flex-row">
            <!-- Left side - Schedule Appointment -->
            <div class="w-full bg-white">
                <div class="mx-auto max-w-md px-4 py-16 flex flex-col items-center justify-center text-center">
                    <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-6">
                        Schedule Your Appointment Today!
                    </h2>

                    <a href="/konseling-mahasiswa"
                       class="bg-[#63003a] text-white px-6 py-3 rounded-md hover:bg-[#4b002c] transition-colors font-medium inline-flex items-center">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Get Appointment
                    </a>
                </div>
            </div>

            <!-- Right side - Join as Counselor -->
            {{--            <div class="w-full md:w-1/2 bg-[#63003a]">--}}
            {{--                <div--}}
            {{--                    class="mx-auto max-w-md px-4 py-16 flex flex-col items-center justify-center text-center text-white h-full">--}}
            {{--                    <div class="flex flex-col items-center justify-center h-full">--}}
            {{--                        <h2 class="text-xl md:text-2xl lg:text-3xl font-bold mb-6">--}}
            {{--                            Join Us as Counselor--}}
            {{--                        </h2>--}}

            {{--                        <a href="/register"--}}
            {{--                           class="bg-white text-[#63003a] px-6 py-3 rounded-md hover:bg-gray-100 transition-colors font-medium inline-flex items-center">--}}
            {{--                            <i class="fas fa-user-plus mr-2"></i>--}}
            {{--                            Join Now--}}
            {{--                        </a>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </section>

    <!-- Footer -->
    <section class="bg-gray-900 text-white" id="contact">
        <div class="container mx-auto px-4 pt-16 pb-8">
            <!-- Top footer with columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Column 1: Logo and about -->
                <div class="mb-6 lg:mb-0">
                    <div class="mb-6">
                        <img src="{{ file_exists(public_path('logo_saac.png'))
        ? asset('logo_saac.png')
        : 'https://raw.githubusercontent.com/rstubryan/laravel-counseling-bucket/refs/heads/master/logo_saac.png' }}"
                             alt="SAAC Logo" class="h-12">
                    </div>
                    <p class="text-gray-400 mb-6">
                        Student Counseling Unit (SCU) Universitas Nusa Putra provides confidential support for students
                        facing personal, academic, or mental health challenges.
                    </p>
                    <!-- Social media links -->
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/universitasnusaputra"
                           class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/nusaputrauniversity"
                           class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/nusa-putra-university/"
                           class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="mb-6 lg:mb-0">
                    <h4 class="text-lg font-bold mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#hero" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition-colors">Our
                                Services</a></li>
                        <li><a href="#team" class="text-gray-400 hover:text-white transition-colors">Meet Our
                                Counselors</a>
                        </li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Column 3: Services -->
                <div class="mb-6 lg:mb-0">
                    <h4 class="text-lg font-bold mb-6">Our Services</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Relationship
                                Counseling</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Mental Health
                                Counseling</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Academic Stress
                                Counseling</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Anxiety Relief
                                Counseling</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Deaddiction
                                Counseling</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Contact Us</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-[#63003a] mt-1"></i>
                            <span class="text-gray-400">Jl. Raya Cibolang Cisaat - Sukabumi No.21, Cibolang Kaler, Kec. Cisaat, Kabupaten Sukabumi, Jawa Barat 43152</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-[#63003a]"></i>
                            <span class="text-gray-400">(0266) 210594</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-[#63003a]"></i>
                            <span class="text-gray-400">counseling@nusaputra.ac.id</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-clock text-[#63003a]"></i>
                            <span class="text-gray-400">Mon-Fri: 8:30 AM - 4:05 PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom footer - Copyright -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm mb-4 md:mb-0">
                    &copy; 2025 Student Counseling Unit Universitas Nusa Putra. All rights reserved.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-gray-500 hover:text-gray-400 text-sm">Privacy Policy</a>
                    <a href="#" class="text-gray-500 hover:text-gray-400 text-sm">Terms of Service</a>
                    <a href="#" class="text-gray-500 hover:text-gray-400 text-sm">Cookie Policy</a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Custom pagination styles -->
<style>
    .swiper-pagination {
        position: relative;
        margin-top: 20px;
    }

    .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #D9D9D9;
        opacity: 1;
        margin: 0 5px;
    }

    .swiper-pagination-bullet-active {
        background: #63003a;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButton = document.querySelector('button');
        const mobileMenu = document.getElementById('mobileMenu');

        menuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>

<!-- Swiper.js JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const counselorSwiper = new Swiper(".counselorSwiper", {
            slidesPerView: "auto",
            spaceBetween: 24,
            centeredSlides: false,
            loop: false,
            grabCursor: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1.15,
                    spaceBetween: 16,
                },
                640: {
                    slidesPerView: 1.5,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 2.5,
                },
            }
        });
    });
</script>
</body>
</html>
