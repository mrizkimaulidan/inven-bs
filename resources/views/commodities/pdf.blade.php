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
</style>

<body>
  <table class="center" border="1" cellpadding="10" cellspacing="0">
    @foreach($commodities as $key => $commodity)
    <tr>
      <th>Kode Register : </th>
      <td>{{ $commodity->register }}</td>
    </tr>
    <tr>
      <th>Nama Barang : </th>
      <td>{{ $commodity->name }}</td>
    </tr>
    <tr>
      <th>Asal Perolehan : </th>
      <td>{{ $commodity->school_operational_assistance->name }}</td>
    </tr>
    @endforeach
  </table>
</body>

</html>