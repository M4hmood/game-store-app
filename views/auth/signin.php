<!-- Sign In Form -->
<main class="form-container">
  <div class="form-box">
    <h1 class="form-title">ACCESS TERMINAL</h1>

    <form action="#" method="post">
      <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-input" placeholder="runner@nexus.net" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-input" placeholder="••••••••••••" required>
      </div>

      <div class="form-options">
        <label class="checkbox-label">
          <input type="checkbox" name="remember">
          <span>Remember me</span>
        </label>
        <a href="#">Forgot password?</a>
      </div>

      <button type="submit" class="btn btn-primary btn-full">Initialize Connection</button>
    </form>

    <div class="form-divider">
      <span>OR</span>
    </div>

    <div class="social-buttons">
      <a href="#" class="btn btn-secondary btn-full">Continue with Google</a>
      <a href="#" class="btn btn-secondary btn-full">Continue with Steam</a>
      <a href="#" class="btn btn-secondary btn-full">Continue with PSN</a>
    </div>

    <p class="form-footer">
      New to the network? <a href="signup.html">Create an account</a>
    </p>
  </div>
</main>