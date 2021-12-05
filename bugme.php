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
            elseif($_POST['home']=='true' ):
                session_start();
                $stmt = $conn->query("SELECT * FROM issues");
                $table_results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            elseif($_POST['home']!= 'true'):
                $session_start();
                echo $_POST['home'];
            endif;


        elseif($_SERVER['REQUEST_METHOD']=== 'GET'):
            if(isset($_GET['title'])):
                $title = $_GET['title'];
                $stmt = $conn->query("SELECT * FROM issues WHERE id = '$title'");
                $title_results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                              
            endif;
    endif;


    


?>


<?php if ($table_results!=[]): ?>
    <table>
    <tr>
        <th style = "text-align: left; padding: 0.5em;">Title</th>
        <th style = "text-align: center;">Type</th>
        <th style = "padding: 0.5em;">Status</th>
        <th>Assigned To</th>
        <th>Created By</th>
    </tr>
    
    <?php foreach ($table_results as $count=>$row): ?>
        <?php
            
            $assigned_id = intval($table_results[$count]['assigned_to']);
            $created_id = intval($table_results[$count]['created_by']);
        
            $u_stmt = $conn->query("SELECT * FROM users WHERE id = '$assigned_id'");
            $assigned_results = $u_stmt->fetchAll(\PDO::FETCH_ASSOC);
            $assigned = $assigned_results[$count]['firstname'].' '.$assigned_results[$count]['lastname'];
                
            $date = explode(" ",$row['created']);

            
        ?>
    <tr>
        <td style = "padding: 0.5em;"><?= $row['id'] . "&nbsp" ?><a href="" style = "text-decoration:none"><?= $row['title'] ?><a></td>
        <td style = "text-align: center;"><?= $row['type'] ?></td>
        <td style = "text-align: center; background-color: rgb(68, 184, 68); border-radius: 5px;"><?= $row['status'] ?></td>
        <td style = "text-align: center;"><?= $assigned ?></td>
        <td style = "text-align: center;"><?= $date[0] ?></td>
    </tr>

    <tr>
        <td colspan="5" class="divider"><hr /></td>
    </tr>
    <?php endforeach; ?>

    </table>
<?php endif; ?>


<?php if ($title_results!=[]): ?>
    <html>
        <div class = 'title_head'> 
            <h1><?=$title_results[0]['title'];?><h1>
            <h5>Issue <?= $title_results[0]['id'] ?> </h5>
        </div>
        
        <div class ='title_content'>
            <p> <?= $title_results[0]['description']; ?> </p>
            <div class = 'right_bar'>
                <div class = 'desc'>
                    <p><?= $title_results[0]['assigned_to']?></p>
                    <p><?= $title_results[0]['type']?></p>
                    <p><?= $title_results[0]['priority']?></p>
                    <p><?= $title_results[0]['status']?></p>
                </div>
                <button>Mark as Closed </button>
                <button>Mark In Progress</button>
            </div>
        </div>
    </html>
    
  

<?php endif; ?>


























