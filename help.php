<?php
$successMessage = "";

function clean_input($data) {
    return htmlspecialchars(trim($data));
}

$name = "";
$phone = "";
$location = "";
$type = "";
$message = "";

$nameError = "";
$phoneError = "";
$locationError = "";
$typeError = "";
$messageError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = clean_input($_POST['name'] ?? '');
    $phone = clean_input($_POST['phone'] ?? '');
    $location = clean_input($_POST['location'] ?? '');
    $type = clean_input($_POST['type'] ?? '');
    $message = clean_input($_POST['message'] ?? '');

    if ($name === "") {
        $nameError = "Full name is required";
    } elseif (!preg_match('/^[A-Za-z ]{3,30}$/', $name)) {
        $nameError = "Name must contain only letters and spaces (3 to 30 characters)";
    }

    if ($phone === "") {
        $phoneError = "Phone number is required";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $phoneError = "Phone number must be exactly 10 digits";
    }

    if ($location === "") {
        $locationError = "Location is required";
    } elseif (strlen($location) < 3) {
        $locationError = "Location must be at least 3 characters";
    }

    if ($type === "") {
        $typeError = "Please select emergency type";
    }

    if ($message === "") {
        $messageError = "Message is required";
    } elseif (strlen($message) < 10) {
        $messageError = "Message must be at least 10 characters";
    }

    if ($nameError === "" && $phoneError === "" && $locationError === "" && $typeError === "" && $messageError === "") {
        $file = fopen("help_requests.txt", "a");
        fwrite($file, "Name: $name | Phone: $phone | Location: $location | Emergency: $type | Message: $message | Date: " . date("Y-m-d H:i:s") . PHP_EOL);
        fclose($file);

        $successMessage = "Help request submitted successfully.";
        $name = $phone = $location = $type = $message = "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Emergency Help Portal | Request Help</title>
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
      <a href="help.php" class="active">Request Help</a>
      <a href="volunteer.php">Volunteer</a>
      <a href="about.html">About</a>
    </div>
  </div>
</nav>
<section class="banner">
  <div class="container">
    <h1>Request Emergency Help</h1>
    <p>Submit your request for rescue, shelter, food, or medical support.</p>
  </div>
</section>
<section class="section">
  <div class="container form-box">
    <div class="form-layout">
      <div class="form-side">
        <h2>Need help now?</h2>
        <p>This form stores emergency support requests using PHP.</p>
        <ul class="info-list">
          <li>Rescue support</li>
          <li>Food and water request</li>
          <li>Medical assistance</li>
          <li>Shelter requirement</li>
        </ul>
      </div>
      <div class="form-main">
        <form method="POST" action="" novalidate>
          <div class="input-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" value="<?php echo $name; ?>" class="<?php echo $nameError ? 'input-error' : ''; ?>">
            <span class="error-text"><?php echo $nameError; ?></span>
          </div>
          <div class="input-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter contact number" value="<?php echo $phone; ?>" class="<?php echo $phoneError ? 'input-error' : ''; ?>">
            <span class="error-text"><?php echo $phoneError; ?></span>
          </div>
          <div class="input-group">
            <label for="location">Current Location</label>
            <input type="text" id="location" name="location" placeholder="Enter your area / address" value="<?php echo $location; ?>" class="<?php echo $locationError ? 'input-error' : ''; ?>">
            <span class="error-text"><?php echo $locationError; ?></span>
          </div>
          <div class="input-group">
            <label for="type">Type of Emergency</label>
            <select id="type" name="type" class="<?php echo $typeError ? 'input-error' : ''; ?>">
              <option value="">Select one</option>
              <option <?php if($type=='Medical Emergency') echo 'selected'; ?>>Medical Emergency</option>
              <option <?php if($type=='Flood Rescue') echo 'selected'; ?>>Flood Rescue</option>
              <option <?php if($type=='Fire Accident') echo 'selected'; ?>>Fire Accident</option>
              <option <?php if($type=='Need Shelter') echo 'selected'; ?>>Need Shelter</option>
              <option <?php if($type=='Food / Water Support') echo 'selected'; ?>>Food / Water Support</option>
            </select>
            <span class="error-text"><?php echo $typeError; ?></span>
          </div>
          <div class="input-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Explain your situation briefly" class="<?php echo $messageError ? 'input-error' : ''; ?>"><?php echo $message; ?></textarea>
            <span class="error-text"><?php echo $messageError; ?></span>
          </div>
          <button class="btn btn-primary" type="submit">Submit Request</button>
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
