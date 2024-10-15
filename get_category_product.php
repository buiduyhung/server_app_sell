<?php 
include "connect.php";

$query = "SELECT * FROM category_products";
$data = mysqli_query($conn, $query);

// Initialize result array
$result = array();

// Check if the query executed successfully
if ($data) {
    while($row = mysqli_fetch_assoc($data)) {
        $result[] = $row;
    }

    if (!empty($result)) {
        $arr = [
            'success' => true,
            'message' => 'Successfully retrieved data',
            'result' => $result
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => 'No data found',
            'result' => null
        ];
    }
} else {
    $arr = [
        'success' => false,
        'message' => 'Failed to execute query',
        'result' => null
    ];
}

// Output the JSON response
echo json_encode($arr);

// Close the database connection
mysqli_close($conn);
