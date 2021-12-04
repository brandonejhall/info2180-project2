<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1>New User</h1>
    <form action="" method="post">
        <div class="form">
            <label for="fname">First Name</label><br>
            <input type="text" name="fname" id="fname" placeholder="e.g. Michael">
        </div>
        <div class="form">
            <label for="lname">Last Name</label><br>
            <input type="text" name="lname" id="lname" placeholder="e.g. Knowles"/>
        </div>
        <div class="form">
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password"/>
        </div>
        <div class="form">
            <label for="email">Email</label><br>
            <input type="text" name="email" id="email" placeholder="e.g. example@yahoo.com"/>
        </div>
        
        <button type="button" id="SubmitBtn" class="btn">Submit</button><br><br>
        <div id="msg"></div>
    </form>
</body>
</html>