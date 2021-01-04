@php
    $no = 1;
    $total_project_value= 0;
    $total_profit= 0;
@endphp

<table border="1" style="border-collapse: collapse">
  <thead>
    <tr>
      <th><b>No</b></th>
      <th><b>Nama</b></th>
      <th><b>Nilai Proyek</b></th>
      <th><b>Keuntungan</b></th>
      <th><b>Pemasukan - Pengeluaran</b></th>
      <th><b>Saldo Bulan Lalu</b></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($cashs as $key => $cash)
    @php
        $total_project_value += $cash->projectvalue;
        $total_profit += $cash->money_in;
    @endphp
    <tr>
      <td>{{ $no++ }}</td>
      <td>{{ $cash->name }}</td>
      <td>Rp {{ $cash->projectvalue }}</td>
      <td>Rp {{ $cash->money_in }}</td>
      <td></td>
      @if ($key == 0)
        <th>Rp {{ $lasttotal }}</th>  
      @else
        <td></td>
      @endif
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th></th>
      <th><b>Total</b></th>
      <th><b>Rp {{ $total_project_value }}</b></th>
      <th><b>Rp {{ $total_profit }}</b></th>
      <th><b>Rp {{ $total_now = $total_profit - $total_out }}</b></th>
      {{-- Bulan lalu --}}
      <th><b>Rp {{ $lasttotal + $total_now }}</b></th>
    </tr>
  </tfoot>
</table>