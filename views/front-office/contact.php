<!-- Contact Form Section -->
<div class="form-container">
    <div class="form-box">
        <h2 class="form-title">Contact us</h2>
        <form action="#" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Your full name" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com" required>
                </div>
            </div>

            <div class="form-group">
                <label for="subject" class="form-label">Subject</label>
                <select id="subject" name="subject" class="form-input" required>
                    <option value="" disabled selected>Choose a topic...</option>
                    <option value="support">Technical support</option>
                    <option value="billing">Billing issue</option>
                    <option value="partnership">Partnership inquiry</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="message" class="form-label">Message</label>
                <textarea id="message" name="message" class="form-input" rows="5"
                    placeholder="How can we help?" required></textarea>
            </div>

            <div class="form-checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="newsletter" checked>
                    <span>Subscribe to product updates and news</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-full btn-lg">Send message</button>
        </form>
    </div>
</div>
