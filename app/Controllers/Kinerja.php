<?php

class Kinerja extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->data();
   }

   public function index($mode = 1)
   {
      $operasi = array();
      $dataTanggal = array();
      $data_main = array();
      $data_terima = array();
      $data_kembali = array();

      if ($mode == 1) {
         $data_operasi = ['title' => 'Kinerja Bulanan'];
         $view = "bulanan";
      } else {
         $data_operasi = ['title' => 'Kinerja Harian'];
         $view = "harian";
      }

      //KINERJA
      if (isset($_POST['m'])) {
         if ($mode == 1) {
            $date = $_POST['Y'] . "-" . $_POST['m'];
            $dataTanggal = array('bulan' => $_POST['m'], 'tahun' => $_POST['Y']);
         } else {
            $date = $_POST['Y'] . "-" . $_POST['m'] . "-" . $_POST['d'];
            $dataTanggal = array('tanggal' => $_POST['d'], 'bulan' => $_POST['m'], 'tahun' => $_POST['Y']);
         }
      } else {
         if ($mode == 1) {
            $date = date('Y-m');
         } else {
            $date = date('Y-m-d');
         }
      }

      //OPERASI
      $join_where = "operasi.id_penjualan = penjualan.id_penjualan";
      $where = "penjualan.bin = 0 AND operasi.insertTime LIKE '" . $date . "%'";
      $data_main = $this->db(1)->innerJoin1_where('operasi', 'sale_' . $this->id_cabang, $join_where, $where);

      //PENERIMAAN
      $cols = "id_user, id_cabang, COUNT(id_user) as terima";
      $where = "insertTime LIKE '" . $date . "%' GROUP BY id_user, id_cabang";
      $data_terima = $this->db(1)->get_cols_where($this->table, $cols, $where, 1);

      //PENGAMBILAN
      $cols = "id_user_ambil, id_cabang, COUNT(id_user_ambil) as kembali";
      $where = "tgl_ambil LIKE '" . $date . "%' GROUP BY id_user_ambil, id_cabang";
      $data_kembali = $this->db(0)->get_cols_where($this->table, $cols, $where, 1);

      $this->view('layout', ['data_operasi' => $data_operasi]);
      $this->view('kinerja/' . $view, [
         'data_main' => $data_main,
         'operasi' => $operasi,
         'dataTanggal' => $dataTanggal,
         'dTerima' => $data_terima,
         'dKembali' => $data_kembali,
      ]);
   }
}
