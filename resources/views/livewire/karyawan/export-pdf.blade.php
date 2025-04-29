<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <style>
        .flex-items-center{
            witdh: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .header{
            line-height: 35%;
        }
        th{
            background-color: silver;
        }
        .table, th ,td{
            padding: 10px;
            border: 1px solid black;
            border-collapse: collapse;
        }
        .bold{
            font-weight: 700;
        }
        .section_tandaTangan{
            width: max-content;
            display: flex;
        }
        .section_kesimpulan{
            margin: 1em 0em;
        }
    </style>
</head>
<body>
    <div class="container">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 20%; border: none; padding: 0;">
                    <img src="{{ public_path('img/logo.png') }}" alt="logo" style="height: 5rem;padding:1px;background-color: black;">
                </td>
                <td style="text-align: left; border: none; padding: 0;">
                    <h1 style="margin: 0;">CV. TUNAS BARU</h1>
                    <h4 style="margin: 0;">PROTEIN UNTUK MASYARAKAT</h4>
                </td>
            </tr>
        </table>
        
        <hr style="border: 2px solid black;">
        <div class="my-2">
            <p>Laporan karyawan pada bulan <strong>{{ $bulan }} {{ $tahun }}</strong>.</p>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nama Kandang</th>
                  </tr>
                </thead>
                <tbody>
                    {{-- data transaksi --}}
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->kandang?->nama_kandang }}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
        {{-- section kesimpulan --}}
        <div class="section_kesimpulan">
            <p style="line-height:30px;">Total karyawan berjumlah <strong>{{ $totalEmployees }} Orang</strong> dan jumlah kandang <strong>{{ $totalChickenCoops }} Barak</strong>.</p>
        </div>
    </div>
</body>
</html>