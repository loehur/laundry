<?php

class Poin extends Controller
{

   public function __construct()
   {
      $this->session_cek();
      $this->data();
      $this->table = 'poin';
   }

   public function menu()
   {
      if (isset($_POST['pelanggan'])) {
         $pelanggan = $_POST['pelanggan'];
         $this->tampilkanMenu($pelanggan);
         $this->tampilkan($pelanggan);
      } else {
         $pelanggan = 0;
         $this->tampilkanMenu($pelanggan);
      }
   }

   public function tampilkan($pelanggan)
   {
      $viewData = 'poin/viewData';

      $where = $this->wCabang . " AND id_pelanggan = " . $pelanggan . " AND bin = 0 AND id_poin > 0";
      $data_main = $this->model('M_DB_1')->get_where('penjualan', $where);

      $where = $this->wCabang . " AND id_pelanggan = " . $pelanggan . " AND id_poin > 0";
      $data_member = $this->model('M_DB_1')->get_where('member', $where);

      $where = $this->wCabang . " AND id_pelanggan = " . $pelanggan . " ORDER BY id_poin DESC";
      $data_manual = $this->model('M_DB_1')->get_where('poin', $where);

      $this->view($viewData, ['data_main' => $data_main, 'data_manual' => $data_manual, 'data_member' => $data_member, 'pelanggan' => $pelanggan]);
   }

   public function tampilkanMenu($pelanggan)
   {
      $view = 'poin/poinMenu';
      $data_operasi = ['title' => 'Poin'];
      $this->view('layout', ['data_operasi' => $data_operasi]);
      $this->view($view, ['data_operasi' => $data_operasi, 'pelanggan' => $pelanggan]);
   }

   public function insert($pelanggan)
   {
      $keterangan = $_POST['f1'];
      $poin = $_POST['f2'];
      $tanggalSekarang = date("Y-m-d");
      $cols = 'id_cabang, id_pelanggan, keterangan, poin_jumlah, id_user';
      $vals = $this->id_cabang . "," . $pelanggan . ",'" . $keterangan . "'," . $poin . "," . $this->id_user;
      $where = $this->wCabang . " AND id_pelanggan = " . $pelanggan . " AND keterangan = '" . $keterangan . "' AND poin_jumlah = " . $poin . " AND insertTime LIKE '" . $tanggalSekarang . "%'";
      $data_main = $this->model('M_DB_1')->count_where($this->table, $where);
      if ($data_main < 1) {
         $this->model('M_DB_1')->insertCols($this->table, $cols, $vals);
      }

      $this->tampilkanMenu($pelanggan);
      $this->tampilkan($pelanggan);
   }
}
