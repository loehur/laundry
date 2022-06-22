<?php

class NotifAPI extends Controller
{

   public function __construct()
   {
      $this->table = 'notif';
   }

   public function get($token)
   {

      $data_main = array();
      if (isset($token)) {
         $set = "status = 7";
         $where = "insertTime <= (DATE(NOW()) - INTERVAL 1 DAY) AND status = 1 AND notif_token = '" . $token . "'";
         $this->model('M_DB_1')->update($this->table, $set, $where);

         $where = "notif_token = '" . $token . "' AND status = 1 ORDER BY id_notif ASC";
         $data_main = $this->model('M_DB_1')->get_where($this->table, $where);
      }
      echo json_encode($data_main);
   }

   public function update($update)
   {
      $data = explode("[_EXPLODE_]", $update);
      $id = $data[0];
      $status = $data[1];
      $set = "status = " . $status;
      $where = "id_notif = " . $id;
      $query = $this->model('M_DB_1')->update($this->table, $set, $where);
      if ($query) {
         echo 1;
      } else {
         echo 0;
      }
   }

   public function updateQR($token)
   {
      $auth = $_POST['auth'];
      if (!isset($auth)) {
         echo "Auth Error!";
      }

      $set = "notif_auth = '" . $auth . "', notif_log = 0";
      $where = "notif_token = '" . $token . "'";
      $query = $this->model('M_DB_1')->update('laundry', $set, $where);
      if ($query == 1) {
         echo 1;
      } else {
         echo $query['info'];
      }
   }

   public function updateLogin($token)
   {
      $set = "notif_log = 1";
      $where = "notif_token = '" . $token . "'";
      $query = $this->model('M_DB_1')->update('laundry', $set, $where);
      if ($query) {
         echo 1;
      } else {
         echo $query['info'];
      }
   }
}
