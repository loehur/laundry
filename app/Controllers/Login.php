<?php
class Login extends Controller
{
   public function index()
   {
      $this->cek_cookie();
      $data = [];
      if (isset($_COOKIE['MDLNUMS'])) {
         $data = unserialize($this->model("Enc")->dec_2($_COOKIE['MDLNUMS']));
      }
      if (isset($_SESSION['login_laundry'])) {
         if ($_SESSION['login_laundry'] == TRUE) {
            header('Location: ' . URL::BASE_URL . "Penjualan");
         } else {
            $this->view('login', $data);
         }
      } else {
         $this->view('login', $data);
      }
   }

   function cek_cookie()
   {
      if (isset($_COOKIE["MDLSESSID"])) {
         $cookie_value = $this->model("Enc")->dec_2($_COOKIE["MDLSESSID"]);

         $user_data = unserialize($cookie_value);
         if (isset($user_data['username']) && isset($user_data['no_user']) && isset($user_data['ip']) && isset($user_data['device'])) {
            $no_user = $user_data['no_user'];
            $username = $this->model("Enc")->username($no_user);

            $device = $_SERVER['HTTP_USER_AGENT'];
            if ($username == $user_data['username'] && $user_data['device'] == $device && $user_data['ip'] == $this->get_client_ip()) {
               $_SESSION['login_laundry'] = TRUE;
               $this->data_user = $user_data;
               $this->parameter();
               $this->save_cookie($no_user);
            }
         }
      }
   }

   function save_cookie()
   {
      $device = $_SERVER['HTTP_USER_AGENT'];
      $this->data_user['device'] = $device;
      $this->data_user['ip'] = $this->get_client_ip();
      $cookie_value = $this->model("Enc")->enc_2(serialize($this->data_user));
      setcookie("MDLSESSID", $cookie_value, time() + 86400, "/");
   }

   function save_nums($usernum)
   {
      //simpan list hp
      if (!isset($_COOKIE['MDLNUMS'])) {
         $mdlnums = [1 => $usernum];
         $nums_value = $this->model("Enc")->enc_2(serialize($mdlnums));
         setcookie("MDLNUMS", $nums_value, time() + (86400 * 7), "/");
      } else {
         $max_saved = 6;
         $nums = $this->model("Enc")->dec_2($_COOKIE['MDLNUMS']);
         $nums = unserialize($nums);
         if (is_array($nums)) {
            $cek = [];
            foreach ($nums as $key => $n) {
               if ($n == $usernum) {
                  array_push($cek, $key);
               }
            }

            $max = max(array_keys($nums));

            if (count($cek) > 0) {
               //hapus diri sendiri dulu

               foreach ($cek as $val) unset($nums[$val]);
               $nums[$max + 1] = $usernum;
            } else {
               if (count($nums) >= $max_saved) {
                  $min = min(array_keys($nums));
                  unset($nums[$min]);
               }
               $nums[$max + 1] = $usernum;
            }
         }
         $nums_value = $this->model("Enc")->enc_2(serialize($nums));
         setcookie("MDLNUMS", $nums_value, time() + (86400 * 7), "/");
      }
   }

   public function cek_login()
   {
      $no_user = $_POST["username"];
      if (strlen($no_user) < 10 || strlen($no_user) > 13) {
         $res = [
            'code' => 0,
            'msg' => "NOMOR WHATSAPP TIDAK VALID"
         ];
         print_r(json_encode($res));
         exit();
      }

      $pin = $_POST["pin"];
      if (strlen($pin) == 0) {
         $res = [
            'code' => 0,
            'msg' => "PIN TIDAK BOLEH KOSONG"
         ];
         print_r(json_encode($res));
         exit();
      }

      $cap = $_POST["cap"];
      if (isset($_SESSION['captcha'])) {
         if ($_SESSION['captcha'] <> $cap) {
            $res = [
               'code' => 10,
               'msg' => "CAPTCHA ERROR, SILAHKAN RELOAD HALAMAN"
            ];
            print_r(json_encode($res));
            exit();
         }
      } else {
         $res = [
            'code' => 10,
            'msg' => "CAPTCHA ERROR, SILAHKAN RELOAD HALAMAN"
         ];
         print_r(json_encode($res));
         exit();
      }


      $username = $this->model("Enc")->username($no_user);
      $otp = $this->model("Enc")->otp($pin);
      $this->data_user = $this->data('User')->pin_today($username, $otp);
      if ($this->data_user) {
         print_r($this->login_ok($username, $no_user));
      } else {
         $cek = $this->data('User')->pin_admin_today($otp);
         if ($cek > 0) {
            $this->data_user = $this->data('User')->get_data_user($username);
            print_r($this->login_ok($username, $no_user));
         } else {
            $_SESSION['captcha'] = "HJFASD7FD89AS7FSDHFD68FHF7GYG7G47G7G7G674GRGVFTGB7G6R74GHG3Q789631765YGHJ7RGEYBF67";
            $res = [
               'code' => 10,
               'msg' => "NOMOR WHATSAPP DAN PIN TIDAK COCOK"
            ];
            print_r(json_encode($res));
         }
      }
   }

   function login_ok($username, $no_user)
   {
      // LAST LOGIN
      $this->data('User')->last_login($username);
      //LOGIN
      $_SESSION['login_laundry'] = TRUE;
      $this->parameter();
      $this->save_cookie();
      $this->save_nums($no_user);
      $res = [
         'code' => 11,
         'msg' => "Login Success"
      ];
      return json_encode($res);
   }

   function req_pin()
   {
      $hp_input = $_POST["hp"];
      $hp = (int) filter_var($hp_input, FILTER_SANITIZE_NUMBER_INT);
      //cek

      if (strlen($hp_input) < 10 || strlen($hp_input) > 13) {
         $res = [
            'code' => 0,
            'msg' => "NOMOR WHATSAPP TIDAK VALID"
         ];
         print_r(json_encode($res));
         exit();
      }

      $username = $this->model("Enc")->username($hp);
      $where = "username = '" . $username . "' AND en = 1";
      $today = date("Ymd");
      $cek = $this->db(0)->get_where_row('user', $where);
      if ($cek) {
         $id_cabang = $cek['id_cabang'];
         if ($cek['otp_active'] == $today) {
            $cek_deliver = $this->data('Notif')->cek_deliver($hp_input, $today, $id_cabang);
            if (isset($cek_deliver['text'])) {
               $no_hp = $cek['no_user'];
               $res_wa = $this->model(URL::WA_API[1])->send($no_hp, $cek_deliver['text'], URL::WA_TOKEN[1]);
               if ($res_wa['status']) {
                  $up = $this->db(1)->update('notif_' . $id_cabang, "id_api_2 =  '" . $res_wa['data']['id'] . "'", "id_notif = " . $cek_deliver['id_notif']);
                  if ($up['errno'] == 0) {
                     $res = [
                        'code' => 1,
                        'msg' => "PERMINTAAN ULANG PIN BERHASIL, AKTIF 1 HARI"
                     ];
                  } else {
                     $res = [
                        'code' => 0,
                        'msg' => $up['error']
                     ];
                  }
               } else {
                  $res = [
                     'code' => 0,
                     'msg' => print_r($res_wa)
                  ];
               }
            } else {
               $res = [
                  'code' => 1,
                  'msg' => "GUNAKAN PIN HARI INI"
               ];
            }
         } else {
            $otp = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
            $otp_enc = $this->model("Enc")->otp($otp);;

            $res_wa = $this->model(URL::WA_API[0])->send($cek['no_user'], $otp, URL::WA_TOKEN[0]);
            if ($res_wa['status'] == true) {
               $do = $this->data('Notif')->insertOTP($res_wa, $today, $hp_input, $otp, $id_cabang);

               if ($do['errno'] == 0) {
                  $set = "otp = '" . $otp_enc . "', otp_active = '" . $today . "'";
                  $up = $this->db(0)->update('user', $set, $where);
                  if ($up['errno'] == 0) {
                     $res = [
                        'code' => 1,
                        'msg' => "PERMINTAAN PIN BERHASIL, AKTIF 1 HARI"
                     ];
                  } else {
                     $res = [
                        'code' => 0,
                        'msg' => $up['error']
                     ];
                  }
               } else {
                  $res = [
                     'code' => 0,
                     'msg' => $do['error']
                  ];
               }
            } else {
               $res = [
                  'code' => 0,
                  'msg' => $res_wa['reason']
               ];
            }
         }
      } else {
         $_SESSION['captcha'] = "HJFASD7FD89AS7FSDHFD68FHF7GYG7G47G7G7G674GRGVFTGB7G6R74GHG3Q789631765YGHJ7RGEYBF67";
         $res = [
            'code' => 10,
            'msg' => "NOMOR WHATSAPP TIDAK TERDAFTAR"
         ];
      }
      print_r(json_encode($res));
   }

   public function logout()
   {
      setcookie("MDLSESSID", 0, time() + 1, "/");
      session_destroy();
      header('Location: ' . URL::BASE_URL . "Penjualan/i");
   }

   public function captcha()
   {
      $captcha_code = rand(0, 9) . rand(0, 9);
      $_SESSION['captcha'] = $captcha_code;

      $target_layer = imagecreatetruecolor(25, 24);
      $captcha_background = imagecolorallocate($target_layer, 255, 255, 255);
      imagefill($target_layer, 0, 0, $captcha_background);
      $captcha_text_color = imagecolorallocate($target_layer, 0, 255, 0);
      imagestring($target_layer, 5, 5, 5, $captcha_code, $captcha_text_color);
      header("Content-type: image/jpeg");
      imagejpeg($target_layer);
   }

   public function log_mode()
   {
      $mode = $_POST['mode'];
      unset($_SESSION['log_mode']);
      $_SESSION['log_mode'] = $mode;
   }

   function get_client_ip()
   {
      $ipaddress = '';
      if (isset($_SERVER['HTTP_CLIENT_IP']))
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
      else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
      else if (isset($_SERVER['HTTP_X_FORWARDED']))
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
      else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
      else if (isset($_SERVER['HTTP_FORWARDED']))
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
      else if (isset($_SERVER['REMOTE_ADDR']))
         $ipaddress = $_SERVER['REMOTE_ADDR'];
      else
         $ipaddress = 'UNKNOWN';
      return $ipaddress;
   }
}
