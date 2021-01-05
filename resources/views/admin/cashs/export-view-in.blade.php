@php
    $no = 1;
    $total_project_value= 0;
    $total_profit= 0;
@endphp

<table border="1" style="border-collapse: collapse">
  <thead>
    <tr>
      <th></th>
      <th colspan="1"><b>Saldo Bulan Lalu</b></th>
      <th colspan="2"><b>Rp {{ number_format($total_last, 0, '.', '.') }}</b></th>  
    </tr>
    <tr>
      <th></th>
      <th colspan="1"><b>Pemasukan - Pengeluaran - Cicil</b></th>
      <th colspan="2"><b>Rp {{ number_format($total_now = $total_in - $total_out, 0, '.', '.') }}</b></th>
    </tr>
    <tr>
      <th></th>
      <th colspan="1"><b>Kas</b></th>
      <th colspan="2"><b>Rp {{ number_format($total_last + $total_now, 0, '.', '.') }}</b></th>
    </tr>
    <tr><td colspan="4"><br></td></tr>
  </thead>
  <tbody>
    <tr><th colspan="4"><b>Data Pemasukan</b></th></tr>
    <tr>
      <th><b>No</b></th>
      <th><b>Nama</b></th>
      <th><b>Nilai Proyek</b></th>
      <th><b>Keuntungan</b></th>
    </tr>
    @foreach ($cashs as $key => $cash)
    @php
        $total_project_value += $cash->projectvalue;
        $total_profit += $cash->money_in;
    @endphp
    <tr>
      <td>{{ $no++ }}</td>
      <td>{{ $cash->name }}</td>
      <td>Rp {{ number_format($cash->projectvalue, 0, '.', '.') }}</td>
      <td>Rp {{ number_format($cash->money_in, 0, '.', '.') }}</td>
    </tr>
    @endforeach
    <tr>
      <th></th>
      <th><b>Total</b></th>
      <th><b>Rp {{ number_format($total_project_value, 0, '.', '.') }}</b></th>
      <th><b>Rp {{ number_format($total_profit, 0, '.', '.') }}</b></th>
    </tr>
  </tbody>

</table>