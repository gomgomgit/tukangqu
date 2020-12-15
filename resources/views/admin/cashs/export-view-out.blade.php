@php
    $no = 1;
    $total = 0;
    $pengeluaran = [];
    
    foreach ($users as $i => $user) {
      array_push($pengeluaran, 0);
    }
@endphp
<table border="1" style="border-collapse: collapse">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      @foreach ($users as $user)
          <th>Pengeluaran {{ $user->name }}</th>
      @endforeach
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($cashs as $cash)
    @php
        $total += $cash->money_out;
    @endphp
    <tr>
      <td>{{ $no++ }}</td>
      <td>{{ $cash->name }}</td>
      @foreach ($users as $i => $user)
        <td>
          @if ($cash->user->name == $user->name)
          @php
              $pengeluaran[$i] = $pengeluaran[$i] + $cash->money_out;
          @endphp
          {{ $cash->money_out }}
          @endif
        </td>
      @endforeach
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th></th>
      <th>Total</th>
      @foreach ($pengeluaran as $user)
          <th>{{ $user }}</th>
      @endforeach
      <th>{{ $total }}</th>
    </tr>
  </tfoot>
</table>