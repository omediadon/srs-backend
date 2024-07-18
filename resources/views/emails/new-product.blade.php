<!DOCTYPE html>
<html>
<head>
    <title>A New Product Has Been Added</title>
</head>
<body>
<h1>Hello {{ $brand->name }},</h1>
<br>
<p>A new product has been added in your category of interest:</p>
<h2>{{ $product->name }}</h2>
<p>{{ $product->description }}</p>
<p>Price: {{ $product->price }}</p>
<p>Supplier: {{ $product->supplier->name }}</p>
<br>
<p>Thank you for using our platform!</p>
</body>
</html>