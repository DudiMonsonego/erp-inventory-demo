function fetchAllItems() {
    fetch('api.php')
        .then(response => response.json())
        .then(data => renderTable(data))
        .catch(error => console.error('Error fetching inventory data:', error));
}

// Retrieve filtered records using query arguments
function fetchLowStockItems() {
    fetch('api.php?filter=low_stock')
        .then(response => response.json())
        .then(data => renderTable(data))
        .catch(error => console.error('Error fetching alert data:', error));
}

// Update the DOM layout with incoming JSON data structure
function renderTable(items) {
    const tableBody = document.getElementById('inventory-table-body');
    tableBody.innerHTML = ''; 

    items.forEach(item => {
        const row = document.createElement('tr');
        
        // Evaluate row logic based on stock levels vs minimum constraints
        if (item.warehouse_main < item.min_threshold || item.warehouse_distribution < item.min_threshold) {
            row.classList.add('low-stock-row');
        }

        row.innerHTML = `
            <td><b>${item.part_number}</b></td>
            <td>${item.description}</td>
            <td>${item.warehouse_main} units</td>
            <td>${item.warehouse_distribution} units</td>
            <td>${item.min_threshold} units</td>
        `;
        tableBody.appendChild(row);
    });
}

// Execute initial load when framework layer is ready
window.onload = fetchAllItems;