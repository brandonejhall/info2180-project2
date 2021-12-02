<?php
$host = 'localhost';
$username = 'project2_user';
$password = 'password123';
$dbname = 'bugme';

// connection made to database
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
//checking if admin exisits
$admin_exists = $conn->query("SELECT count(*) FROM users WHERE email = 'project2@admin.com' ");
// if there is no admin with that email the following code will run 
if ($admin_exists < 1){
    //sets new admin data
    $data = [
        'firstname' => 'admin',
        'lastname' => 'user',
        'password' => password_hash('password123'),
        'email' => 'project2@admin.com'
    ];
    // inserts admin to db
    $new_admin = "INSERT INTO users (firstname, lastname, password,email) VALUES (:firstname ,:lastname,:password,:email)";
    // execute the insertion
    $conn->prepare($new_admin)->execute($data);
}

?>




<?php //This if statement is checking if request is POST?>
<?php if ($_SERVER['REQUEST_METHOD']=== 'POST'):
    // Checking if POST request is not null
   if (isset($_POST)){
       // checking if (assuming that a list is sent as add_user parameter to php) is not null
       if (isset($_POST['add_user'])){
           // strip any tags off user data minor sanitization <<further sanitization required>>
           $new_user_data = array_map('strip_tags',$_POST['add_user']);
           // sets list data to corresponding variables
           $firstname = $new_user_data[0];
           $lastname = $new_user_data[1];
           $password = $new_user_data[2];
           $email = $new_user_data[3];
           
           $new_u = ['firstname' => $firstname,'lastname' => $lastname,'password' => password_hash($password),'email' => $email];

           $new_admin = "INSERT INTO users (firstname, lastname, password,email) VALUES (:firstname ,:lastname,:password,:email)";
           $conn->prepare($new_admin)->execute($new_u);
       };
   };
 
?>
<?php endif ?>

<?php if ($_SERVER['REQUEST_METHOD']=== 'POST'):
    if (isset($_POST)){
        if (isset($_POST['login'])){
            $login_user_data = array_map('strip_tags',$_POST['login']);
            $email = $login_user_data[0];
            $password = $login_user_data[1];

            $email_check = $conn->query("SELECT email from users WHERE email = $email");

            $password_hash = $conn->query("SELECT password from users WHERE email = $email");

            if ($email_check == $email && password_verify($password,$password_hash)){
                $user = $conn->query("SELECT email from users WHERE email = $email");
                session.start();
                $_SESSION["email"] = $email;
            };


        };
        
    };
?>
<?php endif ?>