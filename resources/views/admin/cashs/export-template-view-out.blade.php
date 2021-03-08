<html>
  <body>
    <table border=2>
      <tr>
        <th><b>Uraian</b></th>
        <th><b>Tanggal</b></th>
        <th><b>User Id</b></th>
        <th><b>Kategori</b></th>
        <th><b>Jumlah</b></th>
        <th><b>Keterangan</b></th>
      </tr>
      <tr>
        <td>Biaya Bulanan</td>
        <td>2020-12-01</td>
        <td>1</td>
        <td>pengeluaran</td>
        <td>100000</td>
        <td>boleh dikosongkan</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>NB :</td>
      </tr>
      <tr>
        <td>1.</td>
        <td>Tanggal :</td>
        <td>Tahun -</td>
        <td>Bulan -</td>
        <td>Hari</td>
        <td>awali dengan kutip satu (') sebelum tahun</td>
      </tr>
      @foreach ($users as $index => $user)
        @if ($index == 0)
          <tr>
            <td>2.</td>
            <td>User Id :</td>
            <td>{{$user->name}} :</td>
            <td>{{$user->id}}</td>
          </tr>
        @else
          <tr>
            <td></td>
            <td></td>
            <td>{{$user->name}} :</td>
            <td>{{$user->id}}</td>
          </tr>
        @endif
      @endforeach
      <tr>
        <td>3.</td>
        <td>Kategori :</td>
        <td>pengeluaran</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>hutang</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>cicil</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>refund</td>
      </tr>
      <tr>
        <td>4.</td>
        <td>Hapus NB</td>
      </tr>
    </table>
  </body>
</html>