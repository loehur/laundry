<?php

class SetDurasi extends Controller
{
   public function __construct()
   {
      $this->session_cek(1);
      $this->data();
      $this->table = 'durasi_client';
   }

   public function i($page)
   {
      $data_main = array();
      $z = array();
      $view = 'setHarga/durasi';
      foreach ($this->dPenjualan as $a) {
         if ($a['id_penjualan_jenis'] == $page) {
            $data_operasi = ['title' => 'Durasi ' . $a['penjualan_jenis']];
            $z = array('set' => 'Durasi ' . $a['penjualan_jenis'], 'page' => $page);
         }
      }
      $where = "id_penjualan_jenis = " . $page;
      $data_main = $this->db(0)->get_where($this->table, $where);
      $where = 'id_penjualan_jenis = ' . $page;
      $d2 = $this->db(0)->get_where('item_group', $where);
      $this->view('layout', ['data_operasi' => $data_operasi]);
      $this->view($view, ['data_main' => $data_main, 'd2' => $d2, 'z' => $z]);
   }

   public function insert($page)
   {
      $cols = 'id_item_group, id_penjualan_jenis, id_durasi, hari, jam';
      $vals = $_POST['f0'] . "," . $page . "," . $_POST['f1'] . "," . $_POST['f2'] . "," . $_POST['f3'];
      $where = 'id_durasi = ' . $_POST['f1'] . ' AND id_penjualan_jenis =' . $page . ' AND id_item_group =' . $_POST['f0'];
      $data_main = $this->db(0)->count_where($this->table, $where);
      if ($data_main < 1) {
         $this->db(0)->insertCols($this->table, $cols, $vals);
      }
   }

   public function updateCell()
   {
      $id = $_POST['id'];
      $value = $_POST['value'];
      $mode = $_POST['mode'];

      if ($mode == 1) {
         $col = "hari";
      } elseif ($mode == 2) {
         $col = "jam";
      }

      $set = $col . " = '" . $value . "'";
      $where = "id_durasi_client  = " . $id;
      $this->db(0)->update($this->table, $set, $where);
   }
}
