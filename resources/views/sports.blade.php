<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="it-rating" content="it-rat-cd303c3f80473535b3c667d0d67a7a11" />
    <meta name="cmsmagazine" content="3f86e43372e678604d35804a67860df7" />
    <title>খেলাধুলা</title>
    <meta name='description' content="" />
    <meta name="keywords" content="" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/css/style.css') }}" class="styles" />
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/sports.css') }}" class="styles" />

</head>

<body class="loaded">
    <!-- Add Font Awesome for icons -->
    <link href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css') }}"
        rel="stylesheet">


    <header class="header">
        <div class="logo-container">
            <div class="logo">
                <img src="{{ url('frontend/img/jibonjoyi.png') }}" alt="Logo">
            </div>
        </div>

        <div class="top-right">
            <div class="menu-icon" onclick="toggleMenu()" style="font-size: 30px;">☰</div>
            <div class="search-icon" onclick="toggleSearch()" style="font-size: 30px;">🔍</div>
        </div>

        <div class="menu-bar" id="menu-bar">
            <ul class="menu-links">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li><a href="#">Details</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

        <div class="buttons-container">
            <div class="buttons">
                <button class="" style="background-color: #c87283;"
                    onclick="markButton(this); showContent('history')">ইতিহাস</button>
                <button class="" style="background-color: #a9c1b8;"
                    onclick="markButton(this); showContent('philosophy')">দর্শন</button>
                <button class="" style="background-color: #a9b99e;"
                    onclick="markButton(this); showContent('religion')">ধর্ম</button>
                <button class="" style="background-color: #d9b8bb;"
                    onclick="markButton(this); showContent('sports')">খেলাধুলা</button>
                <button class="" style="background-color: #86abd9;"
                    onclick="markButton(this); showContent('travel')">ভ্রমণ</button>
                <button class="" style="background-color: #86abd9;"
                    onclick="markButton(this); showContent('literature')">সাহিত্য</button>
                <button class="" style="background-color: #c6cbb8;"
                    onclick="markButton(this); showContent('liberation')">মুক্তিযুদ্ধ</button>
                <button class="" style="background-color: #c6cbb8;"
                    onclick="markButton(this); showContent('world')">বিশ্ব</button>
                <button class="" style="background-color: #c6cbb8;"
                    onclick="markButton(this); showContent('economy')">অর্থনীতি</button>
                <button style="background-color: #e1a0ad;"
                    onclick="markButton(this); showContent('politics')">রাজনীতি</button>
                <button class="" style="background-color: #beae82;"
                    onclick="markButton(this); showContent('science')">বিজ্ঞান</button>
            </div>
        </div>
        <script>
            function toggleMenu() {
                const menu = document.getElementById('menu-bar');
                if (menu.classList.contains('active')) {
                    menu.classList.remove('active');
                } else {
                    menu.classList.add('active');
                }
            }

            function toggleSearch() {
                const searchBar = document.getElementById('search-bar');
                searchBar.style.display = searchBar.style.display === 'block' ? 'none' : 'block';
            }

            document.addEventListener('click', function (event) {
                const menu = document.getElementById('menu-bar');
                const menuIcon = document.querySelector('.menu-icon');
                const searchBar = document.getElementById('search-bar');
                const searchIcon = document.querySelector('.search-icon');

                if (!menu.contains(event.target) && !menuIcon.contains(event.target)) {
                    menu.classList.remove('active');
                }

                if (!searchBar.contains(event.target) && !searchIcon.contains(event.target)) {
                    searchBar.style.display = 'none';
                }
            });
        </script>

        <div class="search-bar" id="search-bar">
            <input type="text" placeholder="Search...">
        </div>


    </header>

    <!-- BEGIN BODY -->
    <div class="">
        <!-- BEGIN CONTENT -->
        <main>

            <div id="history" style="background-color: #f0f5f8;">
                <div style="background-color: #f0f5f8;">
                    <div class="headerr">
                        <h1>ইতিহাস</h1>
                        <pp>আজাকের বাণী</pp>
                        @if($bani)
                            <p class="quote">{{$bani->bani}}</p>
                            <p class="quote">{{$bani->bani_writer}}</p>
                        @endif
                    </div>

                    <div class="card-container">
                        @foreach ($historyStories as $story)
                            <!-- First Card -->
                            <div class="card">
                                <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                    style="border-radius: 10px;">
                                <div class="card-content">
                                    <h3 class="card-title"><a class="hover-line"
                                            href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                            {{ $story->story_title }}
                                        </a></h3>
                                    <p class="card-meta">
                                        <span>
                                            <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                                style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                            {{ $story->story_writer }}
                                        </span>
                                        <span
                                            style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                        <span>
                                            <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                                style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                            {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                        </span>
                                    </p>

                                    <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                    </p>
                                    <div class="rating-section"
                                        style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                        <h3
                                            style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                            {{ $story->story_category }}
                                        </h3>
                                        <div style="display: flex; align-items: center; color: #6c757d;">
                                            <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                                style="width: 16px; height: 16px; margin-right: 5px;">
                                            {{ $story->story_rating }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <div class="" id="religion" style="background-color: #f0f5f8;">
                <div class="headerr">
                    <h1>ধর্ম</h1>
                    <pp>আজাকের বাণী</pp>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।
                    </p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>


                <div class="card-container">
                    @foreach ($religionStories as $story)
                        <!-- First Card -->
                        <div class="card">

                            <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                style="border-radius: 30px;">
                            <div class="card-content">
                                <h3 class="card-title"><a class="hover-line"
                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                        {{ $story->story_title }}
                                    </a></h3>
                                <p class="card-meta">
                                    <span>
                                        <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ $story->story_writer }}
                                    </span>
                                    <span
                                        style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                    <span>
                                        <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                    </span>
                                </p>

                                <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                </p>
                                <div class="rating-section"
                                    style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                    <h3
                                        style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                        {{ $story->story_category }}
                                    </h3>
                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                        {{ $story->story_rating }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
            <div class="" id="philosophy" style="background-color: #f0f5f8;">
                <div class="headerr">
                    <h1>দর্শন</h1>
                    <pp>আজাকের বাণী</pp>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।
                    </p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>


                <div class="card-container">
                    @foreach ($philosophyStories as $story)
                        <!-- First Card -->
                        <div class="card">
                            <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                style="border-radius: 10px;">
                            <div class="card-content">
                                <h3 class="card-title"><a class="hover-line"
                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                        {{ $story->story_title }}
                                    </a></h3>
                                <p class="card-meta">
                                    <span>
                                        <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ $story->story_writer }}
                                    </span>
                                    <span
                                        style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                    <span>
                                        <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                    </span>
                                </p>

                                <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                </p>
                                <div class="rating-section"
                                    style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                    <h3
                                        style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                        {{ $story->story_category }}
                                    </h3>
                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                        {{ $story->story_rating }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="" id="sports" style="background-color: #f0f5f8;">
                <div class="headerr">
                    <h1>খেলাধুলা</h1>
                    <pp>আজাকের বাণী</pp>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।
                    </p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>


                <div class="card-container">
                    @foreach ($sportsStories as $story)
                        <!-- First Card -->
                        <div class="card">
                            <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                style="border-radius: 10px;">
                            <div class="card-content">
                                <h3 class="card-title"><a class="hover-line"
                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                        {{ $story->story_title }}
                                    </a></h3>
                                <p class="card-meta">
                                    <span>
                                        <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ $story->story_writer }}
                                    </span>
                                    <span
                                        style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                    <span>
                                        <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                    </span>
                                </p>

                                <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                </p>
                                <div class="rating-section"
                                    style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                    <h3
                                        style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                        {{ $story->story_category }}
                                    </h3>
                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                        {{ $story->story_rating }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="" id="travel" style="background-color: #f0f5f8;">
                <div class="headerr">
                    <h1>ভ্রমণ</h1>
                    <pp>আজাকের বাণী</pp>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।
                    </p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>


                <div class="card-container">
                    @foreach ($travelStories as $story)
                        <!-- First Card -->
                        <div class="card">
                            <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                style="border-radius: 10px;">
                            <div class="card-content">
                                <h3 class="card-title"><a class="hover-line"
                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                        {{ $story->story_title }}
                                    </a></h3>
                                <p class="card-meta">
                                    <span>
                                        <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ $story->story_writer }}
                                    </span>
                                    <span
                                        style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                    <span>
                                        <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                    </span>
                                </p>

                                <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                </p>
                                <div class="rating-section"
                                    style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                    <h3
                                        style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                        {{ $story->story_category }}
                                    </h3>
                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                        {{ $story->story_rating }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="" id="liberation" style="background-color: #f0f5f8;">
                <div class="headerr">
                    <h1>মুক্তিযুদ্ধ</h1>
                    <pp>আজাকের বাণী</pp>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।
                    </p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>


                <div class="card-container">
                    @foreach ($liberationStories as $story)
                        <!-- First Card -->
                        <div class="card">
                            <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                style="border-radius: 10px;">
                            <div class="card-content">
                                <h3 class="card-title"><a class="hover-line"
                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                        {{ $story->story_title }}
                                    </a></h3>
                                <p class="card-meta">
                                    <span>
                                        <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ $story->story_writer }}
                                    </span>
                                    <span
                                        style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                    <span>
                                        <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                    </span>
                                </p>

                                <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                </p>
                                <div class="rating-section"
                                    style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                    <h3
                                        style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                        {{ $story->story_category }}
                                    </h3>
                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                        {{ $story->story_rating }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="" id="world" style="background-color: #f0f5f8;">
                <div class="headerr">
                    <h1>বিশ্ব</h1>
                    <pp>আজাকের বাণী</pp>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।
                    </p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>


                <div class="card-container">
                    @foreach ($worldStories as $story)
                        <!-- First Card -->
                        <div class="card">
                            <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                style="border-radius: 10px;">
                            <div class="card-content">
                                <h3 class="card-title"><a class="hover-line"
                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                        {{ $story->story_title }}
                                    </a></h3>
                                <p class="card-meta">
                                    <span>
                                        <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ $story->story_writer }}
                                    </span>
                                    <span
                                        style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                    <span>
                                        <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                    </span>
                                </p>

                                <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                </p>
                                <div class="rating-section"
                                    style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                    <h3
                                        style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                        {{ $story->story_category }}
                                    </h3>
                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                        {{ $story->story_rating }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="" id="economy" style="background-color: #f0f5f8;">
                <div class="headerr">
                    <h1>অর্থনীতি</h1>
                    <pp>আজাকের বাণী</pp>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।
                    </p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>

                <div class="card-container">
                    @foreach ($economyStories as $story)
                        <!-- First Card -->
                        <div class="card">
                            <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                style="border-radius: 10px;">
                            <div class="card-content">
                                <h3 class="card-title"><a class="hover-line"
                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                        {{ $story->story_title }}
                                    </a></h3>
                                <p class="card-meta">
                                    <span>
                                        <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ $story->story_writer }}
                                    </span>
                                    <span
                                        style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                    <span>
                                        <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                    </span>
                                </p>

                                <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                </p>
                                <div class="rating-section"
                                    style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                    <h3
                                        style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                        {{ $story->story_category }}
                                    </h3>
                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                        {{ $story->story_rating }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="" id="politics" style="background-color: #f0f5f8;">
                <div class="headerr">
                    <h1>রাজনীতি</h1>
                    <pp>আজাকের বাণী</pp>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।
                    </p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>

                <div class="card-container">
                    @foreach ($politicsStories as $story)
                        <!-- First Card -->
                        <div class="card">
                            <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                style="border-radius: 10px;">
                            <div class="card-content">
                                <h3 class="card-title"><a class="hover-line"
                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                        {{ $story->story_title }}
                                    </a></h3>
                                <p class="card-meta">
                                    <span>
                                        <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ $story->story_writer }}
                                    </span>
                                    <span
                                        style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                    <span>
                                        <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                    </span>
                                </p>

                                <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                </p>
                                <div class="rating-section"
                                    style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                    <h3
                                        style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                        {{ $story->story_category }}
                                    </h3>
                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                        {{ $story->story_rating }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="" id="science" style="background-color: #f0f5f8;">
                <div class="headerr">
                    <h1>বিজ্ঞান</h1>
                    <pp>আজাকের বাণী</pp>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।
                    </p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>

                <div class="card-container">
                    @foreach ($scienceStories as $story)
                        <!-- First Card -->
                        <div class="card">
                            <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                style="border-radius: 10px;">
                            <div class="card-content">
                                <h3 class="card-title"><a class="hover-line"
                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                        {{ $story->story_title }}
                                    </a></h3>
                                <p class="card-meta">
                                    <span>
                                        <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ $story->story_writer }}
                                    </span>
                                    <span
                                        style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                    <span>
                                        <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                    </span>
                                </p>

                                <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                </p>
                                <div class="rating-section"
                                    style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                    <h3
                                        style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                        {{ $story->story_category }}
                                    </h3>
                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                        {{ $story->story_rating }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="" id="literature" style="background-color: #f0f5f8;">
                <div class="headerr">
                    <h1>সাহিত্য</h1>
                    <pp>আজাকের বাণী</pp>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।
                    </p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>

                <div class="card-container">
                    @foreach ($literatureStories as $story)
                        <!-- First Card -->
                        <div class="card">
                            <img src="{{ asset('storage/' . $story->banner) }}" alt="Historical Image"
                                style="border-radius: 10px;">
                            <div class="card-content">
                                <h3 class="card-title"><a class="hover-line"
                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                        {{ $story->story_title }}
                                    </a></h3>
                                <p class="card-meta">
                                    <span>
                                        <img src="{{ url('frontend/assets/img/w1.png') }}" alt="Author"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ $story->story_writer }}
                                    </span>
                                    <span
                                        style="font-size: 16px; font-weight: lighter;margin-left: 1%;margin-right: 1%;">|</span>
                                    <span>
                                        <img src="{{ url('frontend/assets/img/date.png') }}" alt="Date"
                                            style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                        {{ \Carbon\Carbon::parse($story->story_date)->format('F d, Y') }}
                                    </span>
                                </p>

                                <p class="card-description">{{ Str::limit($story->story_description, 150) }}
                                </p>
                                <div class="rating-section"
                                    style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                    <h3
                                        style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-right:-5% ;">
                                        {{ $story->story_category }}
                                    </h3>
                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                        {{ $story->story_rating }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>



            <a href="#" class="bann">
                <img data-src="{{ asset('storage/' . $ad->vertical_ad1) }}"
                    src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="" />
            </a>


            <div class="section-post" style="margin-top: 30px;">

                <div class="wrapper">

                    <div class="columns">
                        <div class="columns_center">


                            <div class="container4">

                                <h3
                                    style="font-size: 15px; background-color: #4045A3; color: white; display: inline-block; padding: 8px 8px; border-radius: 10px;">
                                    সর্বশেষ</h3>

                                <div class="row" style="margin-top:20px;">
                                    @foreach ($lastSixStories as $story)
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="blog-style1">
                                                <div class="blog-img">
                                                    <img src="{{ asset('storage/' . $story->banner) }}" alt="Story Banner"
                                                        style="border-radius: 20px;">
                                                    <span class="category"></span>
                                                </div>
                                                <h3 class="responsive-title"><a class="hover-line"
                                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                                        {{ $story->story_title }}
                                                    </a></h3>
                                                <div class="blog-meta"
                                                    style="display: flex; align-items: center; gap: 5px; font-size: 12px;height: 0px;">
                                                    <p class="responsive-title1"> {{ $story->story_writer }}</p>
                                                    <p style="margin-left:2%; margin-right:2%; font-size: 18px;">|</p>
                                                    <p class="responsive-title1">
                                                        {{ \Carbon\Carbon::parse($story->story_date)->format('d F Y') }}
                                                    </p>
                                                </div>

                                                <div class="rating-section"
                                                    style="display: flex; align-items: center; margin-top: 10px; gap: 10px; font-size: 14px;">
                                                    <h3 class="responsive-title1"
                                                        style="background-color: rgb(243, 243, 245); color: rgb(88, 58, 158); display: inline-block; padding: 5px 10px; border-radius: 15px; margin: 0; cursor: pointer;">
                                                        {{ $story->story_category }}
                                                    </h3>
                                                    <div style="display: flex; align-items: center; color: #6c757d;">
                                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                                            style="width: 16px; height: 16px; margin-right: 5px;">
                                                        {{ $story->story_rating }}
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="mt-30">
                                    <div class="blog-style2">
                                        <h2
                                            style="font-size: 15px; background-color: #4045A3; color: white; display: inline-block; padding: 8px 8px; border-radius: 10px;margin-top:30px;">
                                            সকল পোস্ট </h2>
                                        @foreach ($blogs as $blog)
                                            <div class="blog-container">
                                                <div class="blog-img2">
                                                    <img src="{{ asset('storage/' . $blog->banner) }}" alt="blog image">
                                                </div>
                                                <div class="blog-content">
                                                    <h3 class="box-title-24">
                                                        <a class="hover-line"
                                                            href="{{ route('incrementClickCount', ['id' => $blog->id]) }}"
                                                            style="font-size: 2.1rem;">{{ $blog->story_title }}
                                                        </a>
                                                    </h3>
                                                    <div class="">
                                                        <p class="card-meta">
                                                            <span>
                                                                <img src="{{ url('frontend/assets/img/w1.png') }}"
                                                                    alt="Author"
                                                                    style="width: 16px; height: 16px; vertical-align: middle;">
                                                                {{ $blog->story_writer }}
                                                            </span>
                                                            <span style="font-size: 16px; font-weight: lighter;">|</span>
                                                            <span>
                                                                <img src="{{ url('frontend/assets/img/date.png') }}"
                                                                    alt="Date"
                                                                    style="width: 16px; height: 16px; vertical-align: middle;">
                                                                {{ date('F d, Y', strtotime($blog->story_date)) }}
                                                            </span>
                                                        </p>

                                                        <div style="white-space: 10px;">
                                                            <p style="font-size: 15px;">
                                                                {{ Str::limit($blog->story_description, 150) }}
                                                            </p>
                                                        </div>


                                                        <div class="rating-section"
                                                            style="display: flex; align-items: center; margin-top: 5px; gap: 10px; font-size: 20px;">
                                                            <h6
                                                                style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; margin: 0; padding: 5px;">
                                                                {{ $blog->story_category }}
                                                            </h6>
                                                            <h6
                                                                style="font-size: 14px; background-color: #FFF5F5; color: #DC8D8D; margin: 0; padding: 5px; display: flex; align-items: center;">
                                                                {{ $blog->story_category1 }}
                                                            </h6>
                                                            <h6 style="display: flex; align-items: center; gap: 5px;">
                                                                <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                                                    style="height: 20px;">
                                                                <span>{{ $blog->story_rating }}</span>
                                                            </h6>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="pagination {
">
                                        {{ $blogs->links() }}
                                    </div>
                                </div>


                            </div>
                        </div>
                        <aside class="columns_sidebar">

                            <div class="sidebar_widget">
                                <div class="popular">

                                    <h3
                                        style="font-size: 15px; background-color: #4045A3; color: white; display: inline-block; padding: 8px 8px; border-radius: 10px;">
                                        সবচেয়ে পঠিত</h3>
                                    @foreach ($mostReadStories as $story)
                                        <div class="popular_item" style="margin-bottom: -25px;">
                                            <div class="popular_item_img">
                                                <a href="#">
                                                    <img data-src="{{ asset('storage/' . $story->banner) }}"
                                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
                                                        alt="banner_img" style="border-radius: 10px; width: 140px; height: auto;" />
                                                </a>
                                            </div>
                                            <div class="popular_item_cont">
                                                <div class="popular_item_title"
                                                    style="font-size: 12px; font-weight: bold; margin-bottom: 0;">
                                                    <a class="hover-line"
                                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                                        {{ $story->story_title }}
                                                    </a>
                                                    <class="popular_item_infoline infoline"
                                                        style="display: flex; align-items: center; margin-top: 0;">
                                                        <img src="{{ asset('storage/' . $story->writer_img) }}" alt="writer_img" />
                                                        <a href="#" class="cats_item"
                                                            style="margin-top: -2px;font-weight: lighter;">{{ $story->story_writer }}</a>
                                                </div>
                                                <div class="rating-section"
                                                    style="display: flex; align-items: center; margin-bottom: 30px; font-size: 14px;">
                                                    <h3
                                                        style="font-size: 12px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-top: -30%">
                                                        {{ $story->story_category }}
                                                    </h3>
                                                    <h3
                                                        style="font-size: 12px; background-color: #FFF5F5; color: #DC8D8D; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer;margin-top: -30%">
                                                        {{ $story->story_category1 }}
                                                    </h3>
                                                    <div
                                                        style="display: flex; align-items: center; color: #6c757d; margin-left: 0;margin-top: -30%">
                                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                                            style="width: 10px; height: 10px; margin-right: 5px;">
                                                        <span style="font-size: 10px;">{{ $story->story_rating }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="space-bottom2234">
                                <a href="#">
                                    <img width="600x600" src="{{ asset('storage/' . $ad->horizontal_ad) }}" alt="ads"
                                        style="width: 700px; margin-top: 20px; bottom: 80px;">
                                </a>
                            </div>

                            <div class="poll-container">
                                <h3>আজকের জরিপ ০১</h3>
                                <p>আপনি কোন সাহিত্যিকের কবিতা বা রচনা রোমান্টিক আন্দোলনের সাথে সম্পর্কিত মনে করেন?</p>
                                <form id="pollForm">
                                    <div class="option">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" class="checkbox-input" />
                                            <span class="checkbox-box"></span>
                                            <input type="radio" name="poet" value="rabindranath">
                                            <span class="option-text">কবি রবীন্দ্রনাথ ঠাকুর</span>
                                            <span class="percentage">২০%</span>
                                        </label>
                                    </div>
                                    <div class="option">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" class="checkbox-input" />
                                            <span class="checkbox-box"></span>
                                            <input type="radio" name="poet" value="kaliprasanna">
                                            <span class="option-text">কবি কালীপ্রসন্ন সিংহ</span>
                                            <span class="percentage">৬০%</span>
                                        </label>
                                    </div>
                                    <div class="option">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" class="checkbox-input" />
                                            <span class="checkbox-box"></span>
                                            <input type="radio" name="poet" value="govind">
                                            <span class="option-text">কবি গোবিন্দচন্দ্র দে</span>
                                            <span class="percentage">৩০%</span>
                                        </label>
                                    </div>
                                    <div class="option">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" class="checkbox-input" />
                                            <span class="checkbox-box"></span>
                                            <input type="radio" name="poet" value="none">
                                            <span class="option-text">কাউকেই না</span>
                                            <span class="percentage">০%</span>
                                        </label>
                                    </div>
                                    <button type="button" id="submitBtn" style="background-color: #4045A3;">মতামত
                                        প্রদান</button>
                                </form>
                            </div>
                            <div class="space"></div>
                            <div class="poll-container">
                                <h3>আজকের জরিপ ০২</h3>
                                <p>আপনি কোন সাহিত্যিকের কবিতা বা রচনা রোমান্টিক আন্দোলনের সাথে সম্পর্কিত মনে করেন?</p>
                                <form id="pollForm">
                                    <div class="option">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" class="checkbox-input" />
                                            <span class="checkbox-box"></span>
                                            <input type="radio" name="poet" value="rabindranath">
                                            <span class="option-text">কবি রবীন্দ্রনাথ ঠাকুর</span>
                                            <span class="percentage">২০%</span>
                                        </label>
                                    </div>
                                    <div class="option">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" class="checkbox-input" />
                                            <span class="checkbox-box"></span>
                                            <input type="radio" name="poet" value="kaliprasanna">
                                            <span class="option-text">কবি কালীপ্রসন্ন সিংহ</span>
                                            <span class="percentage">৬০%</span>
                                        </label>
                                    </div>
                                    <div class="option">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" class="checkbox-input" />
                                            <span class="checkbox-box"></span>
                                            <input type="radio" name="poet" value="govind">
                                            <span class="option-text">কবি গোবিন্দচন্দ্র দে</span>
                                            <span class="percentage">৩০%</span>
                                        </label>
                                    </div>
                                    <div class="option">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" class="checkbox-input" />
                                            <span class="checkbox-box"></span>
                                            <input type="radio" name="poet" value="none">
                                            <span class="option-text">কাউকেই না</span>
                                            <span class="percentage">০%</span>
                                        </label>
                                    </div>
                                    <button type="button" id="submitBtn" style="background-color: #4045A3;">মতামত
                                        প্রদান</button>
                                </form>
                            </div>
                            <div class="space"></div>
                            <div class="poll-container">
                                <form id="pollForm">
                                    <div style="height: 200px;">
                                        <p style="text-align: center;padding: 60px; font-weight: bolder;"> Lets Met</p>
                                    </div>
                                </form>
                            </div>

                        </aside>
                    </div>
                </div>
            </div>
            <style>

            </style>
            <div class="container1">
                <div class="headerr">
                    <h1 style="color: #0056b3;text-decoration: underline;">আজকের বাণী</h1>
                    <p class="quote">মানুষের পুরো জীবনটা হচ্ছে একটা সরল অংক, যতই দিন যাচ্ছে ততই আমরা তার সমাধানের দিকে
                        যাচ্ছি ।</p>
                    <p class="quote">-হুমায়ুন আহমেদ</p>
                </div>
            </div>

        </main>

        <!-- CONTENT EOF   -->
        <!-- BEGIN HEADER -->

        <!-- HEADER EOF   -->
        <!-- BEGIN FOOTER -->


        <footer class="footer">
            <!-- First footer row -->
            <div class="footer-wrapper">
                <div class="notice-container">
                    <div class="static-text">বিভাগের নোটিশ:</div>
                    <div class="scrolling-text" id="scrollingText">
                        <!-- Dynamic text will appear here -->
                    </div>
                </div>
            </div>

            <!-- Second footer row -->
            <div class="">
                <div class="footer">
                    <div class="static-text1" style="text-align: center;">সর্বস্বর্ত্ব ২০২৪ জীবনজয়ী</div>
                </div>
            </div>
            <script>
                const scrollingText = document.getElementById('scrollingText');
                const noticeContainer = document.querySelector('.notice-container');

                // Array of messages to scroll
                const messages = [
                    "আরবি নামটি শুনলে প্রথমেই আমাদের মনে আসে এটি পবিত্র কুরআনের ভাষা, যা ইসলাম ধর্মের সাথে সম্পর্কিত।"
                ];

                let currentMessageIndex = 0;

                function updateScrollingText() {
                    // Update the text content
                    scrollingText.textContent = messages[currentMessageIndex];

                    // Adjust the animation duration
                    const textWidth = scrollingText.offsetWidth;
                    const containerWidth = noticeContainer.offsetWidth;
                    const duration = (textWidth / containerWidth) * 20; // Adjust multiplier as needed
                    scrollingText.style.animationDuration = `${duration}s`;

                    // Listen for animation end
                    scrollingText.addEventListener('animationend', handleAnimationEnd, {
                        once: true
                    });
                }

                function handleAnimationEnd() {
                    // Update to the next message
                    currentMessageIndex = (currentMessageIndex + 1) % messages.length; // Loop through messages
                    scrollingText.style.animation = 'none'; // Reset animation
                    void scrollingText.offsetWidth; // Trigger reflow to restart animation
                    scrollingText.style.animation = ''; // Reapply animation
                    updateScrollingText(); // Update the text
                }

                // Initialize on page load
                window.onload = updateScrollingText;

                // Recalculate on resize
                window.onresize = () => {
                    scrollingText.style.animation = 'none'; // Reset animation
                    void scrollingText.offsetWidth; // Trigger reflow
                    updateScrollingText(); // Restart scrolling
                };
            </script>
        </footer>

        <!-- FOOTER EOF   -->
        <div class="overlay"></div>
    </div>
    <!-- BODY EOF   -->
    <script src="{{ url('frontend/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ url('frontend/js/custom.js') }}"></script>
    <script>
        function markButton(button) {
            // Remove the 'active' class from all buttons
            const buttons = document.querySelectorAll(".buttons button");
            buttons.forEach(btn => btn.classList.remove("active"));

            // Add the 'active' class to the clicked button
            button.classList.add("active");
        }

        function showContent(id) {
            // Hide all content sections
            const sections = document.querySelectorAll("div[id]");
            sections.forEach(section => {
                section.style.display = "none";
            });

            // Show the selected section
            const selectedSection = document.getElementById(id);
            if (selectedSection) {
                selectedSection.style.display = "block";
            }

            // Remove the 'bold' class from all buttons
            const buttons = document.querySelectorAll(".buttons button");
            buttons.forEach(button => button.classList.remove("bold"));

            // Add the 'bold' class to the clicked button
            const clickedButton = document.querySelector(`[onclick="markButton(this); showContent('${id}')"]`);
            if (clickedButton) {
                clickedButton.classList.add("bold");
            }
        }

        // Set the default active button and content when the page loads
        document.addEventListener("DOMContentLoaded", function () {
            const defaultButton = document.querySelector(".buttons button:nth-child(4)"); // Adjust if needed
            if (defaultButton) {
                defaultButton.classList.add("active");

                // Extract the ID from the button's onclick function
                const onclickAttr = defaultButton.getAttribute("onclick");
                const match = onclickAttr.match(/showContent\('([^']+)'\)/);
                if (match) {
                    showContent(match[1]); // Extracted section ID
                }
            }
        });
    </script>



</body>

</html>