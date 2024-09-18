<?php

class Kasbon extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->data();
   }

   public function insert()
   {
      $karyawan = $_POST['f1'];
      $jumlah = $_POST['f2'];
      $pembuat = $_POST['f3'];
      $today = date('Y-m-d');
      $metode = $_POST['metode'];
      $note = $_POST['note'];

      if ($metode == 1) {
         $sm = 3;
      } else {
         $sm = 2;
      }

      $ref_f = date('YmdHis') . rand(0, 9) . rand(0, 9) . rand(0, 9);
      $cols = 'id_cabang, jenis_mutasi, jenis_transaksi, metode_mutasi, status_mutasi, jumlah, id_user, id_client, note_primary, note, ref_finance';
      $vals = $this->id_cabang . ",2,5," . $metode . "," . $sm . "," . $jumlah . "," . $pembuat . "," . $karyawan . ", 'Kasbon', '" . $note . "', '" . $ref_f . "'";

      $setOne = "id_client = " . $karyawan . " AND insertTime LIKE '" . $today . "%'";
      $where = $this->wCabang . " AND " . $setOne;
      $data_main = $this->db(1)->count_where('kas', $where);

      if ($data_main < 1) {
         print_r($this->db(1)->insertCols('kas', $cols, $vals));
      } else {
         echo "Tidak dapat Cashbon 2x/Hari";
      }
   }

   public function tarik_kasbon()
   {
      $id = $_POST['id'];
      $set = "sumber_dana = 2, status_transaksi = 2";
      $where = "id_kasbon = " . $id;
      $this->db(1)->update('kas', $set, $where);
   }

   public function batal_kasbon()
   {
      $id = $_POST['id'];
      $set = "sumber_dana = 0, status_transaksi = 4";
      $where = "id_kasbon = " . $id;
      $this->db(1)->update('kas', $set, $where);
   }
}
