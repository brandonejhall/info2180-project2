<?php
$host = 'localhost';
$username = 'project2_user';
$password = 'password123';
$dbname = 'bugme';


$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);



$admin_exists = $conn->query("SELECT count(*) FROM users WHERE email = 'project2@admin.com' ");
if ($admin_exists < 1){
    $data = [
        'firstname' => 'admin',
        'lastname' => 'user',
        'password' => password_hash('password123'),
        'email' => 'project2@admin.com'
    ];

    $new_admin = "INSERT INTO users (firstname, lastname, password,email) VALUES (:firstname ,:lastname,:password,:email)";

    $conn->prepare($new_admin)->execute($data);
}

?>

<?php if ($_SERVER['REQUEST_METHOD']=== 'POST'):?>




<?php endif ?>

<?php if ($_SERVER['REQUEST_METHOD']=== 'GET'):?>
<?php





?>
<?php endif ?>

