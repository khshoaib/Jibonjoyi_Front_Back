<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<x-head />

<body>

    <section class="auth bg-base d-flex flex-wrap">
        <div class="auth-left d-lg-block d-none">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center">
                <img src="{{ asset('assets/images/homes.png') }}" alt="">
            </div>
        </div>
        <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    <a href="{{ route('index') }}" class="mb-40 max-w-290-px">
                        <img src="{{ asset('assets/images/home.png') }}" alt="">
                    </a>
                    <h4 class="mb-12">Sign Up to your Account</h4>
                    <p class="mb-32 text-secondary-light text-lg">Welcome back! please enter your detail</p>
                </div>
                <form action="{{ route('signup.store') }}" method="POST" id="signup-form">
                    @csrf <!-- Add CSRF token for security -->
                    <div class="icon-field mb-16">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="f7:person"></iconify-icon>
                        </span>
                        <input type="text" name="username" class="form-control h-56-px bg-neutral-50 radius-12"
                            placeholder="Username" id="username" required>
                    </div>

                    <div class="icon-field mb-16">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:email"></iconify-icon>
                        </span>
                        <input type="email" name="email" class="form-control h-56-px bg-neutral-50 radius-12"
                            placeholder="Email" id="email" required>
                    </div>

                    <div class="mb-20">
                        <div class="position-relative">
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y">
                                    <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                </span>
                                <input type="password" name="password"
                                    class="form-control h-56-px bg-neutral-50 radius-12" id="password"
                                    placeholder="Password" required>
                            </div>
                        </div>
                        <span class="mt-12 text-sm text-secondary-light">Your password must have at least 8
                            characters</span>
                    </div>

                    <div>
                        <div class="form-check style-check d-flex align-items-start">
                            <input class="form-check-input border border-neutral-300 mt-4" type="checkbox"
                                id="condition" required>
                            <label class="form-check-label text-sm" for="condition">
                                By creating an account, you agree to the
                                <a href="javascript:void(0)" class="text-primary-600 fw-semibold">Terms & Conditions</a>
                                and our
                                <a href="javascript:void(0)" class="text-primary-600 fw-semibold">Privacy Policy</a>.
                            </label>
                        </div>
                    </div>

                    <div class="mt-32 center-border-horizontal text-center">
                        <span class="bg-base z-1 px-4">Or sign up with</span>
                    </div>
                    <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32"
                        id="signup-button" disabled>Sign Up</button>

                    <!-- Show messages below the sign-in button -->
                    @if (session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-32 d-flex align-items-center gap-3">
                        <a href="https://www.facebook.com" target="_blank" class="w-50">
                            <button type="button"
                                class="fw-semibold text-primary-light py-16 px-24 w-100 border radius-12 text-md d-flex align-items-center justify-content-center gap-12 line-height-1 bg-hover-primary-50">
                                <iconify-icon icon="ic:baseline-facebook"
                                    class="text-primary-600 text-xl line-height-1"></iconify-icon>
                                Facebook
                            </button>
                        </a>
                        <a href="https://accounts.google.com" target="_blank" class="w-50">
                            <button type="button"
                                class="fw-semibold text-primary-light py-16 px-24 w-100 border radius-12 text-md d-flex align-items-center justify-content-center gap-12 line-height-1 bg-hover-primary-50">
                                <iconify-icon icon="logos:google-icon"
                                    class="text-primary-600 text-xl line-height-1"></iconify-icon>
                                Google
                            </button>
                        </a>
                    </div>

                    <div class="mt-32 text-center text-sm">
                        <p class="mb-0">Already have an account?<a href="{{ route('signin') }}"
                                class="text-primary-600 fw-semibold">Sign in</a></p>
                    </div>
                </form>

                <!-- JavaScript for validation -->
                <script>
                    document.getElementById('signup-form').addEventListener('input', function () {
                        const username = document.getElementById('username').value;
                        const email = document.getElementById('email').value;
                        const password = document.getElementById('password').value;
                        const condition = document.getElementById('condition').checked;

                        const submitButton = document.getElementById('signup-button');

                        // Enable the submit button only if all fields are filled and condition is checked
                        if (username && email && password.length >= 8 && condition) {
                            submitButton.disabled = false;
                        } else {
                            submitButton.disabled = true;
                        }
                    });

                    document.getElementById('signup-form').addEventListener('submit', function (event) {
                        const username = document.getElementById('username').value;
                        const email = document.getElementById('email').value;
                        const password = document.getElementById('password').value;
                        const condition = document.getElementById('condition').checked;

                        if (!username || !email || password.length < 8 || !condition) {
                            event.preventDefault(); // Prevent form submission if any field is invalid
                            alert('Please fill in all fields correctly.');
                        }
                    });
                </script>



            </div>
        </div>
    </section>

    @php
        $script = '<script>
                                                                                            // ================== Password Show Hide Js Start ==========
                                                                                            function initializePasswordToggle(toggleSelector) {
                                                                                                $(toggleSelector).on("click", function() {
                                                                                                    $(this).toggleClass("ri-eye-off-line");
                                                                                                    var input = $($(this).attr("data-toggle"));
                                                                                                    if (input.attr("type") === "password") {
                                                                                                        input.attr("type", "text");
                                                                                                    } else {
                                                                                                        input.attr("type", "password");
                                                                                                    }
                                                                                                });
                                                                                            }
                                                                                            // Call the function
                                                                                            initializePasswordToggle(".toggle-password");
                                                                                            // ========================= Password Show Hide Js End ===========================
                                                                                        </script>';
    @endphp

    <x-script />

</body>

</html>