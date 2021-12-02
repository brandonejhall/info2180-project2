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
            $ret_user = explode(",",$ret_user);
            $email = ret_user[0];    
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
        if(!(isset($_POST['log_user']))):
            echo "Not working";
        endif;




    endif;

    


    


?>


























<?php /*
foreach ($admin as $ad):
    echo($ad['firstname']);
endforeach;

if ($_SERVER['REQUEST_METHOD']=='POST'):
    if (isset($_POST)):
        $new_user=filter_var($_POST['add_user'],FILTER_SANITIZE_STRING);
        $new_user =explode(",",$new_user);
        echo($id='');
        echo($firstname= $new_user[0]);
        echo($lastname= $new_user[1]);
        echo($password= $new_user[2]);
        echo($hashed_password = password_hash($password, PASSWORD_DEFAULT));
        echo($email= $new_user[3]);
        echo($date=(date("Y-m-d h:i:s")));
        
       // $new_u = ['id'=>'', 'firstname' => $firstname,'lastname' => $lastname,'password' => $hashed_password,'email' => $email];

        //$new_admin = "INSERT INTO users (firstname, lastname, password,email) VALUES (:firstname ,:lastname,:password,:email)";
        //$new_admin -> execute();
    endif;
    
else:
    echo("nooo");
endif; */


?>