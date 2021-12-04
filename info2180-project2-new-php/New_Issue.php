<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">

</head>
<body>
  <h1>Create Issue</h1>

  <form action="" method="post" list="new_issue">
    <div class="form">
      <label for="title">Title</label><br>
      <input type="text" name="title" id="title"/>
    </div>
    <div class="form">
      <label for="description">Description</label><br>
      <textarea name="description" id="description" cols="30" rows="20"></textarea>
    </div>
    <div class="form">
      <label for="new_issue">Assigned to</label><br>
      <?php
        $host = 'localhost';
        $username = 'project2_user';
        $password = 'password123';
        $dbname = 'bugme';

        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

        $stmt = $conn->query("SELECT * FROM users");
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);  
      ?>
      <select id="new_issue">
        <?php foreach ($results as $row):?> 
          <option value = <?=$row['id']?>> <?=$row['firstname'].' '.$row['lastname']?> </option>
          <?php endforeach ?>
        </select>
    </div>
    
    <div class="form">
      <label for="type">Type</label><br>
      <select id="type">
        <option value="Bug">Bug</option>
        <option value="Proposal">Proposal</option>
        <option value="Task">Task</option>
        </select>

    </div>
    <div class="form">
      <label for="prio">Priority</label><br>
      <select id="prio">
        <option value="Major">Major</option>
        <option value="Minor">Minor</option>
        <option value="Critical">Critical</option>
        </select>
    </div>
      
      <br>
      <button class='newIssue'>Submit</button>
  </form><br>
</body>
</html>
