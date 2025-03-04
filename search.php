<?php
include 'database.php'; // Ensure this file connects to your database

if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']); // Prevent SQL Injection

    // SQL query to fetch borrowed books by the member's last name
    $sql = "SELECT M.MemberID, M.LastName, M.FirstName, B.Title 
            FROM BorrowingRecords BR
            JOIN Members M ON BR.MemberID = M.MemberID
            JOIN Books B ON BR.BookID = B.BookID
            WHERE M.LastName LIKE '%$search%'
            ORDER BY M.LastName, M.FirstName, B.Title";

    $result = $conn->query($sql);

    if (!$result) {
        echo "<p>SQL Error: " . $conn->error . "</p>"; // Debug SQL errors
    } elseif ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['MemberID']}</td>
                    <td>{$row['LastName']}</td>
                    <td>{$row['FirstName']}</td>
                    <td>{$row['Title']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4' class='text-center'>No records found</td></tr>";
    }
} else {
    echo "<p>Debug: No search term received.</p>";
}

$conn->close();
?>
