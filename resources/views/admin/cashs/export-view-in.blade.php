@php
    $no = 1;
    $total_project_value= 0;
    $total_profit= 0;
@endphp

<table border="1" style="border-collapse: collapse">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Nilai Proyek</th>
      <th>Keuntungan</th>
      <th>Pemasukan - Pengeluaran</th>
      <th>Saldo Bulan Lalu</th>
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
      <th>Total</th>
      <th>Rp {{ $total_project_value }}</th>
      <th>Rp {{ $total_profit }}</th>
      <th>Rp {{ $total_now = $total_profit - $total_out }}</th>
      {{-- Bulan lalu --}}
      <th>Rp {{ $lasttotal + $total_now }}</th>
    </tr>
  </tfoot>
</table>