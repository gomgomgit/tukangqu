@php
    $no = 1;
    $total_all = 0;
    $total_kas = 0;
    $total_user = [];
    
    foreach ($users as $i => $user) {
      $total_user[$i] = 0;
    }
@endphp
<html>
  <table border="1" style="border-collapse: collapse">
    <thead>
      <tr>
        <th></th>
        <th colspan="1"><b>Saldo Bulan Lalu</b></th>
        <th colspan="5"><b>Rp {{ number_format($total_last, 0, '.', '.') }}</b></th>  
      </tr>
      <tr>
        <th></th>
        <th colspan="1"><b>Pemasukan - Pengeluaran - Cicil</b></th>
        <th colspan="5"><b>Rp {{ number_format($total_now = $total_in - $total_out, 0, '.', '.') }}</b></th>
      </tr>
      <tr>
        <th></th>
        <th colspan="1"><b>Kas</b></th>
        <th colspan="5"><b>Rp {{ number_format($total_last + $total_now, 0, '.', '.') }}</b></th>
      </tr>
      <tr><td colspan="7"><br></td></tr>
    </thead>
    <tbody>
      <tr><td colspan="7"><b>Data Pengeluaran</b></td></tr>
      <tr>
        <th rowspan="2"><b>No </b></th>
        <th rowspan="2"><b>Tanggal </b></th>
        <th rowspan="2"><b>Nama </b></th>
        <th rowspan="2"><b>User </b></th>
        <th rowspan="2"><b>Pengeluaran Kas </b></th>
        <th style="text-align: center" colspan="{{ $users->count() }}"><b>Pengeluaran Pribadi </b></th>
      </tr>
      <tr>
        @foreach ($users as $user)
            <th><b>{{ $user->name }}</b></th>
        @endforeach
      </tr>
      @foreach ($cashs as $cash)
      @php
          $total_all += $cash->money_out;
      @endphp
      <tr>
        <td>{{ $no++ }}</td>
        <td>{{ Carbon\Carbon::parse($cash->date)->format('d-M-Y') }}</td>
        <td>{{ $cash->name }}</td>
        <td>{{ $cash->user->name }}</td>
        @if ($cash->category == 'out') 
          @php
            $total_kas = $total_kas + $cash->money_out;
          @endphp 
          <td>Rp {{ number_format($cash->money_out, 0, '.', '.') }}</td>
          @foreach ($users as $user)
            <td> - </td>
          @endforeach
        @elseif($cash->category == 'owe')
          <td> - </td>
          @foreach ($users as $i => $user)
            @if ($cash->user_id == $user->id)
              @php
                  $total_user[$i] = $total_user[$i] + $cash->money_out;
              @endphp
              <td>
                Rp {{ number_format($cash->money_out, 0, '.', '.') }}
              </td>
            @else
              <td>-</td>
            @endif
          @endforeach
        @endif
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th></th>
        <th rowspan="2" colspan="3" style="font-size: 14; text-align:center; vertical-align:middle">
          <b>Total</b>
        </th>
        <th rowspan="2"><b>Rp {{number_format($total_kas, 0, '.', '.') }}</b></th>
        @foreach ($users as $i => $user)
            <th><b>Rp {{number_format($total_user[$i], 0, '.', '.')}}</b></th>
        @endforeach
      </tr>
      <tr>
        <th></th>
        <th colspan="2">
          <b>
          @php
            echo 'Rp '. number_format(array_sum($total_user), 0, '.', '.')
          @endphp
          </b>
        </th>
      </tr>
    </tfoot>
  </table>
</html>