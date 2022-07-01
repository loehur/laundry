<?php
if (count($data['dataTanggal']) > 0) {
  $currentMonth =   $data['dataTanggal']['bulan'];
  $currentYear =   $data['dataTanggal']['tahun'];
} else {
  $currentMonth = date('m');
  $currentYear = date('Y');
}
?>

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-auto">
        <div class="card">
          <div class="content sticky-top m-3">
            <form action="<?= $this->BASE_URL; ?>Rekap/i/2" method="POST">
              <table class="w-100">
                <tr>
                  <td>
                    <select name="m" class="form-control form-control-sm" style="width: auto;">
                      <option class="text-right" value="01" <?php if ($currentMonth == '01') {
                                                              echo 'selected';
                                                            } ?>>01</option>
                      <option class="text-right" value="02" <?php if ($currentMonth == '02') {
                                                              echo 'selected';
                                                            } ?>>02</option>
                      <option class="text-right" value="03" <?php if ($currentMonth == '03') {
                                                              echo 'selected';
                                                            } ?>>03</option>
                      <option class="text-right" value="04" <?php if ($currentMonth == '04') {
                                                              echo 'selected';
                                                            } ?>>04</option>
                      <option class="text-right" value="05" <?php if ($currentMonth == '05') {
                                                              echo 'selected';
                                                            } ?>>05</option>
                      <option class="text-right" value="06" <?php if ($currentMonth == '06') {
                                                              echo 'selected';
                                                            } ?>>06</option>
                      <option class="text-right" value="07" <?php if ($currentMonth == '07') {
                                                              echo 'selected';
                                                            } ?>>07</option>
                      <option class="text-right" value="08" <?php if ($currentMonth == '08') {
                                                              echo 'selected';
                                                            } ?>>08</option>
                      <option class="text-right" value="09" <?php if ($currentMonth == '09') {
                                                              echo 'selected';
                                                            } ?>>09</option>
                      <option class="text-right" value="10" <?php if ($currentMonth == '10') {
                                                              echo 'selected';
                                                            } ?>>10</option>
                      <option class="text-right" value="11" <?php if ($currentMonth == '11') {
                                                              echo 'selected';
                                                            } ?>>11</option>
                      <option class="text-right" value="12" <?php if ($currentMonth == '12') {
                                                              echo 'selected';
                                                            } ?>>12</option>
                    </select>
                  </td>
                  <td>
                    <select name="Y" class="form-control form-control-sm" style="width: auto;">
                      <option class="text-right" value="2021" <?php if ($currentYear == 2021) {
                                                                echo 'selected';
                                                              } ?>>2021</option>
                      <option class="text-right" value="2022" <?php if ($currentYear == 2022) {
                                                                echo 'selected';
                                                              } ?>>2022</option>
                    </select>
                  </td>

                  <td><button class="form-control form-control-sm m-1 p-1 bg-light">Cek</td>
                  <td class="w-50"></td>
                </tr>
              </table>
            </form>
          </div>

          <div class="card">
            <?php
            $rekap = array();
            $rekapQty = array();
            foreach ($data['data_main'] as $a) {
              $serLayanan = $a['list_layanan'];
              if (isset($rekap[$a['id_penjualan_jenis']][$serLayanan]) ==  TRUE) {
                $rekap[$a['id_penjualan_jenis']][$serLayanan] =  $rekap[$a['id_penjualan_jenis']][$serLayanan] + $a['qty'];
              } else {
                $rekap[$a['id_penjualan_jenis']][$serLayanan] = $a['qty'];
              }

              if (isset($rekapQty[$a['id_penjualan_jenis']]) ==  TRUE) {
                $rekapQty[$a['id_penjualan_jenis']] =  $rekapQty[$a['id_penjualan_jenis']] + $a['qty'];
              } else {
                $rekapQty[$a['id_penjualan_jenis']] = $a['qty'];
              }
            }
            ?>
            <div class="card-body mt-1 p-0 table-responsive-sm">
              <table class="table table-sm w-100">
                <thead>
                  <tr>
                    <th>Jenis</th>
                    <th class="text-right">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($rekapQty as $keyA => $a) {
                    foreach ($this->dPenjualan as $b) {
                      if ($b['id_penjualan_jenis'] == $keyA) {
                        $jenisPenjualan = $b['penjualan_jenis'];
                        $unit = "";
                        foreach ($this->dSatuan as $sa) {
                          if ($sa['id_satuan'] == $b['id_satuan']) {
                            $unit = $sa['nama_satuan'];
                          }
                        }
                        echo "<tr>";
                        echo "<td class='text-primary'><b>" . $jenisPenjualan . "</b></td>";
                        echo "<td class='text-right'><b>" . $a . "</b> " . $unit . "</td>";
                        echo "</tr>";
                      }
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <br>
            <div class="card-body p-0 table-responsive-sm">
              <table class="table table-sm w-100">
                <tbody>
                  <?php
                  $jenisPenjualan = "";
                  $jenisPenjualanBefore = "";

                  foreach ($rekap as $keyA => $a) {
                    foreach ($this->dPenjualan as $b) {
                      if ($b['id_penjualan_jenis'] == $keyA) {
                        $unit = "";
                        foreach ($this->dSatuan as $sa) {
                          if ($sa['id_satuan'] == $b['id_satuan']) {
                            $unit = $sa['nama_satuan'];
                          }
                        }

                        foreach ($a as $keyB => $c) {
                          $serLayanan = $keyB;
                          $arrLayanan = unserialize($keyB);
                          $layanan = "";
                          foreach ($arrLayanan as $d) {
                            foreach ($this->dLayanan as $e) {
                              if ($d == $e['id_layanan']) {
                                $layanan = $layanan . " " . $e['layanan'];
                              }
                            }
                          }
                          $jenisPenjualan = $b['penjualan_jenis'];
                          if ($jenisPenjualan == $jenisPenjualanBefore) {
                            $jenisPenjualan = "";
                          }
                          echo "<tr>";
                          echo "<td class='text-primary'><b>" . $jenisPenjualan . "</b></td>";
                          echo "<td>" . $layanan . "</td>";
                          echo "<td class='text-right'><b>" . $c . "</b> " . $unit . "</td>";
                          echo "</tr>";
                          $jenisPenjualanBefore = $b['penjualan_jenis'];
                        }
                      }
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <?php $total_pendapatan = $data['kasLaundry'] + $data['kasMember']; ?>

            <br>
            <div class="card-body p-0 table-responsive-sm">
              <table class="table table-sm w-100">
                <tbody>
                  <tr>
                    <td>Pendapatan Laundry <span class="text-primary">Umum</span></td>
                    <td class="text-right"><b>Rp<?= number_format($data['kasLaundry']) ?></b></td>
                  </tr>
                  <tr>
                    <td>Pendapatan Laundry <span class="text-success">Member</span></td>
                    <td class="text-right"><b>Rp<?= number_format($data['kasMember']) ?></b></td>
                  </tr>
                  <tr class="table-success">
                    <td>Total Pendapatan</td>
                    <td class="text-right"><b>Rp<?= number_format($total_pendapatan) ?></b></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>


          <div class="card">
            <div class="card-body mt-1 p-0 table-responsive-sm">
              <table class="table table-sm w-100">
                <thead>
                  <tr>
                    <th>Jenis</th>
                    <th class="text-right">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $total_keluar = 0;
                  foreach ($data['kas_keluar'] as $a) {
                    echo "<tr>";
                    echo "<td class=''>" . $a['note_primary'] . "</td>";
                    echo "<td class='text-right'><b>Rp" . number_format($a['total']) . "</b></td>";
                    echo "</tr>";
                    $total_keluar += $a['total'];
                  }

                  $gaji = $data['gaji'];
                  $gaji = (int)$gaji;

                  if ($gaji > 0) {
                    echo "<tr>";
                    echo "<td class=''>Gaji Karyawan</td>";
                    echo "<td class='text-right'><b>Rp" . number_format($gaji) . "</b></td>";
                    echo "</tr>";
                    $total_keluar += $gaji;
                  }

                  ?>
                </tbody>
              </table>
            </div>
            <br>
            <div class="card-body p-0 table-responsive-sm">
              <table class="table table-sm w-100">
                <tbody>
                  <tr class="table-danger">
                    <td><b>Total Pengeluaran</b></td>
                    <td class="text-right"><b>Rp<?= number_format($total_keluar) ?></b></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card bg-secondary">
            <div class="card-body m-0 p-0 table-responsive-sm">
              <table class="table table-sm w-100">
                <tbody>
                  <?php
                  echo "<tr>";
                  echo "<td class=''>Laba/Rugi</td>";
                  echo "<td class='text-right'><b>Rp " . number_format($total_pendapatan - $total_keluar) . "</b></td>";
                  echo "</tr>";
                  ?>
                </tbody>
              </table>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>