<?php
require('app/Db.php');

$person = new Person();

if (isset($_POST["addBtn"])) 
{
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $createdOn = date('Y-m-d h:i:sa');
    $updatedOn = date('Y-m-d h:i:sa');

    $person->createStatement("INSERT INTO persons( `Name`, `Mobile`, `Email`, `CreateOn`, `UpdatedOn`) VALUES (?, ?, ?, ?, ?)");

    $person->bindValues("sssss", [$name, $mobile, $email, $createdOn, $updatedOn]);

    if ($person->execute())
    {
        echo "Data inserted successfully.";
    } 
    else 
    {
        echo "Error inserting data.";
    }
}

if(isset($_POST["searchBtn"]))
{
    $filter = $_POST['filterName'];

    $person->createStatement("SELECT * FROM persons WHERE Name = ?");
    $person->bindValues("s", [$filter]);
    $person->execute();
    $data = $person->getResult();
}

// Fetch all data from the database
$person->createStatement("SELECT * FROM persons");
$person->execute();
$data = $person->getResult();


?>


<h2>Add Person</h2>
<form method="post">
    <label for="name">Name:</label>
    <input type="text" name="name"><br><br>

    <label for="mobile">Mobile:</label>
    <input type="number" name="mobile"><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email"><br><br>

    <button type="submit" name="addBtn">Add Person</button>
</form>

<form method="post" action="">
    <label for="filterName">Filter:</label>
    <input type="text" name="filterName">
    <button type="submit"  name="searchBtn">Search</button>
</form>

<h2>Person List</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Number</th>
        <th>Email</th>
    </tr>

    <?php if(count($data) > 0): ?>
        <?php foreach ($data as $row): ?>
            <tr>
                <td> <?php echo $row['Name'] ?></td>
                <td> <?php echo $row['Mobile'] ?></td>
                <td> <?php echo $row['Email'] ?></td>
            </tr>
        <?php endforeach ?>

    <?php else: ?>
        <tr>
            <td colspan="3">No Data Found</td>
        </tr>
    <?php endif ?>
</table>