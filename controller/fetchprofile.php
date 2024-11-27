<!-- Nanti kene buat satu lagi untuk navbar tukar fetchprofilepicture -->

<?php
// Include database connection
include_once 'db/db.php'; // Adjust the path as necessary

// Initialize an array to store user data
$user_data = [];

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Get the user ID from the session

    // Prepare the SQL query to fetch user information and manager name
    $query = "
        SELECT u1.staffID, u1.name, u1.email, u1.role, u1.phonenum, u1.sector, u1.userpfp, u2.name AS managername 
        SELECT u1.staffID, u1.name, u1.email, u1.role, u1.sector, u1.phonenum, u1.managerid, u1.userpfp, u2.name AS managername 
        FROM user u1
        LEFT JOIN user u2 ON u1.managerid = u2.staffID
        WHERE u1.staffID = ?
    ";

    $stmt = $conn->prepare($query); // Use prepared statements to prevent SQL injection
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($staffID, $name, $email, $role, $phonenum, $sector, $userpfp, $managername);
    $stmt->bind_result($staffID, $name, $email, $role, $sector, $phonenum, $managerid, $userpfp, $managername);
    $stmt->fetch();
    $stmt->close();

    // Set profile picture path
    $profile_picture = !empty($userpfp) ? 'pfp/' . $userpfp : 'pfp/default.jpg'; 

    // Store user information in the array
    $user_data = [
        'staffID' => $staffID,
        'name' => $name,
        'email' => $email,
        'role' => $role,
        'sector' => $sector,
        'phonenum' => $phonenum,
        'managername' => $managername, // Add manager name to the array
        'profile_picture' => $profile_picture,
    ];
}

// Return the user data
return $user_data; // This will be returned to the calling file
?>
