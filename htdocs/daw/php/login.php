<?php
session_start();
$host = '';
$username = '';
$password = '';
$dbname = '';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "<script>alert('❌ Please fill in all fields.'); window.location.href='/daw/templates/login.html';</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM Client WHERE Mail_Clt=? AND Mot_Clt=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
        $_SESSION['Id_Clt'] = $client['Id_Clt'];
        header('Location: /daw/templates/index.html');
        exit;
    } else {
        echo "<script>alert('❌ Email or password incorrect');
        window.location.href='/daw/templates/login.html';
        </script>";
        exit;
    }

}
$stmt->close();
$conn->close();
?>
