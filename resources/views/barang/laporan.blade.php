<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    @include('barang.partials.style-laporan')
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Tanggal Cetak : {{ $date }}</p>
    </div>

    @include('barang.partials.list-laporan')
</body>
</html>
