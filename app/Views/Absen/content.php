<div class="card p-3 mt-1">
  <table class="table table-sm mb-0" style="width: 100%;">
    <?php foreach ($data as $d) {

      foreach ($this->userMerge as $c) {
        if ($c['id_user'] == $d['id_karyawan']) {
          $nama = "" . $c['nama_user'] . "";
        }
      }

      if ($d['jenis'] == 0) {
        $jenis = "Harian";
      } else {
        $jenis = "Jaga Malam";
      }

    ?>
      <tr>
        <td>#<?= $d['id'] ?></td>
        <td><span class="text-success"><i class="far fa-check-circle"></i></span> <?= $jenis ?></td>
        <td><?= $nama ?></td>
        <td><i class="far fa-clock"></i> <?= $d['jam'] ?></td>
      </tr>
    <?php } ?>
  </table>
</div>