<?php

class PackLabel extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->data();
      $this->table = 'penjualan';
      $this->viewData = __CLASS__ . '/content';
   }

   public function index($cetak = [])
   {
      $data_operasi = ['title' => __CLASS__];
      $this->view('layout', ['data_operasi' => $data_operasi]);

      $table = "pelanggan";
      $where = $this->wLaundry;
      $order = 'id_pelanggan DESC';
      $data['cetak'] = $cetak;
      $data['all'] = $this->model('M_DB_1')->get_where_order($table, $where, $order);
      $this->view($this->viewData, $data);
   }

   function cetak()
   {
      $post = explode("_EXP_", $_POST['pelanggan']);
      $data['pelanggan'] = $post[0];
      $data['cabang'] = $post[1];
      $data['jumlah'] = $_POST['jumlah'];
      $this->index($data);
   }
}
