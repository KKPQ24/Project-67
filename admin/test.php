<?php
// Database connection details
$servername = "localhost";  // Typically 'localhost' for local server
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "issues_db";      // The database name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get data from March 2024 to present
$sql = "
    SELECT 
        DATE_FORMAT(submission_date, '%Y-%m') AS month_year,
        COUNT(*) AS total_issues_submitted
    FROM 
        issues
    WHERE 
        submission_date >= '2024-03-01' 
        AND submission_date <= CURRENT_DATE
    GROUP BY 
        YEAR(submission_date), MONTH(submission_date)
    ORDER BY 
        YEAR(submission_date), MONTH(submission_date);
";

$result = $conn->query($sql);

// Fetch data and prepare it for Chart.js
$months = [];
$totals = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $months[] = $row['month_year'];
        $totals[] = $row['total_issues_submitted'];
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Issues Submitted Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<canvas id="myChart" width="400" height="200"></canvas>
<script>
// Get data from PHP arrays
var months = <?php echo json_encode($months); ?>;
var totals = <?php echo json_encode($totals); ?>;

// Prepare data for Chart.js
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line', // Type of chart
    data: {
        labels: months, // X-axis labels
        datasets: [{
            label: 'Total Issues Submitted',
            data: totals, // Y-axis data
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            fill: false,
        }]
    },
    options: {
        scales: {
            x: {
                type: 'category',
                labels: months,
            },
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>
