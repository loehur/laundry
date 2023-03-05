<form action="<?= $this->BASE_URL ?>SaldoTunai/deposit/<?= $data['pelanggan']; ?>" method="POST">
  <div class="modal-body">
    <div class="card-body">
      <div class="row">
        <div class="col">
          <label for="exampleInputEmail1">Jumlah Deposit Tunai</label>
          <input type="number" min="0" name="jumlah" class="form-control form-control-sm" required>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label for="exampleInputEmail1">Metode</label>
            <select name="metode" class="form-control form-control-sm metodeBayar" style="width: 100%;" required>
              <?php foreach ($this->dMetodeMutasi as $a) { ?>
                <option value="<?= $a['id_metode_mutasi'] ?>"><?= $a['metode_mutasi'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="row" id="nTunai">
        <div class="col-sm-12">
          <div class="form-group">
            <div class="form-group">
              <label for="exampleInputEmail1" class="text-danger">Catatan Non Tunai <small>(Contoh: BRI)</small></label>
              <input type="text" name="noteBayar" maxlength="10" class="form-control form-control-sm border-danger" placeholder="" style="text-transform:uppercase">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-auto" style="min-width: 200px;">
          <label for="exampleInputEmail1">Karyawan</label>
          <select name="staf" class="tarik form-control form-control-sm" style="width: 100%;" required>
            <option value="" selected disabled></option>
            <optgroup label="<?= $this->dLaundry['nama_laundry'] ?> [<?= $this->dCabang['kode_cabang'] ?>]">
              <?php foreach ($this->user as $a) { ?>
                <option id="<?= $a['id_user'] ?>" value="<?= $a['id_user'] ?>"><?= $a['id_user'] . "-" . strtoupper($a['nama_user']) ?></option>
              <?php } ?>
            </optgroup>
            <?php if (count($this->userCabang) > 0) { ?>
              <optgroup label="----- Cabang Lain -----">
                <?php foreach ($this->userCabang as $a) { ?>
                  <option id="<?= $a['id_user'] ?>" value="<?= $a['id_user'] ?>"><?= $a['id_user'] . "-" . strtoupper($a['nama_user']) ?></option>
                <?php } ?>
              </optgroup>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
  </div>
</form>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/popper.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/select2/select2.min.js"></script>

<script>
  $(document).ready(function() {
    selectList();
    $("div#nTunai").hide();
  });

  function selectList() {
    $('select.tarik').select2({
      dropdownParent: $("#exampleModal"),
    });
    $('select.orderDeposit').select2({
      dropdownParent: $("#exampleModal"),
    });
  }

  $("select.metodeBayar").on("keyup change", function() {
    if ($(this).val() == 2) {
      $("div#nTunai").show();
    } else {
      $("div#nTunai").hide();
    }
  });
</script>