<!-- Sign Up Form -->
<main class="form-container">
  <div class="form-box">
    <h1 class="form-title">JOIN THE NETWORK</h1>

    <form action="#" method="post">
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="firstname">First Name</label>
          <input type="text" id="firstname" name="firstname" class="form-input" placeholder="Johnny" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="lastname">Last Name</label>
          <input type="text" id="lastname" name="lastname" class="form-input" placeholder="Silverhand" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="username">Username</label>
        <input type="text" id="username" name="username" class="form-input" placeholder="netrunner_2077" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-input" placeholder="runner@nexus.net" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-input" placeholder="Minimum 8 characters"
          required minlength="8">
      </div>

      <div class="form-group">
        <label class="form-label" for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" class="form-input"
          placeholder="Re-enter your password" required>
      </div>

      <div class="form-checkbox-group">
        <label class="checkbox-label">
          <input type="checkbox" name="terms" required>
          <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
        </label>
      </div>

      <!-- <div class="form-checkbox-group">
          <label class="checkbox-label">
            <input type="checkbox" name="newsletter">
            <span>Send me news and special offers</span>
          </label>
        </div> -->

      <button type="submit" class="btn btn-primary btn-full">Create Neural Link</button>
    </form>

    <div class="form-divider">
      <span>OR</span>
    </div>

    <div class="social-buttons">
      <a href="#" class="btn btn-secondary btn-full">Continue with Google</a>
      <a href="#" class="btn btn-secondary btn-full">Continue with Steam</a>
      <!-- <a href="#" class="btn btn-secondary btn-full">Continue with PSN</a> -->
    </div>

    <p class="form-footer">
      Already connected? <a href="signin.html">Sign in</a>
    </p>
  </div>
</main>

</html>