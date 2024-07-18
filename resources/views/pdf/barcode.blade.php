<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .text-center {
        text-align: center;
    }
</style>

<body>
    {{-- --}}
    <table width="100%" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center">
                <p style="font-size: 28px;font-weight: bold;">
                    {{ $item->name }}

                </p>
                {!! DNS1D::getbarcodeHTML($item->code, 'C39', 3, 150) !!}
                <h1 style="font-size: 24px;font-weight: bold;">{{ $item->code }}</h1>
                <h1>({{ formatRupiah($item->price_first, true) }}) ({{ \Carbon\Carbon::now()->format('Y-m-d') }})</h1>
            </td>
        </tr>
    </table>
    {{-- <img src="data:image/png;base64, {{ DNS1D::getBarcodePNG('4445645656', 'C39') }}" alt=""  /> --}}
</body>

</html>
