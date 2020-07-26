<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
  body {
    font-size: 18px;
    font-family: Arial, Helvetica, sans-serif;
  }

  table.center {
    margin-left: auto;
    margin-right: auto;
  }

  .page-break {
    page-break-after: always;
  }
</style>

<body>
  @foreach($commodities as $key => $commodity)
  <table class="center" border="1" cellpadding="10" cellspacing="0">
    <tr>
      <td colspan="2">Barang Milik {{$sekolah}}</td>
    </tr>
    <tr>
      <th>Kode Barang : </th>
      <td>{{ $commodity->item_code }}</td>
    </tr>
    <tr>
      <th>Nama Barang : </th>
      <td>{{ $commodity->name }}</td>
    </tr>
    <tr>
      <th>Asal Perolehan : </th>
      <td>{{ $commodity->school_operational_assistance->name }}</td>
    </tr>
  </table>
  <br>
  @if ($key!=0)
  @if (($key+1) % 4==0)
  <div class="page-break"></div>
  @endif
  @endif
  @endforeach
</body>

</html>