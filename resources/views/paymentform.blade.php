<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Payment</h1>
    <form action="{{route('payment')}}" method="POST">
        @csrf
        <input type="text" name="amount" id="amount">
        <input type="submit" value="Checkout" name="submit">
    </form>
</body>
</html>