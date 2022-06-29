<?php

class Kasbon extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->data();
      $this->table = 'kas';
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

      $cols = 'id_cabang, jenis_mutasi, jenis_transaksi, metode_mutasi, status_mutasi, status_transaksi, jumlah, id_user, id_client, note_primary, note';
      $vals = $this->id_cabang . ",2,5," . $metode . "," . $sm . ",0," . $jumlah . "," . $pembuat . "," . $karyawan . ", 'Kasbon', '" . $note . "'";

      $setOne = "id_client = " . $karyawan . " AND insertTime LIKE '" . $today . "%'";
      $where = $this->wCabang . " AND " . $setOne;
      $data_main = $this->model('M_DB_1')->count_where($this->table, $where);

      if ($data_main < 1) {
         print_r($this->model('M_DB_1')->insertCols('kas', $cols, $vals));
      }
   }

   public function tarik_kasbon()
   {
      $id = $_POST['id'];
      $set = "sumber_dana = 2, status_transaksi = 2";
      $where = $this->wLaundry . " AND id_kasbon = " . $id;
      $this->model('M_DB_1')->update($this->table, $set, $where);
   }

   public function batal_kasbon()
   {
      $id = $_POST['id'];
      $set = "sumber_dana = 0, status_transaksi = 4";
      $where = $this->wLaundry . " AND id_kasbon = " . $id;
      $this->model('M_DB_1')->update($this->table, $set, $where);
   }
}
