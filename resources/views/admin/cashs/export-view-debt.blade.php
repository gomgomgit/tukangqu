@php
    $no = 1;
    $total_all = 0;
    $total_kas = 0;
    $now_owe = [];
    $total_now_owe = 0;
    $now_pay = [];
    $total_now_pay = 0;
    $last_debt = [];
    $total_last_debt = 0;
    $now_debt = [];
    $total_now_debt = 0;
    
    foreach ($users as $i => $user) {
      $now_owe[$i] = $cashs->where('user_id', $user->id)->where('category', 'owe')->sum('money_out');
      $now_pay[$i] =  $cashs->where('user_id', $user->id)->where('category', 'pay')->sum('money_out');
      $last_debt[$i] = $last_cashs->where('user_id', $user->id)->where('category', 'owe')->sum('money_out') - $last_cashs->where('user_id', $user->id)->where('category', 'pay')->sum('money_out');
      $total_last_debt += $last_debt[$i];
      $total_now_owe += $now_owe[$i];
      $total_now_pay += $now_pay[$i];
      $now_debt[$i] = $last_debt[$i] + $now_owe[$i] - $now_pay[$i];
      $total_now_debt += $now_debt[$i];
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
      <tr><td colspan="6"><br></td></tr>
    </thead>
    <tbody>
      <tr><td colspan="6"><b>Data Hutang</b></td></tr>
      <tr>
        <th><b>No </b></th>
        <th><b>Nama </b></th>
        <th><b>Hutang Keseluruhan Hingga Bulan Lalu </b></th>
        <th><b>Hutang Bulan Ini </b></th>
        <th><b>Cicil </b></th>
        <th><b>Sisa Hutang </b></th>
      </tr>
      @php
        $no = 1;  
      @endphp
      @foreach ($users as $key => $user)
        <tr>
          <td>{{$no++}}</td>
          <td>{{$user->name}}</td>
          <td>Rp {{number_format($last_debt[$key], 0, '.', '.')}}</td>
          <td>Rp {{number_format($now_owe[$key], 0, '.', '.')}}</td>
          <td>Rp {{number_format($now_pay[$key], 0, '.', '.')}}</td>
          <td>Rp {{number_format($now_debt[$key], 0, '.', '.')}}</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="2" style="font-size: 12; text-align:center; vertical-align:middle">
          <b>Total</b>
        </th>
        <th><b>Rp {{ number_format($total_last_debt, 0, '.', '.')}}</b></th>
        <th><b>Rp {{ number_format($total_now_owe, 0, '.', '.')}}</b></th>
        <th><b>Rp {{ number_format($total_now_pay, 0, '.', '.')}}</b></th>
        <th><b>Rp {{ number_format($total_now_debt, 0, '.', '.')}}</b></th>
      </tr>
    </tfoot>
  </table>
</html>