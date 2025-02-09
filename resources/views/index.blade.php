<!doctype html>
<html lang="en">

<!-- Mirrored from jj.c3bit.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Feb 2025 05:51:06 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>জীবনজয়ী</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="{{url('frontend/css/home.css')}}">

</head>

<body>
  <div class="top-bar" id="topBar">
    <div class="logo">
      <a href="index.html">
        <img src="{{ url('frontend/img/jibonjoyi.png') }}" alt="Logo" class="logo">
      </a>
      <div class="user-info">
        @if(session()->has('username'))
        <p>Welcome, <strong>{{ session('username') }}</strong>!</p>
        <a href="{{ route('logout') }}" class="logout-btn">Logout</a>
        @else
        <a href="{{ route('signin') }}" class="login-btn">Sign In</a>
        @endif
      </div>
    </div>
    <div class="icons">
      <i class="fas fa-search" title="Search"></i>
      <i class="fas fa-bars" title="Menu" onclick="toggleMenu()"></i>
    </div>
  </div>

  <!-- Slide-in Menu from Right -->
  <div class="menu" id="menu">
    <div class="menu-content">
      <div class="menu-section">
        <h3><a href="index.html">
            <img src="{{ url('frontend/img/jibonjoyi.png') }}" alt="Logo" class="logo">
          </a></h3>
        <ul>
          <li><a href="#">আমাদের সম্পর্কে</a></li>
          <li><a href="#">যোগাযোগ</a></li>
          <li><a href="#">লিখতে চান?</a></li>
          <li><a href="#">পোলাসীতার নীতি</a></li>
        </ul>
      </div>
      <div class="menu-section">
        <h3>সব বিভাগ</h3>
        <ul>
          <li><strong>ইতিহাস</strong>
            <ul>
              <li><a href="#">বৃহত্যান্ত</a></li>
              <li><a href="#">জাতীয়নত্রিক ইতিহাস</a></li>
              <li><a href="#">ল্যাটিন আমেরিকার ইতিহাস</a></li>
            </ul>
          </li>
          <li><strong>অভয়ণ</strong>
            <ul>
              <li><a href="#">বাংলাদেশ</a></li>
              <li><a href="#">ভারত</a></li>
              <li><a href="#">দাইকান্ড</a></li>
            </ul>
          </li>
          <li><strong>রাজনীতি</strong>
            <ul>
              <li><a href="#">বাংলাদেশ</a></li>
              <li><a href="#">ভারত</a></li>
              <li><a href="#">দাইকান্ড</a></li>
            </ul>
          </li>
          <li><strong>খেলা</strong>
            <ul>
              <li><a href="#">ক্রিকেট</a></li>
              <li><a href="#">ফুটবল</a></li>
              <li><a href="#">রাগবী</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <script>
    function toggleMenu() {
      const menu = document.getElementById('menu');
      const topBar = document.getElementById('topBar');
      menu.classList.toggle('active');
      topBar.classList.toggle('hidden');
    }

    document.addEventListener("click", function(event) {
      const menu = document.getElementById('menu');
      const topBar = document.getElementById('topBar');
      const menuContent = document.querySelector(".menu-content");
      const menuIcon = document.querySelector(".fa-bars");

      if (!menuContent.contains(event.target) && !menuIcon.contains(event.target)) {
        menu.classList.remove("active");
        topBar.classList.remove("hidden");
      }
    });
  </script>

  <div class="menu-search">

    <div class="pc-section">
      <div class="hero pc">
        <img class="background-image" src="{{url('frontend/img/home.png')}}" alt="Tree Background">
      </div>
      <div class="btn-menu">
        <button type="button" class=" btn1-pc btn btn-danger" onclick="window.location.href='{{ route('history') }}'">ইতিহাস</button>
        <button type="button" class=" btn2-pc btn btn-danger" onclick="window.location.href='{{ route('sports') }}'">খেলাধূলা</button>
        <button type="button" class=" btn3-pc btn btn-info" onclick="window.location.href='{{ route('travel') }}'">ভ্রমণ</button>
        <button type="button" class=" btn4-pc btn btn-info" onclick="window.location.href='{{ route('liberation') }}'">মুক্তিযুদ্ধ</button>
        <button type="button" class=" btn5-pc btn btn-warning" onclick="window.location.href='{{ route('literature') }}'">সাহিত্য</button>
        <button type="button" class=" btn6-pc btn btn-success" onclick="window.location.href='{{ route('philosophy') }}'">দর্শন</button>
        <button type="button" class=" btn7-pc btn btn-success" onclick="window.location.href='{{ route('religion') }}'">ধর্ম</button>
        <button type="button" class=" btn8-pc btn btn-warning" onclick="window.location.href='{{ route('science') }}'">বিজ্ঞান</button>
        <button type="button" class=" btn9-pc btn btn-primary" onclick="window.location.href='{{ route('economy') }}'">অর্থনীতি</button>
        <button type="button" class=" btn10-pc btn btn-primary" onclick="window.location.href='{{ route('world') }}'">বিশ্ব</button>
        <button type="button" class=" btn11-pc btn btn-primary">রাজনীতি</button>
      </div>
    </div>

    <div class="phone-section">
      <div class="hero phon">
        <img src="{{ url('frontend/img/homes.png') }}" alt="Phone View" class="img-fluid">
      </div>
      <div class="btn-menu">
        <button type="button" class=" btn1-phon btn btn-danger" onclick="window.location.href='{{ route('history') }}'">ইতিহাস</button>
        <button type="button" class=" btn2-phon btn btn-danger" onclick="window.location.href='{{ route('sports') }}'">খেলাধূলা</button>
        <button type="button" class=" btn3-phon btn btn-info" onclick="window.location.href='{{ route('travel') }}'">ভ্রমণ</button>
        <button type="button" class=" btn4-phon btn btn-info" onclick="window.location.href='{{ route('liberation') }}'">মুক্তিযুদ্ধ</button>
        <button type="button" class=" btn5-phon btn btn-warning" onclick="window.location.href='{{ route('literature') }}'">সাহিত্য</button>
        <button type="button" class=" btn6-phon btn btn-success" onclick="window.location.href='{{ route('philosophy') }}'">দর্শন</button>
        <button type="button" class=" btn7-phon btn btn-success" onclick="window.location.href='{{ route('religion') }}'">ধর্ম</button>
        <button type="button" class=" btn8-phon btn btn-warning" onclick="window.location.href='{{ route('science') }}'">বিজ্ঞান</button>
        <button type="button" class=" btn9-phon btn btn-primary" onclick="window.location.href='{{ route('economy') }}'">অর্থনীতি</button>
        <button type="button" class=" btn10-phon btn btn-info">বিশ্ব</button>
        <button type="button" class=" btn11-phon btn btn-info">রাজনীতি</button>
      </div>
    </div>
    <p>সর্বস্বর্ত্ব সংরক্ষিত © ২০২৪ জীবনজয়ী</p>
  </div>
  <script src="../cdn.jsdelivr.net/npm/bootstrap%405.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

<!-- Mirrored from jj.c3bit.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Feb 2025 05:51:08 GMT -->

</html>