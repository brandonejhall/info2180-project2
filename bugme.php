<?php
    $host = 'localhost';
    $username = 'project2_user';
    $password = 'password123';
    $dbname = 'bugme';

    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // connection made to database
    $_SESSION['loggedin'] = False;
    
    if($_SERVER['REQUEST_METHOD']=== 'POST'):

        if(isset($_POST['add_user'])):
            
            $new_user=filter_var($_POST['add_user'],FILTER_SANITIZE_STRING);
            $new_user =explode(",",$new_user);
            $firstname= $new_user[0];
            $lastname= $new_user[1];
            $password= $new_user[2];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $email= $new_user[3];
        
            
        
            $statement = $conn->prepare('INSERT INTO users (firstname, lastname, password, email) 
            VALUES (:firstname, :lastname, :password, :email)');

            $statement->execute(['firstname' => $firstname,'lastname' => $lastname,'password' => $hashed_password,
            'email' => $email]);
            echo("success");
        
        


        elseif(isset($_POST['log_user'])):
            
            $ret_user = filter_input(INPUT_POST, 'log_user',FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            $usr = explode(",",$ret_user);
            
            $email = $usr[0];
            $pass_word = $usr[1];

            $stmt = $conn->query("SELECT * FROM users WHERE email='$email'");
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);


            if ($results != []):
                if(password_verify($pass_word,$results[0]['password'])):
                    session_start();
                    $_SESSION['id'] = $results[0]['id'];
                    $_SESSION['firstname'] = $results[0]['firstname'];
                    $_SESSION['lastname'] = $results[0]['lastname'];
                    $_SESSION['email'] = $results[0]['email'];
                    $_SESSION['loggedin'] = True;
                    echo 'Session Start';
                else:
                    echo 'Incorrect Password Or Username';
                endif;
            else:
                echo 'No such user exists';
            endif;
        


        elseif(isset($_POST['new_issue'])):
                session_start();
                $new_issue = filter_input(INPUT_POST, 'new_issue',FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
                $new_issue = explode(",",$new_issue);
                $title = $new_issue[0];
                $desc = $new_issue[1];
                $assignedTo = $new_issue[2];
                $type = $new_issue[3];
                $prio = $new_issue[4];
                $status = 'Open';
                $createdBy =intval("{$_SESSION['id']}");

                
                
                $statement = $conn->prepare('INSERT INTO issues (title, description, type, priority, status, assigned_to, created_by) 
                VALUES (:title, :description, :type, :priority, :status, :assigned_to, :created_by)');

                
                
                $statement->execute([
                    'title' => $title,
                    'description' => $desc,
                    'type' => $type, 
                    'priority' => $prio, 
                    'status' => $status,
                    'assigned_to' => intval($assignedTo), 
                    'created_by' => $createdBy
                ]);

                echo 'new issue created';
            elseif(isset($_POST['home'])):
                session_start();
                $stmt = $conn->query("SELECT * FROM issues");
                $table_results = $stmt->fetchAll(\PDO::FETCH_ASSOC);


            endif;


    endif;

    


?>


<?php if ($table_results!=[]): ?>
    <table>
    <tr>
        <th>Title</th>
        <th>Type</th>
        <th>Status</th>
        <th>Assigned To</th>
        <th>Created By</th>
    </tr>

    <?php foreach ($table_results as $row): ?>
    <tr>
        <td><p><?= $row['id'] ?><p><a href=""><?= $row['title'] ?><a></td>
        <td><?= $row['type'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['assigned_to'] ?></td>
        <td><?= $row['created_by'] ?></td>
    </tr>
    <?php endforeach; ?>

    </table>
<?php endif; ?>





























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