<!DOCTYPE html>
<html>
<head>
    <title>Product Low Stock Alert</title>
</head>
<body>
    <h1>Low Stock Alert for {{ $productName }}</h1>
    <p>The stock level for the product "{{ $productName }}" has fallen below 20% of the initial stock. Current stock: {{ $stock }}.</p>
</body>
</html>
