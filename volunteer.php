<?php
$successMessage = "";

function clean_input($data) {
    return htmlspecialchars(trim($data));
}

$vname = "";
$vphone = "";
$vlocation = "";
$support = "";
$availability = "";

$vnameError = "";
$vphoneError = "";
$vlocationError = "";
$supportError = "";
$availabilityError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vname = clean_input($_POST['vname'] ?? '');
    $vphone = clean_input($_POST['vphone'] ?? '');
    $vlocation = clean_input($_POST['vlocation'] ?? '');
    $support = clean_input($_POST['support'] ?? '');
    $availability = clean_input($_POST['availability'] ?? '');

    if ($vname === "") {
        $vnameError = "Full name is required";
    } elseif (!preg_match('/^[A-Za-z ]{3,30}$/', $vname)) {
        $vnameError = "Name must contain only letters and spaces (3 to 30 characters)";
    }

    if ($vphone === "") {
        $vphoneError = "Phone number is required";
    } elseif (!preg_match('/^[0-9]{10}$/', $vphone)) {
        $vphoneError = "Phone number must be exactly 10 digits";
    }

    if ($vlocation === "") {
        $vlocationError = "Location is required";
    } elseif (strlen($vlocation) < 3) {
        $vlocationError = "Location must be at least 3 characters";
    }

    if ($support === "") {
        $supportError = "Please select support type";
    }

    if ($availability === "") {
        $availabilityError = "Availability note is required";
    } elseif (strlen($availability) < 10) {
        $availabilityError = "Please enter at least 10 characters";
    }

    if ($vnameError === "" && $vphoneError === "" && $vlocationError === "" && $supportError === "" && $availabilityError === "") {
        $file = fopen("volunteers.txt", "a");
        fwrite($file, "Name: $vname | Phone: $vphone | Location: $vlocation | Support: $support | Availability: $availability | Date: " . date("Y-m-d H:i:s") . PHP_EOL);
        fclose($file);

        $successMessage = "Volunteer registration submitted successfully.";
        $vname = $vphone = $vlocation = $support = $availability = "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Emergency Help Portal | Volunteer</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .error-text{color:#d93025;font-size:14px;margin-top:6px;display:block;}
    .input-error{border:2px solid #d93025 !important;outline:none;}
    .success-box{margin-top:15px;padding:12px;border-radius:8px;background:#d1e7dd;color:#0f5132;font-weight:600;}
  </style>
</head>
<body>
<nav class="navbar">
  <div class="container nav-wrap">
    <a href="index.html" class="brand">
      <span class="logo-badge">+</span>
      <span>Emergency Help Portal</span>
    </a>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
    <div class="nav-links" id="navLinks">
      <a href="index.html">Home</a>
      <a href="contacts.html">Emergency Contacts</a>
      <a href="centers.html">Relief Centers</a>
      <a href="safety.html">Safety Guide</a>
      <a href="help.php">Request Help</a>
      <a href="volunteer.php" class="active">Volunteer</a>
      <a href="about.html">About</a>
    </div>
  </div>
</nav>
<section class="banner">
  <div class="container">
    <h1>Volunteer Registration</h1>
    <p>Join as a volunteer and support people during emergency situations.</p>
  </div>
</section>
<section class="section">
  <div class="container grid-2">
    <div class="page-image">
      <img src="images/volunteer.svg" alt="Volunteer illustration">
    </div>
    <div class="card">
      <h3>Who can register?</h3>
      <ul class="info-list">
        <li>Students willing to support field coordination</li>
        <li>Drivers and transport helpers</li>
        <li>People who can provide food or water</li>
        <li>First-aid and medical support volunteers</li>
      </ul>
    </div>
  </div>
</section>
<section class="section" style="padding-top:0;">
  <div class="container form-box">
    <div class="form-layout">
      <div class="form-side">
        <h2>Become a Volunteer</h2>
        <p>Volunteers play an important role in helping affected people, managing supplies, and guiding them to safer places.</p>
        <ul class="info-list">
          <li>Transport help</li>
          <li>Relief material distribution</li>
          <li>First aid and support</li>
          <li>Awareness and guidance</li>
        </ul>
      </div>
      <div class="form-main">
        <form method="POST" action="" novalidate>
          <div class="input-group">
            <label for="vname">Full Name</label>
            <input type="text" id="vname" name="vname" value="<?php echo $vname; ?>" class="<?php echo $vnameError ? 'input-error' : ''; ?>">
            <span class="error-text"><?php echo $vnameError; ?></span>
          </div>
          <div class="input-group">
            <label for="vphone">Phone Number</label>
            <input type="tel" id="vphone" name="vphone" value="<?php echo $vphone; ?>" class="<?php echo $vphoneError ? 'input-error' : ''; ?>">
            <span class="error-text"><?php echo $vphoneError; ?></span>
          </div>
          <div class="input-group">
            <label for="vlocation">Location</label>
            <input type="text" id="vlocation" name="vlocation" value="<?php echo $vlocation; ?>" class="<?php echo $vlocationError ? 'input-error' : ''; ?>">
            <span class="error-text"><?php echo $vlocationError; ?></span>
          </div>
          <div class="input-group">
            <label for="support">Type of Support</label>
            <select id="support" name="support" class="<?php echo $supportError ? 'input-error' : ''; ?>">
              <option value="">Select support type</option>
              <option <?php if($support=='Transport') echo 'selected'; ?>>Transport</option>
              <option <?php if($support=='Food Supply') echo 'selected'; ?>>Food Supply</option>
              <option <?php if($support=='Medical / First Aid') echo 'selected'; ?>>Medical / First Aid</option>
              <option <?php if($support=='Rescue Assistance') echo 'selected'; ?>>Rescue Assistance</option>
            </select>
            <span class="error-text"><?php echo $supportError; ?></span>
          </div>
          <div class="input-group">
            <label for="availability">Availability Note</label>
            <textarea id="availability" name="availability" rows="4" placeholder="Mention timing or support details" class="<?php echo $availabilityError ? 'input-error' : ''; ?>"><?php echo $availability; ?></textarea>
            <span class="error-text"><?php echo $availabilityError; ?></span>
          </div>
          <button class="btn btn-primary" type="submit">Register as Volunteer</button>
        </form>
        <?php if($successMessage != ""): ?>
          <div class="success-box"><?php echo $successMessage; ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <h3>Emergency Help Portal</h3>
        <p>A web-based support system that gives people one place to find emergency contacts, safety instructions, relief center details, and quick help forms during critical situations.</p>
      </div>
      <div>
        <h3>Quick Links</h3>
        <ul>
          <li><a href="contacts.html">Emergency Contacts</a></li>
          <li><a href="centers.html">Relief Centers</a></li>
          <li><a href="help.php">Request Help</a></li>
          <li><a href="volunteer.php">Volunteer</a></li>
        </ul>
      </div>
      <div>
        <h3>Support Info</h3>
        <p>Email: support@emergencyhelp.org</p>
        <p>Phone: +91 98765 43210</p>
        <p>Location: Erode, Tamil Nadu</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2026 Emergency Help Portal. Built for academic mini project use.</p>
    </div>
  </div>
</footer>
<script src="script.js"></script>
</body>
</html>
