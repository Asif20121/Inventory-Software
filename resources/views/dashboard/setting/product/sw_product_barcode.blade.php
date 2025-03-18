<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SW BarCode</title>
</head>

<body style="margin: -30px;">
    PC : {{ $sw_product_code->product_data->product_code }}
    {!! DNS1D::getBarcodeHTML($sw_product_code->product_data->product_code, 'C128B', 1.5, 20) !!}
</body>

</html>
