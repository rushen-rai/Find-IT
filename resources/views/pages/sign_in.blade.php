<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Find IT – Sign In</title>

  <!-- Global Styles -->
  <link rel="stylesheet" href="{{ asset('css/base.css') }}">
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

  <!-- Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Merriweather:wght@400&display=swap"
    rel="stylesheet"
  />

  <!-- Icons -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
  />

</head>
<body>
  <main class="container">
    
    <!-- LEFT SECTION -->
    <section class="info">
      <header class="info__header">
        <img src="{{ asset('images/logo.png') }}" alt="Find IT Logo" class="info__logo">
        <div class="info__title-group">
          <h1 class="info__title">Find IT</h1>
          <p class="info__subtitle">UNP Lost & Found</p>
        </div>
      </header>

      <p class="info__intro">
        A centralized digital platform to report, search, and reclaim lost items across campus.
      </p>

      <!-- Feature 1 -->
      <div class="feature">
        <div class="feature__icon">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div>
          <h3 class="feature__title">Smart Matching</h3>
          <p class="feature__text">Automated notifications when potential matches are found.</p>
        </div>
      </div>

      <!-- Feature 2 -->
      <div class="feature">
        <div class="feature__icon">
          <i class="fa-solid fa-shield"></i>
        </div>
        <div>
          <h3 class="feature__title">Secure Verification</h3>
          <p class="feature__text">Admin-approved claims with proper verification process.</p>
        </div>
      </div>

      <!-- Feature 3 -->
      <div class="feature feature--highlight">
        <div class="feature__icon feature__icon--yellow">
          <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div>
          <h3 class="feature__title">Priority Handling</h3>
          <p class="feature__text">High-value items get immediate attention and tracking.</p>
        </div>
      </div>
    </section>

    <!-- RIGHT SECTION -->
    <section class="auth">
      <h2 class="auth__title">Welcome Back</h2>
      <p class="auth__subtitle">Log in to your UNP Lost & Found account</p>

      @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 15px; color: red; font-weight: bold;">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 15px; color: green; font-weight: bold;">
          {{ session('success') }}
        </div>
      @endif

      <form class="auth__form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
          <label for="email" class="form-group__label">Email Address</label>
          <input 
            type="email" 
            name="email" 
            id="email" 
            placeholder="Enter your email" 
            class="form-group__input" 
            autocomplete="email" 
            required 
          />
        </div>

        <div class="form-group">
          <label for="password" class="form-group__label">Password</label>
          <input 
            type="password" 
            name="password" 
            id="password" 
            placeholder="Enter your password" 
            class="form-group__input" 
            autocomplete="current-password" 
            required 
          />
        </div>

        <button type="submit" class="btn btn--primary">Sign In</button>
      </form>


      <div class="auth__divider">OR</div>

      <p class="auth__signup">
        Don’t have an account? <a href="{{ url('/') }}" class="auth__link">Sign Up</a>
      </p>

    </section>

  </main>
  <script src="{{ asset('js/rate_limiter.js') }}"></script>
</body>
</html>