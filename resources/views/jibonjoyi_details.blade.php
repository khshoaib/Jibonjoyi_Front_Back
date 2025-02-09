<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="it-rating" content="it-rat-cd303c3f80473535b3c667d0d67a7a11" />
    <meta name="cmsmagazine" content="3f86e43372e678604d35804a67860df7" />
    <title>More Details</title>
    <meta name='description' content="" />
    <meta name="keywords" content="" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/css/style.css') }}" class="styles" />
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/css/3rdpage.css') }}" class="styles" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="loaded">
    <!-- Add Font Awesome for icons -->
    <link href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css') }}"
        rel="stylesheet">

    <header class="header">
        <div class="logo" style="margin-top: 40px;">
            <a href="{{ route('index') }}" style="padding-right: 20px;">
                <img src="{{ url('frontend/img/jibonjoyi.png') }}" alt="Logo" class="logo">
            </a>
            <!-- <div class="user-info">
                @if(session()->has('username'))
                    <p>Welcome, <strong>{{ session('username') }}</strong>!</p>
                    <a href="{{ route('logout') }}" class="logout-btn">Logout</a>
                @else
                    <a href="{{ route('signin') }}" class="login-btn">Sign In</a>
                @endif
            </div> -->
        </div>

        <div class="top-right">
            <div class="search-icon" onclick="toggleSearch()" style="font-size: 30px;">🔍</div>
            <div class="menu-icon" onclick="toggleMenu()" style="font-size: 30px;">☰</div>
        </div>

        <div class="menu-bar" id="menu-bar">
            <ul class="menu-links">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li><a href="{{ route('liberation') }}">2nd</a></li>
                <li><a href="{{ route('stories.create') }}">Admin</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

        <div class="search-bar" id="search-bar">
            <input type="text" placeholder="Search...">
        </div>

        <!-- ✅ Show logged-in username -->


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
    </header>

    @php
        $S = $story;
    @endphp

    <!-- BEGIN BODY -->
    <div class="main-wrapper" style="margin-top: 20px;">
        <!-- BEGIN CONTENT -->
        <main>
            <div class="container6">

            <div class="headerr">
    <h1 style="color: #0056b3; text-decoration: underline;">আজকের বাণী</h1>
    
    @if ($bani)
        <p class="quote">{{ $bani->bani }}</p>
        <p class="quote">- {{ $bani->bani_writer }}</p>
    @else
        <p class="quote">আজকের জন্য কোন বাণী পাওয়া যায়নি।</p>
    @endif
</div>
            </div>
            <div class="section-post">
                <div class="wrapper">
                    <div class="columns">
                        <div class="columns_center">
                            <div class="container2">
                                <article class="article">
                                    <div class="article_txt">
                                        <!-- Banner Image -->
                                        <a href="#" class="bann">
                                            <img src="{{ asset('storage/' . $ad->vertical_ad1) }}"
                                                alt="Vertical Ad 1" />
                                        </a>

                                        <h3
                                            style="font-size: 12px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer;">
                                            {{ $story->story_category }}
                                        </h3>
                                        <h1 style="color: #474747;">{{ $story->story_title }}</h1>

                                        <!-- Story Subtitle (if applicable) -->
                                        <h2 style="color: #474747;">
                                            {{ $story->story_description }}
                                        </h2>

                                        <!-- Author and Date Information -->
                                        <div class="popular_item_infoline infoline"
                                            style="display: flex; align-items: center;">
                                            <img src="{{ url('storage/' . $story->writer_img) }}" alt="" />
                                            <a href="#" class="cats_item"
                                                style="margin-top: -2px;">"{{ $story->story_writer }}"</a>

                                            <div class="popular_item_infoline infoline"
                                                style="display: flex; align-items: center;">
                                                <img src="{{ url('frontend/img/date.png') }}" alt="" />
                                                <a href="#" class="cats_item"
                                                    style="margin-top: -2px;">{{ \Carbon\Carbon::parse($story->story_date)->format('d F Y') }}</a>
                                        </div>

                                       
                                    <div class="">
                                        <img src="{{ asset('storage/' . $story->banner) }}" alt=""
                                            class="full-width-image" />
                                    </div>

                                        <!-- <div class="popular_item_infoline infoline"
                                        style="display: flex; align-items: center;">
                                        <img src="{{ url('storage/' . $story->writer_img) }}"
                                            alt="{{ $story->story_writer }}" />
                                        <span class="cats_item"
                                            style="margin-top: -2px;">{{ $story->story_writer }}</span>

                                        <img src="{{ url('frontend/img/date.png') }}" alt="Date" />
                                        <span class="cats_item"
                                            style="margin-top: -2px;">{{ \Carbon\Carbon::parse($story->story_date)->format('d F Y') }}</span>
                                    </div> -->

                                        <!-- Story Details -->
                                        <p class="short">{!! nl2br(e($story->story_details)) !!}</p>
                                    </div>

                                   

<!-- share post work -->
<!-- Share Button -->
<button id="shareBtn" style="background-color:#40469e; width:200px; border-radius:7px; color:white; padding:10px; border:none; cursor:pointer;">
<i class="fa fa-share-alt" aria-hidden="true" style="color: white;"> </i>  শেয়ার করুন
</button>

<!-- Pop-up Modal -->
<div id="shareModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: none; justify-content: center; align-items: center; z-index: 20;">
    <div style="background:white; padding: 20px; border-radius: 7px; width: 500px; height: 280px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 20px; font-weight: bold;">Share</h3>
            <button id="closeModal" style="width: 30px; font-size: 24px; border: none; background: none; cursor: pointer; color:#4045A3; margin-bottom:20px">&times;</button>
        </div>

        <!-- Social Media Icons -->
        <div style="display: flex; justify-content: space-between;">
            <div style="text-align: center;">
                <a href="#" id="embedShare" target="_blank" style="display: block; background-color: #555; width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                <i class="fa-solid fa-code" style="color: white;"></i>
                </a>
                <p style="font-size: 14px; color: #333;">Embed</p>
            </div>
            <div style="text-align: center;">
                <a href="#" id="whatsappShare" target="_blank" style="display: block; background-color: #25D366; width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                <i class="fa-brands fa-whatsapp" style="color: white;"></i>
                </a>
                <p style="font-size: 14px; color: #333;">WhatsApp</p>
            </div>
            <div style="text-align: center;">
                <a href="#" id="facebookShare" target="_blank" style="display: block; background-color: #1877F2; width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                    <i class="fa-brands fa-facebook-f" style="color: white;"></i>
                </a>
                <p style="font-size: 14px; color: #333;">Facebook</p>
            </div>
            <div style="text-align: center;">
                <a href="#" id="twitterShare" target="_blank" style="display: block; background-color: #1DA1F2; width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                <i class="fa-brands fa-twitter" style="color: white;"></i>
                </a>
                <p style="font-size: 14px; color: #333;">Twitter</p>
            </div>
            <div style="text-align: center;">
                <a href="#" id="emailShare" target="_blank" style="display: block; background-color: #D44638; width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                <i class="fa fa-envelope" style="color: white;"></i></a>
                <p style="font-size: 14px; color: #333;">Email</p>
            </div>
            <!-- <div style="text-align: center;">
                <a href="#" id="redditShare" target="_blank" style="display: block; background-color: #FF4500; width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                <i class="fa fa-reddit-alien" aria-hidden="true" style="color: white;"></i>
                </a>
                <p style="font-size: 14px; color: #333;">Reddit</p>
            </div> -->
        </div>

        <div style="display: flex; align-items: center; border: 1px solid #ccc; border-radius: 30px; background: #f9f9f9; max-width: 450px; padding: 5px 10px;">
    <input type="text" id="postUrl" value="https://example.com/post"
        style="flex: 1; border: none; background: transparent; outline: none; color: #333; font-size: 14px;" readonly>

    <button id="copyLink"
        style="background-color: #31a5de; color: white; border: none; border-radius: 25px; font-size: 12px; cursor: pointer; max-width: 50px; padding: 6px 10px; margin-top:-1px">
        Copy
    </button>
</div>
    </div>
</div>



                                </article>




                                <a href="#" class="bann">
                                    <img src="{{ asset('storage/' . $ad->vertical_ad1) }}" alt="Vertical Ad 1" />
                                </a>
                            </div>

                            
                                




                            <div class="container4">
                                <section class="popular-news">
                                    <h3
                                        style="font-size: 15px; background-color: #4045A3; color: white; display: inline-block; padding: 8px 8px; border-radius: 10px;">
                                        এই বিভাগের আরও পোস্ট</h3>
                                    <div class="row gy-4">
                                        @foreach ($relatedStories as $story)
                                            <div class="col-6 col-sm-5 col-md-4 col-lg-4">
                                                <div class="blog-style1">
                                                    <!-- Story Banner -->
                                                    <div class="blog-img">
                                                        <img src="{{ asset('storage/' . $story->banner) }}" alt="blog image"
                                                            style="border-radius: 20px;">
                                                    </div>

                                                    <!-- Story Title with Dynamic Link -->
                                                    <h3 class="box-title-20">
                                                        <a class="hover-line"
                                                            href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                                            {{ $story->story_title }}
                                                        </a>
                                                    </h3>

                                                    <!-- Story Metadata -->
                                                    <p class="card-meta">
                                                        <span class="box-title-21">{{ $story->story_writer }}</span>
                                                        <span class="box-title-21">|</span>
                                                        <span
                                                            class="box-title-21">{{ \Carbon\Carbon::parse($story->story_date)->format('d F Y') }}</span>
                                                    </p>


                                                    <!-- Story Category and Rating -->
                                                    <div class="rating-section"
                                                        style="display: flex; align-items: center; margin-top: 5px; gap: 50px; font-size: 14px;">
                                                        <h3
                                                            style="font-size: 14px; background-color: #F9F5FF; color: #6941C6; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer;">
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
                                </section>
                            </div>
                        </div>

                        <!-- @foreach ($lastSixStories as $story)
<div class="popular_item" style="margin-bottom: -25px;">
                                <div class="popular_item_img">
                                    <a href="{{ route('jibonjoyi_details', ['id' => $story->id]) }}">
                                        <img src="{{ asset('storage/' . $story->banner) }}" alt="blog image" class="js-img"
                                            loading="lazy" style="border-radius: 10px; width: 140px; height: auto;" />
                                    </a>
                                </div>
                                <div class="popular_item_cont">
                                    <div class="popular_item_title"
                                        style="font-size: 12px; font-weight: bold; margin-bottom: 0;">
                                        <a href="{{ route('jibonjoyi_details', ['id' => $story->id]) }}">
                                            {{ $story->story_title }}
                                        </a>
                                        <div class="popular_item_infoline infoline"
                                            style="display: flex; align-items: center; margin-top: 0;">
                                            <img src="{{ url('frontend/img/w1.png') }}" alt="" />
                                            <a href="{{ route('jibonjoyi_details', ['id' => $story->id]) }}"
                                                class="cats_item" style="margin-top: 0px; font-weight: lighter;">
                                                {{ $story->story_writer }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="rating-section"
                                        style="display: flex; align-items: center; margin-bottom: 30px; font-size: 14px;">
                                        <h3
                                            style="font-size: 12px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer; margin-top: -30%;">
                                            {{ $story->story_category }}
                                        </h3>
                                        <div
                                            style="display: flex; align-items: center; color: #6c757d; margin-left: 0; margin-top: -30%;">
                                            <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                                style="width: 10px; height: 10px; margin-right: 5px;">
                                            <span style="font-size: 10px;">{{ $story->story_rating }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
@endforeach -->

                        <aside class="columns_sidebar">
                            <div class="sidebar_widget">
                                <div class="popular">
                                    <h3
                                        style="font-size: 15px; background-color: #4045A3; color: white; display: inline-block; padding: 5px; border-radius: 10px;">
                                        সর্বশেষ</h3>
                                    @foreach ($lastSixStories as $story)
                                        <div class="popular_item" style="margin-bottom: -25px;">
                                            <div class="popular_item_img">
                                                <a href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                                    <img data-src="{{ asset('storage/' . $story->banner) }}"
                                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
                                                        alt="" style="border-radius: 10px; width: 140px; height: auto;" />
                                                </a>
                                            </div>
                                            <div class="popular_item_cont">
                                                <div class="popular_item_title"
                                                    style="font-size: 12px; font-weight: bold; margin-bottom: 0;">
                                                    <a
                                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">{{ $story->story_title }}</a>
                                                    <div class="popular_item_infoline infoline"
                                                        style="display: flex; align-items: center; margin-top: 0;">
                                                        <img src="{{ url('frontend/img/w1.png') }}" alt="" />
                                                        <a href="https://en.wikipedia.org/wiki/Sarat_Chandra_Chattopadhyay"
                                                            class="cats_item"
                                                            style="margin-top: -2px;font-weight: lighter;">{{ $story->story_writer }}</a>
                                                    </div>
                                                </div>

                                                <!-- Rating Section -->
                                                <div class="rating-section"
                                                    style="display: flex; align-items: center; margin-bottom: 30px; font-size: 14px;">
                                                    <h3
                                                        style="font-size: 12px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer;">
                                                        {{ $story->story_category }}
                                                    </h3>
                                                    <h3
                                                        style="font-size: 12px; background-color: #FFF5F5; color: #DC8D8D; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer;">
                                                        {{ $story->story_category1 }}
                                                    </h3>

                                                    <!-- Trigger Star for Popup -->
                                                    <div class="rating-trigger" data-story-id="{{ $story->id }}"
                                                        style="display: flex; align-items: center; cursor: pointer; margin-left: 10px;">
                                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                                            style="width: 20px; height: 20px; margin-right: 5px;">
                                                        <span style="font-size: 10px;">{{ $story->story_rating }}</span>
                                                    </div>
                                                </div>

                                                <!-- Rating Popup Modal (Unique IDs for Each Story) -->
                                                <div id="ratingModal-{{ $story->id }}" class="rating-modal"
                                                    style="display: none; position: fixed; top: 50%; left: 50%; 
                                                                                                                                                    transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 10px; 
                                                                                                                                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 1000; text-align: center;">
                                                    <h3 style="margin-bottom: 15px;">Rate "{{ $story->story_title }}"
                                                    </h3>

                                                    <!-- 5 Stars for Final Rating Selection -->
                                                    <div class="popup-stars" data-story-id="{{ $story->id }}"
                                                        style="display: flex; justify-content: center; gap: 10px; margin-bottom: 15px;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                                                class="popup-star" data-value="{{ $i }}"
                                                                style="width: 30px; height: 30px; cursor: pointer; opacity: 0.5;">
                                                        @endfor
                                                    </div>

                                                    <!-- Close Button -->
                                                    <button class="closeModal" data-story-id="{{ $story->id }}"
                                                        style="padding: 8px 16px; background-color: #6941C6; color: white; border: none; 
                                                                                                                                                            border-radius: 5px; cursor: pointer;">Cancel</button>
                                                </div>

                                                <!-- Modal Background Overlay (Unique ID) -->
                                                <div id="modalOverlay-{{ $story->id }}" class="modalOverlay"
                                                    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                                                                                                                                                     background: rgba(0, 0, 0, 0.5); z-index: 999;">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                    <h3
                                        style="font-size: 15px; background-color: #4045A3; color: white; display: inline-block; padding: 5px 5px; border-radius: 10px;">
                                        সবচেয়ে পঠিত</h3>

                                    @foreach ($mostReadStories as $story)
                                        <div class="popular_item" style="margin-bottom: -25px;">
                                            <div class="popular_item_img">
                                                <a href="{{ route('incrementClickCount', ['id' => $story->id]) }}">
                                                    <img data-src="{{ asset('storage/' . $story->banner) }}"
                                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
                                                        alt="" style="border-radius: 10px; width: 140px; height: auto;" />
                                                </a>
                                            </div>
                                            <div class="popular_item_cont">
                                                <div class="popular_item_title"
                                                    style="font-size: 12px; font-weight: bold; margin-bottom: 0;">
                                                    <a
                                                        href="{{ route('incrementClickCount', ['id' => $story->id]) }}">{{ $story->story_title }}</a>
                                                    <div class="popular_item_infoline infoline"
                                                        style="display: flex; align-items: center; margin-top: 0;">
                                                        <img src="{{ url('frontend/img/w1.png') }}" alt="" />
                                                        <a href="https://en.wikipedia.org/wiki/Sarat_Chandra_Chattopadhyay"
                                                            class="cats_item"
                                                            style="margin-top: -2px;font-weight: lighter;">{{ $story->story_writer }}</a>
                                                    </div>
                                                </div>

                                                <!-- Rating Section -->
                                                <div class="rating-section"
                                                    style="display: flex; align-items: center; margin-bottom: 30px; font-size: 14px;">
                                                    <h3
                                                        style="font-size: 12px; background-color: #F9F5FF; color: #6941C6; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer;">
                                                        {{ $story->story_category }}
                                                    </h3>
                                                    <h3
                                                        style="font-size: 12px; background-color: #FFF5F5; color: #DC8D8D; display: inline-block; padding: 5px 10px; border-radius: 10px; margin: 0; cursor: pointer;">
                                                        {{ $story->story_category1 }}
                                                    </h3>

                                                    <!-- Trigger Star for Popup -->
                                                    <div class="rating-trigger" data-story-id="{{ $story->id }}"
                                                        style="display: flex; align-items: center; cursor: pointer; margin-left: 10px;">
                                                        <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                                            style="width: 20px; height: 20px; margin-right: 5px;">
                                                        <span style="font-size: 10px;">{{ $story->story_rating }}</span>
                                                    </div>
                                                </div>

                                                <!-- Rating Popup Modal (Unique IDs for Each Story) -->
                                                <div id="ratingModal-{{ $story->id }}" class="rating-modal"
                                                    style="display: none; position: fixed; top: 50%; left: 50%; 
                                                                                                                                                    transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 10px; 
                                                                                                                                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 1000; text-align: center;">
                                                    <h3 style="margin-bottom: 15px;">Rate "{{ $story->story_title }}"
                                                    </h3>

                                                    <!-- 5 Stars for Final Rating Selection -->
                                                    <div class="popup-stars" data-story-id="{{ $story->id }}"
                                                        style="display: flex; justify-content: center; gap: 10px; margin-bottom: 15px;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <img src="{{ url('frontend/img/Star.png') }}" alt="Star"
                                                                class="popup-star" data-value="{{ $i }}"
                                                                style="width: 30px; height: 30px; cursor: pointer; opacity: 0.5;">
                                                        @endfor
                                                    </div>

                                                    <!-- Close Button -->
                                                    <button class="closeModal" data-story-id="{{ $story->id }}"
                                                        style="padding: 8px 16px; background-color: #6941C6; color: white; border: none; 
                                                                                                                                                            border-radius: 5px; cursor: pointer;">Cancel</button>
                                                </div>

                                                <!-- Modal Background Overlay (Unique ID) -->
                                                <div id="modalOverlay-{{ $story->id }}" class="modalOverlay"
                                                    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                                                                                                                                                     background: rgba(0, 0, 0, 0.5); z-index: 999;">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>

                            <div class="space-bottom2234">
                                <a href="#">
                                    <img src="{{ asset('storage/' . $ad->horizontal_ad) }}" alt="Vertical Ad 1" />
                                </a>
                            </div>

                            <div class="poll-container">
                                <h3>আজকের জরিপ ০১</h3>
                                <p>{{ $survey->question }}</p>
                                <form id="pollForm" method="POST" action="{{ route('survey.vote') }}">
                                    @csrf
                                    <div class="option">
                                        <label class="custom-checkbox">
                                            <input type="radio" name="poet" value="opt1" required>
                                            <span class="option-text">{{ $survey->opt1 }}</span>
                                            <span class="percentage">{{ $survey->opt1_count }}%</span>
                                        </label>
                                    </div>
                                    <div class="option">
                                        <label class="custom-checkbox">
                                            <input type="radio" name="poet" value="opt2">
                                            <span class="option-text">{{ $survey->opt2 }}</span>
                                            <span class="percentage">{{ $survey->opt2_count }}%</span>
                                        </label>
                                    </div>
                                    @if ($survey->opt3)
                                        <div class="option">
                                            <label class="custom-checkbox">
                                                <input type="radio" name="poet" value="opt3">
                                                <span class="option-text">{{ $survey->opt3 }}</span>
                                                <span class="percentage">{{ $survey->opt3_count }}%</span>
                                            </label>
                                        </div>
                                    @endif
                                    @if ($survey->opt4)
                                        <div class="option">
                                            <label class="custom-checkbox">
                                                <input type="radio" name="poet" value="opt4">
                                                <span class="option-text">{{ $survey->opt4 }}</span>
                                                <span class="percentage">{{ $survey->opt4_count }}%</span>
                                            </label>
                                        </div>
                                    @endif
                                    <button type="submit" id="submitBtn">মতামত প্রদান</button>
                                </form>

                                @if (session('success'))
                                    <p style="color: green;">{{ session('success') }}</p>
                                @endif


                                @if (session('success'))
                                    <p style="color: green;">{{ session('success') }}</p>
                                @endif
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
                                    <button type="button" id="submitBtn">মতামত প্রদান</button>
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
            @if ($bani)
                <div class="container1">
                    <div class="headerr">
                        <h1 style="color: #0056b3;text-decoration: underline;">আজকের বাণী</h1>
                        <p class="quote">{{ $bani->bani }}</p>
                        <p class="quote">- {{ $bani->bani_writer }}</p>
                    </div>
                </div>
            @endif
        </main>
        <!-- CONTENT EOF   -->
        <!-- BEGIN HEADER -->

        <!-- HEADER EOF   -->
        <!-- BEGIN FOOTER -->


    </div>
    <footer class="footer">
        <div class="footer-wrapper">
            <div class="notice-container">
                <div class="static-text"  style="font-size:calc(1vw + .8rem); ">বিভাগের নোটিশ:</div>
                <div class="scrolling-text" id="scrollingText" style="font-size:calc(1vw + .8rem); ">
                 
                </div>
            </div>
   
        </div>

        <div style="max-height: 200px;">
          
                <div class="static-text1" style="font-size:calc(.8vw + .8rem);padding:20px ">সর্বস্বর্ত্ব ২০২৪-২০২৫ জীবনজয়ী</div>
            
        </div>

        <script>
            const scrollingText = document.getElementById('scrollingText');

            // ✅ Since we already filtered footers in the controller, no need to check status here
            const messages = @json($footer_index->pluck('text'));

            // Combine all messages into one string separated by ' | '
            const combinedMessage = messages.join(' | ');

            // Set the combined message as the scrolling text
            scrollingText.textContent = combinedMessage;

            // Adjust the animation duration dynamically based on text length
            function adjustScrollingSpeed() {
                const noticeContainer = document.querySelector('.notice-container');
                const textWidth = scrollingText.offsetWidth;
                const containerWidth = noticeContainer.offsetWidth;
                const duration = (textWidth / containerWidth) * 15; // Adjust speed if needed
                scrollingText.style.animationDuration = `${duration}s`;
            }

            // Initialize on page load
            window.onload = adjustScrollingSpeed;

            // Recalculate on window resize
            window.onresize = () => {
                scrollingText.style.animation = 'none'; // Reset animation
                void scrollingText.offsetWidth; // Trigger reflow
                adjustScrollingSpeed(); // Reapply animation with new duration
            };
        </script>
    </footer>


    <!-- FOOTER EOF   -->
    <div class="overlay"></div>
    </div>
    <!-- BODY EOF   -->
    <script src="{{ url('frontend/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ url('frontend/js/custom.js') }}"></script>

    <!-- JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const shareBtn = document.getElementById("shareBtn");
        const shareModal = document.getElementById("shareModal");
        const closeModal = document.getElementById("closeModal");
        const copyLink = document.getElementById("copyLink");
        const postUrl = document.getElementById("postUrl");

        // Get current URL
        const currentUrl = window.location.href;
        postUrl.value = currentUrl;

        // Set social media share links
        document.getElementById("whatsappShare").href = `https://wa.me/?text=${encodeURIComponent(currentUrl)}`;
        document.getElementById("facebookShare").href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`;
        document.getElementById("twitterShare").href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(currentUrl)}`;
        document.getElementById("emailShare").href = `mailto:?subject=Check this out!&body=${encodeURIComponent(currentUrl)}`;
        // document.getElementById("redditShare").href = `https://www.reddit.com/submit?url=${encodeURIComponent(currentUrl)}`;

        // Show modal
        shareBtn.addEventListener("click", () => {
            shareModal.style.display = "flex";
        });

        // Close modal
        closeModal.addEventListener("click", () => {
            shareModal.style.display = "none";
        });

        // Copy link to clipboard
        copyLink.addEventListener("click", () => {
            navigator.clipboard.writeText(postUrl.value);
            alert("Link copied!");
        });
    });
</script>


</body>

</html>