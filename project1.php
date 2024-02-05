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
  //      exit();
      } else {
        // Invalid credentials, show an error message
        echo "<p>Invalid username or password. Please try again.</p>";
$_SESSION['username'] = $username;
          header("Location: project1.php");      
}
    }
  }
?>

<!DOCTYPE html>
   <html>
   <head>
       <meta charset="uft-8">
       <title>Carlos Ortega</title>
       <link rel="stylesheet" href="stylesheet1.css">
    <header>
    <img src="sneaker1.jpeg" alt="Cover Photo">
    </header> 
    </head>
<body>
<div class="box">
<h1>SneakerHead Kingdom</h1>

<?php 
    $string = "Current date and time is : "; 
    echo '<span style="color: white; font-size: 25px;">' . $string . '</span>'; 

    $myDate = date("m-d-Y h:i:s");  
 
    echo '<span style="color: white; font-size: 25px;">' . $myDate . '</span>';
?> 

<p>Welcome! My passion for shoes isn't just about footwear; it's a journey through art, history, and self-expression. From the stories behind each release to the intricate designs that grace them, every sneaker tells a story. This webpage is an invitation for you to lace up and dive into the universe of sneakers with me. Let's celebrate the culture, the craft, and the community that binds us all.</p>
<p>That said, let's break down what you can expect from this space! Let's dive right into it:</p>
</div>

<?php
function displayKickStories() {
    $kickStories = array(
        "Jordan 12 Flu Games" => array(
            "url" => "https://youtu.be/4OvbskZy9QU?si=MZqh3A0cb7FnTIkB",
            "description" => "During Game 5 of the 1997 NBA Finals between the Chicago Bulls and the Utah Jazz, where he scored a game-high 38 points despite battling flu-like symptoms.",
            "image" => "flugames.jpeg"
        ),
        "Jordan 1 Banned" => array(
            "url" => "https://youtu.be/GdO7e6LynJo",
            "description" => "NBA commissioner, David Stern, banned these sneakers due to its bold black and red colorway, which violated league regulations.",
            "image" => "banned.jpeg"
        )
    );

    $output = '<div class="box"><h1>Kick Stories</h1><ul>';
    $output .= '<p>Kick Stories: Get the lowdown on the history and tales behind iconic pairs.</p><ul>';
    foreach ($kickStories as $key => $story) {
        $output .= '<li><a href="' . $story["url"] . '">' . $key . '</a>: ' . $story["description"] . '</li>';
        $output .= '<img src="' . $story["image"] . '" alt="' . $key . ' photo"><p></p>';
    }
    $output .= '</ul></div>';
    return $output;
}

function displayMustHaves() {
    $mustHaves = array(
        "Air Force 1s" => "af1.jpeg",
        "Yeezy Slides" => "slides1.jpeg"
    );

    $output = '<div class="box"><h1>Must-Haves</h1><ul>';
    $output .= '<p>Must-Haves: Essential shoes everyone should have in their wardrobe lineup.</p><ul>';    
    foreach ($mustHaves as $key => $image) {
        $output .= '<li>' . $key . '</li>';
        $output .= '<img src="' . $image . '" alt="' . $key . ' photo"><p></p>';
    }
    $output .= '</ul></div>';
    return $output;
}
echo displayKickStories();
echo displayMustHaves();
?>

 <div class="box2">

 <h1>Sneaker Table</h1>
<p>To update table color use the "tableColor" variable and to sort the table either click the column header you would like or use the "orderBy" variable</p>
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

    $bgColor = "black"; // default white background color
    
    if(isset($_GET['tableColor'])) {
        $bgColor = htmlentities($_GET['tableColor']);
}
    $sortColumn = 'SneakerID'; // Default sort column

    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], ['SneakerID', 'BrandID', 'Model', 'TypeID', 'RetailPrice', 'ContributorUserID'])) {
        $sortColumn = $_GET['orderBy'];
}
    echo "<style>
    #dynamicColorTable {
        margin-left: auto;
        margin-right: auto;    
        background-color: $bgColor;
    }   
    </style>";

    $sql_select = "SELECT * FROM projB_Sneaker ORDER BY $sortColumn";
    $results = mysqli_query($connection, $sql_select);

    if (mysqli_num_rows($results) > 0) {
    echo "<table id='dynamicColorTable' border='1'>";
    
    echo "<thead>";
    echo "<tr>";
    echo "<th><a href='?orderBy=SneakerID'>Sneaker ID</a></th>";
    echo "<th><a href='?orderBy=BrandID'>Brand ID</a></th>";
    echo "<th><a href='?orderBy=Model'>Model</a></th>";
    echo "<th><a href='?orderBy=TypeID'>Type ID</a></th>";
    echo "<th><a href='?orderBy=RetailPrice'>Retail Price</a></th>";
    echo "<th><a href='?orderBy=ContributorUserID'>Contributor User ID</a></th>";
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
</div>
 <div class="box1">
  <h1>Brand Table</h1>
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
    <h1>Registered User Login</h1>
    <p>Want to login to update, delete, or add to the database. Only registered users are allowed</p>
    <div class="login-form" style="float: center;">
        <form method="POST" action="login.php"> <!-- Update the action attribute with the actual PHP script handling the login -->
            <div class="login-input">
                <p>Username: <input type="text" name="username"></p>
            </div>
            <div class="login-input">
                <p>Password: <input type="password" name="password"></p>
            </div>
            <input type="submit" value="Login" class="login-btn" name="login">
        </form>
    </div>
</div>

</div>

</body>
  </html>
