<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');

$conn = new mysqli("sql209.byethost8.com", "b8_38963450", "youcefmib500", "b8_38963450_Base_Client");
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    echo "<script>alert('❌ Server error. Please try again later.'); window.location.href='/daw/templates/signup.html';</script>";
    exit;
}

// Retrieve and sanitize inputs
$fname = trim($_POST['fname'] ?? '');
$lname = trim($_POST['lname'] ?? '');
$age = trim($_POST['age'] ?? '');
$wilaya = trim($_POST['wilaya'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$address = trim($_POST['address'] ?? '');
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';
$gender = trim($_POST['gender'] ?? '');

// Check for empty fields
$required_fields = [
    'First Name' => $fname,
    'Last Name' => $lname,
    'Age' => $age,
    'Wilaya' => $wilaya,
    'Phone' => $phone,
    'Email' => $email,
    'Address' => $address,
    'Password' => $password,
    'Gender' => $gender
];
foreach ($required_fields as $field => $value) {
    if (empty($value)) {
        echo "<script>alert('❌ $field cannot be empty.'); window.location.href='/daw/templates/signup.html';</script>";
        exit;
    }
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('❌ Invalid email format.'); window.location.href='/daw/templates/signup.html';</script>";
    exit;
}

// Validate phone number (10 digits)
if (!preg_match('/^\d{10}$/', $phone)) {
    echo "<script>alert('❌ Phone Number must be exactly 10 digits.'); window.location.href='/daw/templates/signup.html';</script>";
    exit;
}

// Validate age (between 17 and 100)
if (!is_numeric($age) || $age < 17 || $age > 100) {
    echo "<script>alert('❌ Age must be between 17 and 100.'); window.location.href='/daw/templates/signup.html';</script>";
    exit;
}

// Validate password length and match
if (strlen($password) < 8) {
    echo "<script>alert('❌ Password must be at least 8 characters.'); window.location.href='/daw/templates/signup.html';</script>";
    exit;
}
if ($password !== $password2) {
    echo "<script>alert('❌ Passwords do not match.'); window.location.href='/daw/templates/signup.html';</script>";
    exit;
}

// Check if email already exists
$check = $conn->prepare("SELECT Id_Clt FROM Client WHERE Mail_Clt = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo "<script>alert('❌ Email already registered.'); window.location.href='/daw/templates/signup.html';</script>";
    exit;
}
$check->close();


// Insert new user
$stmt = $conn->prepare("INSERT INTO Client (Pno_Clt, No_Clt, Age_Clt, Wi_Clt, Tel_Clt, Mail_Clt, Adr_Clt, Mot_Clt, Sexe_Clt) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssissssss", $fname, $lname, $age, $wilaya, $phone, $email, $address, $password, $gender);
if ($stmt->execute()) {
    echo "<script>alert('✅ Registration successful! Please log in.'); window.location.href='/daw/index.php';</script>";
} else {
    error_log("Registration failed: " . $stmt->error);
    echo "<script>alert('❌ Registration failed. Please try again.'); window.location.href='/daw/templates/signup.html';</script>";
}

$stmt->close();
$conn->close();
?>