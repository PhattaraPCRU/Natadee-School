<?php
include("../auto/sql_util.php");

// Get the current date in the desired format for MySQL (Y-m-d)
$currentDateMySQL = date('Y-m-d');

// Query the database for the quote of the day using ORDER BY and LIMIT
$sql = "SELECT quote FROM quotes WHERE date = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $currentDateMySQL);
$stmt->execute();
$result = $stmt->get_result();

// Check if there is a result
if ($result->num_rows > 0) {
    // Found a quote for the current date, use it as the quote of the day
    $row = $result->fetch_assoc();
    $quoteOfTheDay = $row['quote'];
} else {
    // No quote found for the current date, use the default quote
    $quoteOfTheDay = "Never gonna give you up,
    Never gonna let you down,
    Never gonna run around and desert you,
    Never gonna make you cry,
    Never gonna say goodbye,
    Never gonna tell a lie and hurt you";
}

// Close the database connection
$stmt->close();
$conn->close();

// Output the quote of the day as JSON
echo json_encode(['quote' => $quoteOfTheDay]);
?>
