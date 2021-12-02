<?php
    $host = 'localhost';
    $username = 'project2_user';
    $password = 'password123';
    $dbname = 'bugme';

    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // connection made to database

    if($_SERVER['REQUEST_METHOD']=== 'POST'):

        if(isset($_POST['add_user'])):
            
            $new_user=filter_var($_POST['add_user'],FILTER_SANITIZE_STRING);
            $new_user =explode(",",$new_user);

            $firstname= $new_user[0];
            $lastname= $new_user[1];
            $password= $new_user[2];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $email= $new_user[3];
        
            
        
            $statement = $conn->prepare('INSERT INTO users (firstname, lastname, pass, email) VALUES (:firstname, :lastname, :pass, :email)');

            $statement->execute(['firstname' => $firstname,'lastname' => $lastname,'pass' => $hashed_password,'email' => $email]);
            echo("success");
        
        endif;


        if(isset($_POST['log_user'])):
            $ret_user = filter_var($_POST['log_user'],FILTER_SANITIZE_STRING);
            $ret_user = explode(",",$new_user);

            echo($email = $ret_user[0]);
            $password = password_hash($ret_user[1]);

            $statement = $conn->query("SELECT FIRST FROM users WHERE users.email == $email");
            
            if($statement['pass']==$password):
                session_start();
                $_SESSION['id'] = $statement['id'];
                $_SESSION['firstname'] = $statement['firstname'];
                $_SESSION['lastname'] = $statement['lastname'];
                $_SESSION['email'] = $statement['email'];
                echo "Session Started";
            endif;


        endif;




    endif;

    


    


?>