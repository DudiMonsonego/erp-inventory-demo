<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Generic enterprise resource planning (ERP) dataset
$inventory_data = [
    [
        "part_number" => "PART-1001",
        "description" => "Industrial Cutting Component",
        "warehouse_main" => 450,
        "warehouse_distribution" => 35, // Below minimum!
        "min_threshold" => 100
    ],
    [
        "part_number" => "PART-2002",
        "description" => "Precision Machining Tool",
        "warehouse_main" => 120,
        "warehouse_distribution" => 140,
        "min_threshold" => 80
    ],
    [
        "part_number" => "PART-3003",
        "description" => "High-Grade Drilling Bit",
        "warehouse_main" => 15, // Below minimum!
        "warehouse_distribution" => 95,
        "min_threshold" => 50
    ]
];

// Read query parameters from the request URL
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$response_data = [];

if ($filter === 'low_stock') {
    // Filter items where stock in any warehouse drops below the allowed threshold
    foreach ($inventory_data as $item) {
        if ($item["warehouse_main"] < $item["min_threshold"] || $item["warehouse_distribution"] < $item["min_threshold"]) {
            $response_data[] = $item;
        }
    }
} else {
    $response_data = $inventory_data;
}

echo json_encode($response_data);
?>