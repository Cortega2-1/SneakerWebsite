<?php
session_start();

include "credentials.php"; // Assuming this file contains your database connection details
$servername = "localhost";
        $db_name = "cortega2";
        $connection = mysqli_connect($servername, $username, $password, $db_name);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if (isset($_POST['login'])) {
   $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $sql = "SELECT * FROM projB_User WHERE Username = '$username' AND UserPass = '$password'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Valid user, set session and redirect to your main page
        $_SESSION['username'] = $username;
        header("Location: login.php");
        exit();
    } else {
        // Invalid credentials, show an error message
        echo "<p>Invalid username or password. Please try again.</p>";
        $_SESSION['username'] = $username;
          header("Location: project1.php");    
echo "<p>Invalid username or password. Please try again.</p>";
}
 } elseif (isset($_POST['logout'])) {
        // Logout logic
        session_unset();
        session_destroy();
        header("Location: project1.php"); // Redirect to the login page after logout
        exit();
    }
}

$SneakerID = "";
if (isset($_GET["SneakerID"])) {
    $SneakerID = $_GET["SneakerID"];
}

$BrandID = isset($_POST["BrandID"]) ? test_input($_POST["BrandID"]) : '';
$Model = isset($_POST["Model"]) ? test_input($_POST["Model"]) : '';
$TypeID = isset($_POST["TypeID"]) ? test_input($_POST["TypeID"]) : '';
$RetailPrice = isset($_POST["RetailPrice"]) ? test_input($_POST["RetailPrice"]) : '';
$ContributorUserID = isset($_POST["ContributorUserID"]) ? test_input($_POST["ContributorUserID"]) : '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["operation"] == "insert") {
        $BrandID = test_input($_POST["BrandID"]);
        $Model = test_input($_POST["Model"]);
        $TypeID = test_input($_POST["TypeID"]);
        $RetailPrice = test_input($_POST["RetailPrice"]);
        $ContributorUserID = test_input($_POST["ContributorUserID"]);
        
$sql = "INSERT INTO projB_Sneaker (BrandID, Model, TypeID, RetailPrice, ContributorUserID) VALUES ('$BrandID', '$Model', '$TypeID', '$RetailPrice', '$ContributorUserID')";
        if ($connection->query($sql) === TRUE) {
            echo "Sneaker inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    } elseif ($_POST["operation"] == "update") {
        $SneakerID = test_input($_POST["SneakerID"]);
        $BrandID = test_input($_POST["BrandID"]);
        $Model = test_input($_POST["Model"]);
        $TypeID = test_input($_POST["TypeID"]);
        $RetailPrice = test_input($_POST["RetailPrice"]);
        $ContributorUserID = test_input($_POST["ContributorUserID"]);

        $sql = "UPDATE projB_Sneaker SET BrandID = '$BrandID', Model = '$Model', TypeID = '$TypeID', RetailPrice = '$RetailPrice', ContributorUserID = '$ContributorUserID' WHERE SneakerID = $SneakerID";

        if ($connection->query($sql) === TRUE) {
            echo "Sneaker updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    } elseif ($_POST["operation"] == "delete") {
        $SneakerID = test_input($_POST["SneakerID"]);

        $sql = "DELETE FROM projB_Sneaker WHERE SneakerID = '$SneakerID'";
        if ($connection->query($sql) === TRUE) {
            echo "Sneaker deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
     <html>
     <head>
         <meta charset="utf-8">
         <title>Users Page</title>
         <link rel="stylesheet" href="stylesheet1.css"\>
<header>
     <img src="sneaker1.jpeg" alt="Cover Photo">
      </header> 
     
</head>
     <body>
<div class="box2">
    <h1>Sneaker Table</h1>
    <p>This is the main table: Sneaker table.</p>
    <?php
    include "credentials.php";
    $servername = "localhost";
    $db_name = "cortega2";
    $connection = mysqli_connect($servername, $username, $password, $db_name);

    if (mysqli_connect_errno()) {
        echo "<p>Failed to connect to database.</p>";
        exit();
    } else {
        echo "<p>Successfully connected to database.</p>";
    }
echo "<style>
        #dynamicColorTable {
            margin-left: auto;
            margin-right: auto;    
            background-color: black; /* Set your preferred background color */
            color: white; /* Set your preferred font color */
font-size: 30px;        
}   
    </style>";
    $sql_select = "SELECT * FROM projB_Sneaker";
    $results = mysqli_query($connection, $sql_select);

    if (mysqli_num_rows($results) > 0) {
        echo "<table id='dynamicColorTable' border='1'>";

        echo "<thead>";
        echo "<tr>";
        echo "<th>Sneaker ID</th>";
        echo "<th>Brand ID</th>";
        echo "<th>Model</th>";
        echo "<th>Type ID</th>";
        echo "<th>Retail Price</th>";
        echo "<th>Contributor User ID</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($results)) {
            echo "<tr>";
            echo "<td>" . $row['SneakerID'] . "</td>";
            echo "<td>" . $row['BrandID'] . "</td>";
            echo "<td>" . $row['Model'] . "</td>";
            echo "<td>" . $row['TypeID'] . "</td>";
            echo "<td>" . $row['RetailPrice'] . "</td>";
            echo "<td>" . $row['ContributorUserID'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";

        echo "</table>";
    } else {
        echo "<p>No data found in the table.</p>";
    }

    mysqli_close($connection);
    ?>
<p>Below are the 4 tables from where you can get information to add to the main table: Sneaker Table</p>
</div>

<div class="box1">
    <h1>Brand Table</h1>
    <p>Table 1</p>
    <?php
    include "credentials.php";
    $servername = "localhost";
    $db_name = "cortega2";
    $connection = mysqli_connect($servername, $username, $password, $db_name);

    if (mysqli_connect_errno()) {
        echo "<p>Failed to connect to database.</p>";
        exit();
    } else {
        echo "<p>Successfully connected to database.</p>";
    }

    $sql_select = "SELECT * FROM projB_Brand";
    $results = mysqli_query($connection, $sql_select);

    if (mysqli_num_rows($results) > 0) {
        echo "<table id='dynamicColorTable' border='1'>";

        echo "<thead>";
        echo "<tr>";
        echo "<th>Brand ID</th>";
        echo "<th>Brand Name</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($results)) {
            echo "<tr>";
            echo "<td>" . $row['BrandID'] . "</td>";
            echo "<td>" . $row['BrandName'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";

        echo "</table>";
    } else {
        echo "<p>No data found in the table.</p>";
    }
    ?>
</div>

<div class="box1">
    <h1>SneakerType Table</h1>
<p>Table 2</p>    
<?php
    include "credentials.php";
    $servername = "localhost";
    $db_name = "cortega2";
    $connection = mysqli_connect($servername, $username, $password, $db_name);

    if (mysqli_connect_errno()) {
        echo "<p>Failed to connect to database.</p>";
        exit();
    } else {
        echo "<p>Successfully connected to the database.</p>";
    }

    $sql_select = "SELECT * FROM projB_SneakerType";
    $results = mysqli_query($connection, $sql_select);

    if (mysqli_num_rows($results) > 0) {
        echo "<table id='dynamicColorTable' border='1'>";

        echo "<thead>";
        echo "<tr>";
        echo "<th>Type ID</th>";
        echo "<th>Type Name</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($results)) {
            echo "<tr>";
            echo "<td>" . $row['TypeID'] . "</td>";
            echo "<td>" . $row['TypeName'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";

        echo "</table>";
    } else {
        echo "<p>No data found in the table.</p>";
    }
    ?>
</div>

<div class="box1">
    <h1>Retailer Table</h1>
<p>Table 3</p>    
<?php
    include "credentials.php";
    $servername = "localhost";
    $db_name = "cortega2";
    $connection = mysqli_connect($servername, $username, $password, $db_name);

    if (mysqli_connect_errno()) {
        echo "<p>Failed to connect to the database.</p>";
        exit();
    } else {
        echo "<p>Successfully connected to the database.</p>";
    }

    $sql_select = "SELECT * FROM projB_Retailer";
    $results = mysqli_query($connection, $sql_select);

    if (mysqli_num_rows($results) > 0) {
        echo "<table id='dynamicColorTable' border='1'>";

        echo "<thead>";
        echo "<tr>";
        echo "<th>Retailer ID</th>";
        echo "<th>Retailer Name</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($results)) {
            echo "<tr>";
            echo "<td>" . $row['RetailerID'] . "</td>";
            echo "<td>" . $row['RetailerName'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";

        echo "</table>";
    } else {
        echo "<p>No data found in the table.</p>";
    }
    ?>
</div>

<div class="box1">
    <h1>Sneaker Retailer Table</h1>
<p>Table 4</p>    
<?php
    include "credentials.php";
    $servername = "localhost";
    $db_name = "cortega2";
    $connection = mysqli_connect($servername, $username, $password, $db_name);

    if (mysqli_connect_errno()) {
        echo "<p>Failed to connect to the database.</p>";
        exit();
    } else {
        echo "<p>Successfully connected to the database.</p>";
    }

    $sql_select = "SELECT * FROM projB_SneakerRetailer";
    $results = mysqli_query($connection, $sql_select);

    if (mysqli_num_rows($results) > 0) {
        echo "<table id='dynamicColorTable' border='1'>";

        echo "<thead>";
        echo "<tr>";
        echo "<th>Sneaker ID</th>";
        echo "<th>Retailer ID</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($results)) {
            echo "<tr>";
            echo "<td>" . $row['SneakerID'] . "</td>";
            echo "<td>" . $row['RetailerID'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";

        echo "</table>";
    } else {
        echo "<p>No data found in the table.</p>";
    }
    ?>
</div>

<div class="box">
<h1>Add to Sneaker Table</h1>
<p>Want to add an entry to table? You can do that here</p>
<form method="POST" action="">
    <input type="hidden" name="operation" value="insert">

    <label for="BrandID">Brand ID:</label>
    <input type="number" id="BrandID" name="BrandID" value="<?php echo $BrandID; ?>"><br>

    <label for="Model">Model:</label>
    <input type="text" id="Model" name="Model" value="<?php echo $Model; ?>"><br>

    <label for="TypeID">Type ID:</label>
    <input type="number" id="TypeID" name="TypeID" value="<?php echo $TypeID; ?>"><br>

    <label for="RetailPrice">Retail Price:</label>
    <input type="number" id="RetailPrice" name="RetailPrice" value="<?php echo $RetailPrice; ?>"><br>

    <label for="ContributorUserID">Contributor User ID:</label>
    <input type="number" id="ContributorUserID" name="ContributorUserID" value="<?php echo $ContributorUserID; ?>"><br>

    <input type="submit" name="insert" value="Insert">
</form>
</div>
<div class="box">

<h1>Update</h1>
<p>Want to update an entry? You can do that here</p>
<form method="POST" action="">
    <input type="hidden" name="operation" value="update">

    <label for="SneakerID">Sneaker ID:</label>
    <input type="number" id="SneakerID" name="SneakerID" value="<?php echo $SneakerID; ?>"><br>

    <label for="BrandID">Brand ID:</label>
    <input type="number" id="BrandID" name="BrandID" value="<?php echo $BrandID; ?>"><br>

    <label for="Model">Model:</label>
    <input type="text" id="Model" name="Model" value="<?php echo $Model; ?>"><br>

    <label for="TypeID">Type ID:</label>
    <input type="number" id="TypeID" name="TypeID" value="<?php echo $TypeID; ?>"><br>

    <label for="RetailPrice">Retail Price:</label>
    <input type="number" id="RetailPrice" name="RetailPrice" value="<?php echo $RetailPrice; ?>"><br>

    <label for="ContributorUserID">Contributor User ID:</label>
    <input type="number" id="ContributorUserID" name="ContributorUserID" value="<?php echo $ContributorUserID; ?>"><br>

    <input type="submit" name="update" value="Update">
</form>
</div>
<div class="box">
<h1>Delete</h1>
<p>Want to delete an entry? You can do that here</p>
<form method="POST" action="">
    <input type="hidden" name="operation" value="delete">

    <label for="SneakerID">Sneaker ID:</label>
    <input type="number" id="SneakerID" name="SneakerID" value="<?php echo $SneakerID; ?>"><br>

    <input type="submit" name="delete" value="Delete">
</form>
</div>
<div class="box">
<h1>Logout</h1>
<p>Want to logout and go back to main page. You can do that here</p>
<form method="POST" action="project1.php">
    <input type="submit" value="Logout" name="logout" class="logout-btn">
</form>
</div>
</body>  
</html>
