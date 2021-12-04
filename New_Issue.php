<html>
<h1>Create Issue</h1>

<form action="" method="post" list="new_issue">
  <p>Title</p>
    <input type="text" name="title" id="title"/><br><br>
  <p>Description</p>
    <input type="text" name="description" id="description"/><br><br>
  <p>Assigned To</p>
  
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

  <p>Type</p>
    <input list="type" name="browser" placeholder="hello">
    <datalist id="type">
      <option value="Bug">
      <option value="Proposal">
      <option value="Task">
    </datalist>

  <p>Prioritory</p>
    <input list="prio" name="browser" placeholder="hello">
    <datalist id="prio">
        <option value="Critical">
        <option value="Major">
        <option value="Minor">
    </datalist>
    <br>
    <button class='newIssue'>Submit</button>
</form><br>
    
</html>
