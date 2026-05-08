<div class="page-header">
    <h1>File a Claim</h1>
    <p>We're here to help. Submit your claim quickly and easily.</p>
</div>

<div class="form-container">
    <form method="POST" action="api/file_claim.php" class="claim-form">
        <fieldset>
            <legend>Claim Information</legend>
            
            <div class="form-group">
                <label for="claim_type">Claim Type *</label>
                <select id="claim_type" name="claim_type" required>
                    <option value="">Select claim type</option>
                    <option value="medical">Medical Claim</option>
                    <option value="accident">Accident Claim</option>
                    <option value="property">Property Damage</option>
                    <option value="theft">Theft/Loss</option>
                </select>
            </div>

            <div class="form-group">
                <label for="claim_date">Date of Incident *</label>
                <input type="date" id="claim_date" name="claim_date" required>
            </div>

            <div class="form-group">
                <label for="claim_amount">Claimed Amount *</label>
                <input type="number" id="claim_amount" name="claim_amount" required min="0" placeholder="0.00">
            </div>
        </fieldset>

        <fieldset>
            <legend>Your Information</legend>
            
            <div class="form-group">
                <label for="policy_number">Policy Number *</label>
                <input type="text" id="policy_number" name="policy_number" required placeholder="INC-XXXXXXX-XXXX">
            </div>

            <div class="form-group">
                <label for="claimant_name">Full Name *</label>
                <input type="text" id="claimant_name" name="claimant_name" required placeholder="John Doe">
            </div>

            <div class="form-group">
                <label for="claimant_email">Email *</label>
                <input type="email" id="claimant_email" name="claimant_email" required placeholder="john@example.com">
            </div>
        </fieldset>

        <fieldset>
            <legend>Claim Details</legend>
            
            <div class="form-group">
                <label for="description">Detailed Description of Claim *</label>
                <textarea id="description" name="description" rows="6" required placeholder="Please provide a detailed description of what happened..."></textarea>
            </div>

            <div class="form-group">
                <label for="supporting_info">Supporting Information</label>
                <input type="text" id="supporting_info" name="supporting_info" placeholder="Reference numbers, witness info, etc.">
            </div>
        </fieldset>

        <button type="submit" class="submit-btn">Submit Claim</button>
    </form>

    <div id="claim-status" class="claim-status hidden">
        <h3>Claim Submitted</h3>
        <p id="status-message"></p>
    </div>
</div>

<script>
document.querySelector('.claim-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('api/file_claim.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('status-message').innerHTML = data;
        document.getElementById('claim-status').classList.remove('hidden');
        gsap.to('.claim-status', { opacity: 1, duration: 0.5, delay: 0.2 });
    })
    .catch(error => console.error('Error:', error));
});
</script>
