<?php
include "conn.php";

function searchContacts($searchTerm) {
   global $conn;

   $sql = "SELECT * FROM `contacts` WHERE 
           `first_name` LIKE '%$searchTerm%' OR
           `last_name` LIKE '%$searchTerm%' OR
           `email` LIKE '%$searchTerm%' OR
           `phone_number` LIKE '%$searchTerm%'";

   $result = mysqli_query($conn, $sql);

   if ($result) {
      $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
      return $searchResults;
   } else {
      echo "Search failed: " . mysqli_error($conn);
      return [];
   }
}

if (isset($_POST["search"])) {
   $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
   $searchResults = searchContacts($searchTerm);
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="styles.css">
<body> 
  <header>
    <h1>My Contacts Hub</h1>
  </header>
    <div class="container1">
        <h3>Contact Search</h3>
        <form method="post">
            <input type="text" name="searchTerm" placeholder="Enter name, email, or phone number" required>
            <input type="submit" name="search" value="Search">
            <a href="dashboard.php">Cancel</a>
        </form>

        <?php
        if (isset($searchResults) && !empty($searchResults)) {
            echo "<h3>Search Results:</h3>";
            echo "<ul>";
            foreach ($searchResults as $contact) {
                echo "<li>";
                echo "Name: " . $contact['first_name'] . " " . $contact['last_name'] . "<br>";
                echo "Email: " . $contact['email'] . "<br>";
                echo "Phone: " . $contact['phone_number'] . "<br>";
                echo '<div class="action-buttons">';
                echo '<a href="edit.php?contact_id=' . $contact["contact_id"] . '">Edit</a>';
                echo '<a href="delete.php?contact_id=' . $contact["contact_id"] . '">Delete</a>';
                echo '</div>';
                echo "</li>";
            }
            echo "</ul>";
        } elseif (isset($searchResults) && empty($searchResults)) {
            echo "<p>No results found.</p>";
        }
        ?>
    </div>
</body>
</html>
