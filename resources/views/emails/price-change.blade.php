<!DOCTYPE html>
<html>
<head>
    <title>Product Price Change</title>
</head>
<body>
<h1>Hello {{ $brand->name }},</h1>
<p>A price change has occurred for a product in your category of interest which might interest you:</p>
<h2>{{ $product->name }}</h2>
<p>{{ $product->description }}</p>
<p>Old Price: {{ $oldPrice }}</p>
<p>Current Price: {{ $currentPrice }}</p>
<p>Supplier: {{ $product->supplier->name }}</p>
<p>Thank you for using our platform!</p>
</body>
</html>