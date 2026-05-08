<div class="page-header">
    <h1>Contact Us</h1>
    <p>Get in touch with our team. We're here to help!</p>
</div>

<div class="contact-container">
    <div class="contact-info">
        <div class="info-card">
            <h3>📍 Address</h3>
            <p>
                Inception Inc. Insurance<br>
                123 Insurance Boulevard<br>
                San Francisco, CA 94102<br>
                United States
            </p>
        </div>
        <div class="info-card">
            <h3>📞 Phone</h3>
            <p>
                Main: +1 (800) 555-0123<br>
                Support: +1 (800) 555-0124<br>
                Claims: +1 (800) 555-0125<br>
                Hours: 24/7
            </p>
        </div>
        <div class="info-card">
            <h3>✉️ Email</h3>
            <p>
                General: info@inceptioninc.local<br>
                Support: support@inceptioninc.local<br>
                Claims: claims@inceptioninc.local<br>
                Sales: sales@inceptioninc.local
            </p>
        </div>
    </div>

    <div class="contact-form-wrapper">
        <h2>Send us a Message</h2>
        <form method="POST" action="api/send_message.php" class="contact-form">
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" required placeholder="Your name">
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required placeholder="your@email.com">
            </div>

            <div class="form-group">
                <label for="subject">Subject *</label>
                <input type="text" id="subject" name="subject" required placeholder="How can we help?">
            </div>

            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message" rows="6" required placeholder="Your message..."></textarea>
            </div>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>

        <div id="message-status" class="message-status hidden">
            <p id="message-response"></p>
        </div>
    </div>
</div>

<script>
document.querySelector('.contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('api/send_message.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('message-response').innerHTML = data;
        document.getElementById('message-status').classList.remove('hidden');
        gsap.to('.message-status', { opacity: 1, duration: 0.5 });
    })
    .catch(error => console.error('Error:', error));
});
</script>
