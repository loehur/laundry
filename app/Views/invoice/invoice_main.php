<?php
$idPelanggan = $data['pelanggan'];
$pelanggan = '';
foreach ($this->pelanggan as $c) {
  if ($c['id_pelanggan'] == $idPelanggan) {
    $pelanggan = $c['nama_pelanggan'];
  }
}

if (count($data['dataTanggal']) > 0) {
  $currentMonth =   $data['dataTanggal']['bulan'];
  $currentYear =   $data['dataTanggal']['tahun'];

  $dateObj   = DateTime::createFromFormat('!m', $currentMonth);
  $monthName = $dateObj->format('F'); // March

  $periode = "<br><small>Periode <b>" . $monthName . " " . $currentYear . "</b></small>";
} else {
  $currentMonth = date('m');
  $currentYear = date('Y');
  $periode = "";
}

?>

<head>
  <meta charset="utf-8">
  <link rel="icon" href="<?= $this->ASSETS_URL ?>icon/logo.png">
  <title><?= strtoupper($pelanggan) ?> | MDL</title>
  <meta name="viewport" content="width=480px, user-scalable=no">
  <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/ionicons.min.css">
  <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/fontawesome-free-5.15.4-web/css/all.css">
  <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/adminLTE-3.1.0/css/adminlte.min.css">

  <!-- FONT -->
  <style>
    @font-face {
      font-family: 'Titillium Web';
      font-style: normal;
      font-weight: 400;
      font-display: swap;
      src: url('<?= $this->ASSETS_URL ?>font/titilium.woff2') format('woff2');
      unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    html .table {
      font-family: 'Titillium Web', sans-serif;
    }

    html .content {
      font-family: 'Titillium Web', sans-serif;
    }

    html body {
      font-family: 'Titillium Web', sans-serif;
    }

    table {
      border-radius: 15px;
      overflow: hidden
    }
  </style>
</head>

<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Filter Periode</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <!-- ====================== FORM ========================= -->
        <form action="<?= $this->BASE_URL ?>I/i/<?= $data['laundry'] ?>/<?= $idPelanggan ?>" method="POST">
          <div class="card-body">
            <div class="d-flex align-items-start align-items-end">
              <div class="form-group">
                <label>Bulan</label>
                <select name="m" class="form-control form-control-sm mr-2" style="width: 50px;" required>
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
              </div>
              <div class="form-group">
                <label>Tahun</label>
                <select name="Y" class="form-control form-control-sm" style="width: 50px;" required>
                  <?php
                  $thisMonth = date("Y");
                  for ($x = $thisMonth - 1; $x <= $thisMonth; $x++) { ?>
                    <option class="text-right" value="<?= $x ?>" <?php if ($currentYear == $x) {
                                                                    echo 'selected';
                                                                  } ?>><?= $x ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </div>
        </form>
        <a href="" class="btn btn-sm btn-secondary">Reset</a>
      </div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid mb-1 ml-1 pt-2 border border-bottom" style="position: sticky; top:0px; background-color:white;z-index:2">
    <div class="row p-1">
      <div class="col m-auto" style="max-width: 480px;">
        Bpk/Ibu. <span class="text-success"><b><?= strtoupper($pelanggan) ?></b></span><span><?php echo $periode; ?></span>
        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-filter float-right text-info"></i></a>
        <br>
        <?php
        $paket_count = count($data['listPaket']);
        if ($paket_count > 0) {
          echo "<span class=''>";
          echo "Riwayat Member: ";
          foreach ($data['listPaket'] as $lp) {
            $id_harga = $lp['id_harga'];
            echo "<a href='" . $this->BASE_URL . "I/m/" . $data['laundry'] . "/" . $idPelanggan . "/" . $id_harga . "'><span class='border rounded pr-1 pl-1 border-warning'>M" . $id_harga . "</span></a> ";
          }
          echo "</span>";
        }
        ?>
      </div>
    </div>
  </div>

  <?php
  $prevRef = '';
  $prevPoin = 0;

  $arrRef = array();
  $countRef = 0;

  $arrPoin = array();
  $jumlahRef = 0;


  foreach ($data['data_main'] as $a) {
    $ref = $a['no_ref'];

    if ($prevRef <> $a['no_ref']) {
      $countRef = 0;
      $countRef++;
      $arrRef[$ref] = $countRef;
    } else {
      $countRef++;
      $arrRef[$ref] = $countRef;
    }
    $prevRef = $ref;
  }

  $no = 0;
  $urutRef = 0;
  $arrCount = 0;
  $arrPoiny =  array();
  $arrGetPoin = array();
  $arrTotalPoin = array();
  $arrBayar = array();
  $arrTuntas = array();

  $Rtotal_tagihan = 0;
  $Rtotal_dibayar = 0;
  $Rsisa_tagihan = 0;

  foreach ($data['data_main'] as $a) {
    $no++;
    $id = $a['id_penjualan'];
    $f10 = $a['id_penjualan_jenis'];
    $f3 = $a['id_item_group'];
    $f4 = $a['list_item'];
    $f5 = $a['list_layanan'];
    $f11 = $a['id_durasi'];
    $f6 = $a['qty'];
    $f7 = $a['harga'];
    $f8 = $a['note'];
    $f9 = $a['id_user'];
    $f1 = $a['insertTime'];
    $f12 = $a['hari'];
    $f13 = $a['jam'];
    $f14 = $a['diskon_qty'];
    $f15 = $a['diskon_partner'];
    $f16 = $a['min_order'];
    $f17 = $a['id_pelanggan'];
    $f18 = $a['id_user'];
    $noref = $a['no_ref'];
    $letak = $a['letak'];
    $id_ambil = $a['id_user_ambil'];
    $tgl_ambil = $a['tgl_ambil'];
    $idPoin = $a['id_poin'];
    $perPoin = $a['per_poin'];
    $timeRef = $f1;
    $member = $a['member'];
    $showMember = "";

    if ($f12 <> 0) {
      $tgl_selesai = date('d-m-Y', strtotime($f1 . ' +' . $f12 . ' days +' . $f13 . ' hours'));
    } else {
      $tgl_selesai = date('d-m-Y H:i', strtotime($f1 . ' +' . $f12 . ' days +' . $f13 . ' hours'));
    }

    $karyawan = '';
    foreach ($this->userMerge as $c) {
      if ($c['id_user'] == $f18) {
        $karyawan = $c['nama_user'];
        $karyawan_id = $c['id_user'];
      }
    }

    $penjualan = "";
    $satuan = "";
    foreach ($this->dPenjualan as $l) {
      if ($l['id_penjualan_jenis'] == $f10) {
        $penjualan = $l['penjualan_jenis'];
        foreach ($this->dSatuan as $sa) {
          if ($sa['id_satuan'] == $l['id_satuan']) {
            $satuan = $sa['nama_satuan'];
          }
        }
      }
    }

    $show_qty = "";
    $qty_real = 0;
    if ($f6 < $f16) {
      $qty_real = $f16;
      $show_qty = $f6 . $satuan . " (Min. " . $f16 . $satuan . ")";
    } else {
      $qty_real = $f6;
      $show_qty = $f6 . $satuan;
    }

    if ($idPoin > 0) {
      if (isset($arrPoin[$noref][$idPoin]) ==  TRUE) {
        $arrPoin[$noref][$idPoin] = $arrPoin[$noref][$idPoin] + ($qty_real * $f7);
      } else {
        $arrPoin[$noref][$idPoin] = ($qty_real * $f7);
      }
      $arrGetPoin[$noref][$idPoin] = $arrPoin[$noref][$idPoin] / $perPoin;

      $gPoin = 0;
      if (isset($arrGetPoin[$noref][$idPoin]) == TRUE) {
        foreach ($arrGetPoin[$noref] as $gpp) {
          $gPoin = $gPoin + $gpp;
        }
        $arrTotalPoin[$noref] = floor($gPoin);
      }
    }

    if ($no == 1) {
      $adaBayar = false;
      echo '<div class="container-fluid">';
      echo '<div class="row p-1">';
      echo "<div class='col m-auto w-100 backShow " . strtoupper($pelanggan) . " p-0 m-1 rounded' style='max-width:460;'><div class='bg-white rounded border border-success'>";
      echo "<table class='table table-sm m-0 rounded w-100'>";
      $lunas = false;
      $totalBayar = 0;
      $subTotal = 0;
      $urutRef++;

      $dateToday = date("Y-m-d");
      if (strpos($f1, $dateToday) !== FALSE) {
        $classHead = 'table-primary';
      } else {
        $classHead = 'table-success';
      }
    }

    foreach ($data['kas'] as $byr) {
      if ($byr['ref_transaksi'] ==  $noref && $byr['status_mutasi'] == 3) {
        $idKas = $byr['id_kas'];
        $arrBayar[$noref][$idKas] = $byr['jumlah'];
        $totalBayar = array_sum($arrBayar[$noref]);
      }
      if ($byr['ref_transaksi'] ==  $noref) {
        $adaBayar = true;
      }
    }

    $kategori = "";
    foreach ($this->itemGroup as $b) {
      if ($b['id_item_group'] == $f3) {
        $kategori = $b['item_kategori'];
      }
    }

    $durasi = "";
    foreach ($this->dDurasi as $b) {
      if ($b['id_durasi'] == $f11) {
        $durasi = "<small>" . ucwords($b['durasi']) . "</small>";
      }
    }

    $userAmbil = "";
    $endLayananDone = false;
    $list_layanan = "<small><b><i class='fas fa-check-circle text-success'></i></b> Diterima <span style='white-space: pre;'>" . substr($f1, 5, 11) . "</span></small><br>";
    $list_layanan_print = "";
    $arrList_layanan = unserialize($f5);
    $endLayanan = end($arrList_layanan);
    $doneLayanan = 0;
    $countLayanan = count($arrList_layanan);
    foreach ($arrList_layanan as $b) {
      $check = 0;
      foreach ($this->dLayanan as $c) {
        if ($c['id_layanan'] == $b) {
          foreach ($data['operasi'] as $o) {
            if ($o['id_penjualan'] == $id && $o['jenis_operasi'] == $b) {
              $user = "";
              $check++;
              if ($b == $endLayanan) {
                $endLayananDone = true;
              }
              foreach ($this->userMerge as $p) {
                if ($p['id_user'] == $o['id_user_operasi']) {
                  $user = $p['nama_user'];
                }
                if ($p['id_user'] == $id_ambil) {
                  $userAmbil = $p['nama_user'];
                }
              }
              $list_layanan = $list_layanan . "<small><b><i class='fas fa-check-circle text-success'></i></b> " . $c['layanan'] . " <span style='white-space: pre;'>" . substr($o['insertTime'], 5, 11) . "</span></small><br>";
              $doneLayanan++;
              $enHapus = false;
            }
          }
          if ($check == 0) {
            if ($b == $endLayanan) {
              $list_layanan = $list_layanan . "<span id='" . $id . $b . "' data-layanan='" . $c['layanan'] . "' data-value='" . $c['id_layanan'] . "' data-id='" . $id . "' data-bs-toggle='modal' data-bs-target='#exampleModal' class='endLayanan'><span class=''><small><i class='fas fa-info-circle text-info'></i> " . $c['layanan'] . "</small></span> <br>";
            } else {
              $list_layanan = $list_layanan . "<span id='" . $id . $b . "' data-layanan='" . $c['layanan'] . "' data-value='" . $c['id_layanan'] . "' data-id='" . $id . "' data-bs-toggle='modal' data-bs-target='#exampleModal' class='addOperasi'><span class=''><small><i class='fas fa-info-circle text-info'></i> " . $c['layanan'] . "</small></span> <br>";
            }
          }
          $list_layanan_print = $list_layanan_print . $c['layanan'] . " ";
        }
      }
    }

    $ambilDone = false;
    if ($id_ambil > 0) {
      $list_layanan = $list_layanan . "<small><b><i class='fas fa-check-circle text-success'></i></b> Ambil <span style='white-space: pre;'>" . substr($tgl_ambil, 5, 11) . "</span></small><br>";
      $ambilDone = true;
    }

    $buttonAmbil = "";
    if ($id_ambil == 0 && $endLayananDone == true) {
      $buttonAmbil = "<button data-id='" . $id . "' data-ref='" . $noref . "' data-bs-toggle='modal' data-bs-target='#exampleModal4' class='badge badge-dark ambil ambil" . $id . "'>Ambil</button>";
    }


    $list_layanan = $list_layanan . "<span class='operasiAmbil" . $id . "'></span>";

    $diskon_qty = $f14;
    $diskon_partner = $f15;

    $show_diskon_qty = "";
    if ($diskon_qty > 0) {
      $show_diskon_qty = $diskon_qty . "%";
    }
    $show_diskon_partner = "";
    if ($diskon_partner > 0) {
      $show_diskon_partner = $diskon_partner . "%";
    }
    $plus = "";
    if ($diskon_qty > 0 && $diskon_partner > 0) {
      $plus = " + ";
    }
    $show_diskon = $show_diskon_qty . $plus . $show_diskon_partner;

    $itemList = "";
    $itemListPrint = "";
    if (strlen($f4) > 0) {
      $arrItemList = unserialize($f4);
      $arrCount = count($arrItemList);
      if ($arrCount > 0) {
        foreach ($arrItemList as $key => $k) {
          foreach ($this->dItem as $b) {
            if ($b['id_item'] == $key) {
              $itemList = $itemList . "<span class='badge badge-light text-dark'>" . $b['item'] . "[" . $k . "]</span> ";
              $itemListPrint = $itemListPrint . $b['item'] . "[" . $k . "]";
            }
          }
        }
      }
    }

    $total = $f7 * $qty_real;

    if ($member == 0) {
      if ($diskon_qty > 0 && $diskon_partner == 0) {
        $total = $total - ($total * ($diskon_qty / 100));
      } else if ($diskon_qty == 0 && $diskon_partner > 0) {
        $total = $total - ($total * ($diskon_partner / 100));
      } else if ($diskon_qty > 0 && $diskon_partner > 0) {
        $total = $total - ($total * ($diskon_qty / 100));
        $total = $total - ($total * ($diskon_partner / 100));
      } else {
        $total = ($f7 * $qty_real);
      }
    } else {
      $total = 0;
    }

    $subTotal = $subTotal + $total;
    $Rtotal_tagihan = $Rtotal_tagihan + $total;

    foreach ($arrRef as $key => $m) {
      if ($key == $noref) {
        $arrCount = $m;
      }
    }

    $show_total = "";
    $show_total_print = "";
    $show_total_notif = "";

    $show_total = "";
    $show_total_print = "";
    $show_total_notif = "";

    if ($member == 0) {
      if (strlen($show_diskon) > 0) {
        $tampilDiskon = "(Disc. " . $show_diskon . ")";
        $show_total = "<del>Rp" . number_format($f7 * $qty_real) . "</del><br>Rp" . number_format($total);
      } else {
        $tampilDiskon = "";
        $show_total = "Rp" . number_format($total);
      }
    } else {
      $show_total = "<span class='badge badge-success'>Member</span>";
      $tampilDiskon = "";
    }

    $showNote = "";
    if (strlen($f8) > 0) {
      $showNote = $f8;
    }

    $classTRDurasi = "";
    if ($f11 <> 11) {
      $classTRDurasi = "table-warning";
    }

    if ($totalBayar > 0) {
      $cekDisable = "disabled";
    } else {
      $cekDisable = "";
    }
    $showCheckbox = "<input class='cek' type='checkbox' data-total='" . $total . "' checked " . $cekDisable . ">";

    echo "<td class='pt-0 pb-0'><span style='white-space: nowrap;'></span><small>[" . $id . "]</small> <span style='white-space: pre;'>" . $durasi . " <small>(" . $f12 . "h " . $f13 . "j)</span><br><b>" . $kategori . "</b><span class='badge badge-light'></span><br><b>" . $show_qty . "</b> " . $tampilDiskon . "<br>" . $itemList . "</td>";
    echo "<td nowrap class='pt-1'>" . $list_layanan . "</td>";
    echo "<td class='text-right pt-0 pb-0'>" . $showCheckbox . " " . $show_total . "</td>";
    echo "</tr>";
    echo "<tr>";
    if (strlen($f8) > 0) {
      echo "<td style='border-top:0' colspan='5' class='m-0 pt-0'><span class='badge badge-warning'>" . $f8 . "</span></td>";
    }
    echo " </tr>";

    $showMutasi = "";
    $userKas = "";
    foreach ($data['kas'] as $ka) {
      if ($ka['ref_transaksi'] == $noref) {
        $stBayar = "";
        foreach ($this->dStatusMutasi as $st) {
          if ($ka['status_mutasi'] == $st['id_status_mutasi']) {
            $stBayar = $st['status_mutasi'];
          }
        }

        $notenya = strtoupper($ka['note']);

        switch ($ka['status_mutasi']) {
          case '2':
            $statusM = "<span class='text-info'>" . $stBayar . " <b>(" . $notenya . ")</b></span> ";
            break;
          case '3':
            $statusM = "<b><i class='fas fa-check-circle text-success'></i></b> " . $notenya . " ";
            break;
          case '4':
            $statusM = "<span class='text-danger text-bold'><i class='fas fa-times-circle'></i> " . $stBayar . " <b>(" . $notenya . ")</b></span> ";
            break;
          default:
            $statusM = "Non Status - ";
            break;
        }

        if ($ka['status_mutasi'] == 4) {
          $nominal = "<s>-Rp" . number_format($ka['jumlah']) . "</s>";
        } else {
          $nominal = "-Rp" . number_format($ka['jumlah']);
        }

        $showMutasi = $showMutasi . "<small>" . $statusM . "#" . $ka['id_kas'] . " [" . substr($ka['insertTime'], 5, 11) . "]</small> " . $nominal . "</small><br>";
      }
    }

    if ($arrCount == $no) {

      //SURCAS
      foreach ($data['surcas'] as $sca) {
        if ($sca['no_ref'] == $noref) {
          foreach ($this->surcasPublic as $sc) {
            if ($sc['id_surcas_jenis'] == $sca['id_jenis_surcas']) {
              $surcasNya = $sc['surcas_jenis'];
            }
          }

          $jumlahCas = $sca['jumlah'];
          $Rtotal_tagihan += $jumlahCas;
          $tglCas = "<small><i class='fas fa-check-circle text-success'></i> Surcharged <span style='white-space: pre;'>" . substr($sca['insertTime'], 5, 11) . "</span></small><br>";
          echo "<tr><td><small>" . $surcasNya . "</small></td><td>" . $tglCas . "</td><td align='right'>Rp" . number_format($jumlahCas) . "</td></tr>";
          $subTotal += $jumlahCas;
        }
      }

      $Rtotal_dibayar = $Rtotal_dibayar + $totalBayar;
      $sisaTagihan = intval($subTotal) - $totalBayar;
      $textPoin = "";
      if (isset($arrTotalPoin[$noref]) && $arrTotalPoin[$noref] > 0) {
        $textPoin = "(+" . $arrTotalPoin[$noref] . ")";
      }
      echo "<span class='d-none' id='poin" . $urutRef . "'>" . $textPoin . "</span>";
      if ($sisaTagihan < 1) {
        $lunas = true;
      }
      echo "<tr class='row" . $noref . " table-borderless'>";
      if ($lunas == true && $endLayananDone == true && $ambilDone == true && $modeView == 1) {
        array_push($arrTuntas, $noref);
      }
      if ($lunas == false) {
        echo "<td nowrap colspan='3' class='text-right pt-0 pb-0'><small><font color='green'>" . $textPoin . "</font></small> <span class='showLunas" . $noref . "'></span><b> Rp" . number_format($subTotal) . "</b><br>";
      } else {
        echo "<td nowrap colspan='3' class='text-right pt-0 pb-0'><small><font color='green'>" . $textPoin . "</font></small>  <b><i class='fas fa-check-circle text-success'></i> Rp" . number_format($subTotal) . "</b><br>";
      }
      echo "</td></tr>";

      if ($adaBayar == true) {
        echo "<tr class='row" . $noref . " table-borderless'>";
        echo "<td nowrap colspan='4' class='text-right pt-0 pb-0'>";
        echo $showMutasi;
        echo "<span class='text-danger sisaTagihan" . $noref . "'>";
        if (($sisaTagihan < intval($subTotal)) && (intval($sisaTagihan) > 0)) {
          echo  "<b><i class='fas fa-exclamation-circle'></i> Sisa Rp" . number_format($sisaTagihan) . "</b>";
        }
        echo "</span>";
        echo "</td>";
        echo "</tr>";
      }
  ?>
    <?php
      $totalBayar = 0;
      $sisaTagihan = 0;
      $no = 0;
      $subTotal = 0;

      echo "</tbody></table>";
      echo "</div></div></div></div>";
    }
  }

  foreach ($data['data_member'] as $z) { ?>
    <div class="container-fluid">
      <div class="row p-1">
        <div class='col m-auto w-100 backShow " . strtoupper($pelanggan) . " p-0 m-1 rounded' style='max-width:460;'>
          <div class='bg-white rounded border border-primary'>
            <table class='table table-sm m-0 rounded w-100'>
              <tbody>
                <?php
                $id = $z['id_member'];
                $id_harga = $z['id_harga'];
                $harga = $z['harga'];
                $id_user = $z['id_user'];
                $kategori = "";
                $layanan = "";
                $durasi = "";
                $unit = "";
                $idPoin = $z['id_poin'];
                $perPoin = $z['per_poin'];

                $gPoin = 0;
                $gPoinShow = "";
                if ($idPoin > 0) {
                  $gPoin = floor($harga / $perPoin);
                  $gPoinShow = "<small class='text-success'>(+" . $gPoin . ")</small>";
                }

                $showMutasi = "";
                $userKas = "";
                foreach ($data['kasM'] as $ka) {
                  if ($ka['ref_transaksi'] == $id) {
                    $stBayar = "";
                    foreach ($this->dStatusMutasi as $st) {
                      if ($ka['status_mutasi'] == $st['id_status_mutasi']) {
                        $stBayar = $st['status_mutasi'];
                      }
                    }

                    $notenya = strtoupper($ka['note']);
                    $st_mutasi = $ka['status_mutasi'];

                    switch ($st_mutasi) {
                      case '2':
                        $statusM = "<span class='text-info'>" . $stBayar . " <b>(" . $notenya . ")</b></span> - ";
                        break;
                      case '3':
                        $statusM = "<b><i class='fas fa-check-circle text-success'></i></b> " . $notenya . " ";
                        break;
                      case '4':
                        $statusM = "<span class='text-danger text-bold'><i class='fas fa-times-circle'></i> " . $stBayar . " <b>(" . $notenya . ")</b></span> - ";
                        break;
                      default:
                        $statusM = "Non Status - ";
                        break;
                    }

                    if ($st_mutasi == 4) {
                      $nominal = "<s>-Rp" . number_format($ka['jumlah']) . "</s>";
                    } else {
                      $nominal = "-Rp" . number_format($ka['jumlah']);
                    }

                    $showMutasi = $showMutasi . "<small>" . $statusM . "<b>#" . $ka['id_kas'] . " </b> [" . substr($ka['insertTime'], 5, 11) . "] " . $nominal . "</small><br>";
                  }
                }

                foreach ($this->harga as $a) {
                  if ($a['id_harga'] == $z['id_harga']) {
                    foreach ($this->dPenjualan as $dp) {
                      if ($dp['id_penjualan_jenis'] == $a['id_penjualan_jenis']) {
                        foreach ($this->dSatuan as $ds) {
                          if ($ds['id_satuan'] == $dp['id_satuan']) {
                            $unit = $ds['nama_satuan'];
                          }
                        }
                      }
                    }
                    foreach (unserialize($a['list_layanan']) as $b) {
                      foreach ($this->dLayanan as $c) {
                        if ($b == $c['id_layanan']) {
                          $layanan = $layanan . " " . $c['layanan'];
                        }
                      }
                    }
                    foreach ($this->dDurasi as $c) {
                      if ($a['id_durasi'] == $c['id_durasi']) {
                        $durasi = $durasi . " " . $c['durasi'];
                      }
                    }

                    foreach ($this->itemGroup as $c) {
                      if ($a['id_item_group'] == $c['id_item_group']) {
                        $kategori = $kategori . " " . $c['item_kategori'];
                      }
                    }
                  }
                }
                $adaBayar = false;
                $historyBayar = array();
                foreach ($data['kasM'] as $k) {
                  if ($k['ref_transaksi'] == $id && $k['status_mutasi'] == 3) {
                    array_push($historyBayar, $k['jumlah']);
                  }
                  if ($k['ref_transaksi'] == $id) {
                    $adaBayar = true;
                  }
                }

                $statusBayar = "";
                $totalBayar = array_sum($historyBayar);
                $showSisa = "";
                $sisa = $harga;
                $lunas = false;
                $enHapus = true;
                if ($totalBayar > 0) {
                  $enHapus = false;
                  if ($totalBayar >= $harga) {
                    $lunas = true;
                    $statusBayar = "<b><i class='fas fa-check-circle text-success'></i></b>";
                    $sisa = 0;
                  } else {
                    $sisa = $harga - $totalBayar;
                    $showSisa = "<b><i class='fas fa-exclamation-circle'></i> Sisa Rp" . number_format($sisa) . "</b>";
                    $lunas = false;
                  }
                } else {
                  $lunas = false;
                }

                $Rtotal_tagihan = $Rtotal_tagihan + $sisa;

                ?>
                <tr>
                  <td nowrap>
                    <small><?= "[" . $id . "] <b>Deposit Paket Member</b> [" . substr($z['insertTime'], 5, 11) . "]" ?>
                      <br><b><?= $z['qty'] . $unit . "</b> | " . $kategori ?> * <?= $layanan ?> * <?= $durasi ?></small>
                  </td>
                  <td nowrap class="text-right"><span id="statusBayar<?= $id ?>"><?= $statusBayar ?></span>&nbsp;
                    <span class="float-right"><?= $gPoinShow ?> <b>Rp<?= number_format($harga) ?></b></span>
                  </td>
                </tr>
                <?php if ($adaBayar == true) { ?>
                  <tr>
                    <td colspan="2" align="right"><span id="historyBayar<?= $id ?>"><?= $showMutasi ?></span>
                      </span><span id="sisa<?= $id ?>" class="text-danger"><?= $showSisa ?></span></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php
      echo "</tbody></table>";
      echo "</div></div></div></div>";
    } ?>

      <div class="row p-1">
        <div class="col m-auto w-100 rounded border border-dark bg-light" style="max-width: 460;">
          <div class="d-flex align-items-start align-items-end">
            <div class="mr-auto">
              Total Tagihan
            </div>
            <div class="">
              Rp<?= number_format($Rtotal_tagihan) ?>
            </div>
          </div>
          <div class="d-flex align-items-start align-items-end">
            <div class="mr-auto">
              Total Tertunda
            </div>
            <div class="">
              Rp<span id="pending">0</span>
            </div>
          </div>
          <div class="d-flex align-items-start align-items-end">
            <div class="mr-auto">
              Total Dibayar
            </div>
            <div class="">
              Rp<?= number_format($Rtotal_dibayar) ?>
            </div>
          </div>
          <hr class="m-0 p-0">
          <div class="d-flex align-items-start align-items-end">
            <div class="mr-auto">
              <b>Sisa Tagihan</b>
            </div>
            <div class="">
              <b>Rp<span id='sisa'><?= number_format($Rtotal_tagihan - $Rtotal_dibayar) ?></span></b>
            </div>
          </div>
        </div>
      </div>
      </div>

      <!-- SCRIPT -->
      <script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
      <script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
      <script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>

      <script>
        $(document).ready(function() {
          var sisa = <?= ($Rtotal_tagihan - $Rtotal_dibayar) ?>;;
          var totalTagihan = <?= $Rtotal_tagihan ?>;
          var tunda = 0;

          $("input.cek").change(function() {
            var total = $(this).attr("data-total");

            if ($(this).is(':checked')) {
              tunda = parseInt(tunda) + parseInt(total);
              $("span#pending").html(tunda.toLocaleString('en-US'));
              sisa = parseInt(sisa) + parseInt(total);
              $("span#sisa").html(sisa.toLocaleString('en-US'));
            } else {
              tunda = parseInt(tunda) - parseInt(total);
              $("span#pending").html(tunda.toLocaleString('en-US'));
              sisa = parseInt(sisa) - parseInt(total);
              $("span#sisa").html(sisa.toLocaleString('en-US'));
            }
          })
        })
      </script>