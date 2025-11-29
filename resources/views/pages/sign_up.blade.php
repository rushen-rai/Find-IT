<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up – Find IT | UNP Lost & Found</title>

  <!-- Global Styles -->
  <link rel="stylesheet" href="{{ asset('css/base.css') }}">
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

  <!-- Fonts -->
  <link 
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Merriweather:wght@400&display=swap" 
    rel="stylesheet">

  <!-- Icons -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

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

      <!-- Feature List -->
      <div class="feature">
        <div class="feature__icon"><i class="fa-solid fa-magnifying-glass"></i></div>
        <div>
          <h3 class="feature__title">Smart Matching</h3>
          <p class="feature__text">Automated notifications when potential matches are found.</p>
        </div>
      </div>

      <div class="feature">
        <div class="feature__icon"><i class="fa-solid fa-shield"></i></div>
        <div>
          <h3 class="feature__title">Secure Verification</h3>
          <p class="feature__text">Admin-approved claims with proper verification process.</p>
        </div>
      </div>

      <div class="feature feature--highlight">
        <div class="feature__icon feature__icon--yellow"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div>
          <h3 class="feature__title">Priority Handling</h3>
          <p class="feature__text">High-value items get immediate attention and tracking.</p>
        </div>
      </div>
    </section>

    <!-- RIGHT SECTION -->
    <section class="auth">
      <h2 class="auth__title">Create Account</h2>
      <p class="auth__subtitle">Join the UNP Lost & Found community</p>

      <form class="auth__form" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
          <label for="name" class="form-group__label">Full Name</label>
          <input 
            type="text" 
            name="name" 
            id="name" 
            placeholder="Enter your full name" 
            class="form-group__input" 
            autocomplete="name" 
            required 
          />
        </div>

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
            autocomplete="new-password" 
            required 
          />
        </div>

        <div class="form-group">
          <label for="role" class="form-group__label">Account Type</label>
          <select 
            name="role" 
            id="role" 
            class="form-group__input" 
            autocomplete="off" 
            required
          >
            <option value="" disabled selected>Select account type</option>
            <option value="user">Student</option>
            <option value="admin">Administrator</option>
          </select>
        </div>

        <button type="submit" class="btn btn--primary">Sign Up</button>
      </form>

      <div class="divider">OR</div>

      <p class="auth__signup">
        Already have an account? <a href="{{ url('/sign-in') }}" class="auth__link">Sign In</a>
      </p>

    </section>

  </main>
</body>
</html>