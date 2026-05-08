<div class="page-header">
    <h1>Get Your Insurance Quote</h1>
    <p>Fill out the form below to receive a personalized quote</p>
</div>

<div class="form-container">
    <form method="POST" action="api/process_quote.php" class="quote-form">
        <div class="form-group">
            <label for="fullname">Full Name *</label>
            <input type="text" id="fullname" name="fullname" required placeholder="John Doe">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" required placeholder="john@example.com">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="(555) 123-4567">
            </div>
        </div>

        <div class="form-group">
            <label for="coverage_type">Coverage Type *</label>
            <select id="coverage_type" name="coverage_type" required>
                <option value="">Select a coverage type</option>
                <option value="health">Health Insurance</option>
                <option value="auto">Auto Insurance</option>
                <option value="home">Home Insurance</option>
                <option value="life">Life Insurance</option>
                <option value="travel">Travel Insurance</option>
            </select>
        </div>

        <div class="form-group">
            <label for="coverage_amount">Desired Coverage Amount *</label>
            <input type="number" id="coverage_amount" name="coverage_amount" required min="10000" placeholder="50000">
        </div>

        <!-- VULNERABLE PARAMETER: policy_reference -->
        <div class="form-group">
            <label for="policy_reference">Policy Reference (Optional)</label>
            <input type="text" id="policy_reference" name="policy_reference" placeholder="e.g., INC-2024-001">
            <small>Enter your existing policy reference if you have one. Format validation is performed server-side.</small>
        </div>

        <div class="form-group">
            <label for="comments">Additional Comments</label>
            <textarea id="comments" name="comments" rows="4" placeholder="Tell us more about your insurance needs..."></textarea>
        </div>

        <button type="submit" class="submit-btn">Get Quote</button>
    </form>

    <div id="quote-result" class="quote-result hidden">
        <h3>Your Quote</h3>
        <div id="result-content"></div>
    </div>
</div>

<script>
document.querySelector('.quote-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('api/process_quote.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('result-content').innerHTML = data;
        document.getElementById('quote-result').classList.remove('hidden');
        gsap.to('.quote-result', { opacity: 1, duration: 0.5, delay: 0.2 });
    })
    .catch(error => console.error('Error:', error));
});
</script>
