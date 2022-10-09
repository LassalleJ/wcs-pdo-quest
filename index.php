<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
</head>
<body>

<!-- GET THE DATA FROM DATABASE -->

<?php
    require_once '_connec.php';
    $pdo = new \PDO(DSN, USER, PASS);
    $query = "SELECT * FROM friend";
    $statement = $pdo->query($query);
    $friends = $statement->fetchAll();
?>
<?php foreach ($friends as $friend):?>
    <ul>
        <li><?php echo $friend['firstname'].' '.$friend['lastname'].'<br>'; ?></li>
    </ul>
    <?php endforeach?>

<!-- HTML FORM -->

    <h1>Add your friend on the list</h1>
    <form action="" method="POST">
        <label for="firstname" >First name</label>
        <input type="text" name ="firstname" placeholder="Please enter the first name" required>
        <br>
        <label for="lastname">Last name</label>
        <input type="text" name ="lastname" placeholder = "Please enter the last name" required>
        <br>
        <input type="submit">
    </form> 

<!-- FORM DATA PROCESSING -->

<?php 
$errors=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$firstname = trim($_POST['firstname']); 
$lastname = trim($_POST['lastname']);
if ((empty($firstname)) || (strlen($firstname)>45)){
    $errors[]='The first name is invalid';
} 
if ((empty($lastname)) || (strlen($lastname)>45)){
    $errors[]='The last name is invalid';
}
if (!empty($errors)) {
    foreach ($errors as $error){
        echo $error.'<br>';
    }

// ADD THE FORM DATA TO THE DATABASE

} else {
    $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    $statement->execute();
    header("location:index.php");
    }
}
?>
</body>
</html>
