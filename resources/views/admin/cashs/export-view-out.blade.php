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
        <th class="bold" rowspan="2">No</th>
        <th rowspan="2">Tanggal</th>
        <th rowspan="2">Nama</th>
        <th rowspan="2">User</th>
        <th rowspan="2">Pengeluaran Kas</th>
        <th style="text-align: center" colspan="{{ $users->count() }}">Pengeluaran Pribadi</th>
      </tr>
      <tr>
        @foreach ($users as $user)
            <th>Pengeluaran {{ $user->name }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
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
            <td></td>
          @endforeach
        @elseif($cash->category == 'owe')
          <td></td>
          @foreach ($users as $i => $user)
            @if ($cash->user_id == $user->id)
              @php
                  $total_user[$i] = $total_user[$i] + $cash->money_out;
              @endphp
              <td>
                Rp {{ number_format($cash->money_out, 0, '.', '.') }}
              </td>
            @else
              <td></td>
            @endif
          @endforeach
        @endif
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th></th>
        <th rowspan="2" colspan="3" style="font-size: 14; font-weight:bold; text-align:center; vertical-align:middle">
          <b>Total</b>
        </th>
        <th rowspan="2">Rp {{number_format($total_kas, 0, '.', '.') }}</th>
        @foreach ($users as $i => $user)
            <th>Rp {{number_format($total_user[$i], 0, '.', '.')}}</th>
        @endforeach
      </tr>
      <tr>
        <th></th>
        <th colspan="2">
          @php
            echo 'Rp '. number_format(array_sum($total_user), 0, '.', '.')
          @endphp
        </th>
      </tr>
    </tfoot>
  </table>
</html>