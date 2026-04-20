<!-- Contact Form Section -->
<div class="form-container">
    <div class="form-box">
        <h2 class="form-title">Contact Us</h2>
        <form action="#" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="name" class="form-label">Codename / Name</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Enter your designation"
                        required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Neural Net ID / Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="user@net.city" required>
                </div>
            </div>

            <div class="form-group">
                <label for="subject" class="form-label">Transmission Subject</label>
                <select id="subject" name="subject" class="form-input" required>
                    <option value="" disabled selected>Select frequency...</option>
                    <option value="support">Technical Support</option>
                    <option value="billing">Credit Transfer Issue</option>
                    <option value="partnership">Alliance Request</option>
                    <option value="other">Other Signal</option>
                </select>
            </div>

            <div class="form-group">
                <label for="message" class="form-label">Encrypted Message</label>
                <textarea id="message" name="message" class="form-input" rows="5"
                    placeholder="Type your message here..." required></textarea>
            </div>

            <div class="form-checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="newsletter" checked>
                    <span>Subscribe to Neural Network updates and patch notes</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-full btn-lg">Transmit Data</button>
        </form>
    </div>
</div>