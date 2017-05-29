<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model('Home_model');
        $this->load->model('Api_model');
        $this->load->library('form_validation');

        define('success', 'Success');
        define('error', 'Error');
    }

    public function save_user() {

        $username = trim($this->input->get_post('username'));
        $email = trim($this->input->get_post('email'));
        $password = trim($this->input->get_post('password'));
        $account_type = trim($this->input->get_post('accountType'));
        $token = $this->input->get_post('deviceToken');

        if (empty($username) || empty($email) || empty($password)) {
            $result['status'] = error;
            $result['msg'] = 'Required fields must not be empty';
        } else {
            if ($account_type == 'facebook') {
                $check_fb = $this->Home_model->checkRecord('users', ['email' => $email]);
                if ($check_fb) {
                    $this->Home_model->updateRecord('tokens', ['token' => "$token"], ['user_email' => $email]);

                    $result['status'] = success;
                    $result['msg'] = 'Successfully Saved';

                    header('Content-Type: application/json');
                    echo json_encode($result);
                    exit;
                }
            } else {
                $check = $this->Home_model->checkUserRegister($username, $email);
                if ($check) {
                    $result['status'] = error;
                    $result['msg'] = $check['message'];

                    header('Content-Type: application/json');
                    echo json_encode($result);
                    exit;
                }
            }

            $enc_token = md5($email, $check->user_id);
            $user_data = array(
                'username' => $username,
                'email' => $email,
                'password' => sha1($password),
                'mobile' => $this->input->get_post('mobile'),
                'remember_token' => $enc_token,
                'account_type' => $account_type,
                'created_at' => date('Y-m-d H:i:s')
            );

            $res = $this->Home_model->saveRecord('users', $user_data);

            if ($res) {

                if ($account_type == 'facebook') {
                    $device_id = $this->input->get_post('device_id');

                    if (!empty($token)) {
                        if (empty($device_id)) {
                            $check = $this->Home_model->checkRecord('tokens', ['token' => "$token"]);
                            if ($check) {
                                $this->Home_model->updateRecord('tokens', ['token' => "$token"], ['user_email' => $res->email]);
                            } else {
                                $date = date('Y-m-d H:i:s');
                                $fields = array(
                                    'app_id' => "3f639b9a-f9cd-4c81-8bc9-80ff744ec0c4",
                                    'identifier' => $token,
                                    'language' => "en",
                                    'timezone' => "-28800",
                                    'game_version' => "1.0",
                                    'device_os' => "",
                                    'device_type' => "0",
                                    'device_model' => "iPhone",
                                    'test_type' => 1
                                );

                                $fields = json_encode($fields);

                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players");
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                                curl_setopt($ch, CURLOPT_POST, TRUE);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                                $response = curl_exec($ch);
                                curl_close($ch);

                                $this->Home_model->saveRecord('tokens', ['token' => $token, 'player_id' => $response->id, 'user_email' => $res->email, 'created_date' => $date]);
                            }
                        } else {
                            $check = $this->Home_model->checkRecord('tokens', ['device_id' => "$device_id"]);
                            if ($check) {
                                $this->Home_model->updateRecord('tokens', ['device_id' => "$device_id"], ['user_email' => $res->email]);
                            } else {
                                $this->Home_model->saveRecord('tokens', ['token' => $token, 'device_id' => $device_id, 'user_email' => $res->email, 'created_date' => $date]);
                            }
                        }
                    }
                }

                if ($account_type != 'facebook') {
                    $msg = 'Dear User, <br><br>
                            Confirm your email address to complete your Fridge account. Its easy &#45 just click on the button below.</p>
                            <a href="' . base_url() . 'verification/?status=' . $enc_token . '">
                                <img src="' . base_url() . 'assets/images/verify.png" width="120" height="40" /></a><br><br>
                            </body>
                            </html>';

                    $this->new_send_email($email, $username, 'Fridge Account Verification', $msg);
                }

                $result['status'] = success;
                $result['msg'] = 'Successfully signed up, Please check your email for verification';
            } else {
                $result['status'] = error;
                $result['msg'] = 'Some error Occurred';
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function update_user() {

        $username = trim($this->input->get_post('username'));
        $email = trim($this->input->get_post('email'));
        $password = trim($this->input->get_post('password'));

        if (empty($username) || empty($email) || empty($password)) {
            $result['status'] = error;
            $result['msg'] = 'Required fields must not be empty';
        } else {
            $check = $this->Home_model->checkRecord('users', array('email' => $email));
            if ($check) {
                $user_data = array(
                    'username' => trim($this->input->get_post('username')),
                    'lastname' => trim($this->input->get_post('lastname')),
                    'password' => sha1($password),
                    'mobile' => $this->input->get_post('mobile')
                );
                $res = $this->Home_model->updateRecord('users', 'email', $email, $user_data);

                if ($res == 1) {
                    $result['status'] = success;
                    $result['msg'] = 'Successfully Updated';
                } else if ($res == 0) {
                    $result['status'] = success;
                    $result['msg'] = 'No Changed';
                } else {
                    $result['status'] = error;
                    $result['msg'] = 'Could not be updated';
                }
            } else {
                $result['status'] = error;
                $result['msg'] = 'Email not found';
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function user_verify() {
        $token = $_GET['status'];

        if (empty($token)) {
            echo 'Invalid Request';
        } else {
            $check = $this->Home_model->checkRecord('users', array('remember_token' => $token));
            if ($check) {
                $this->Home_model->updateRecord('users', ['remember_token' => $token], array('status' => 1));
                $this->load->view('reset_password', ['msg' => 'Account Successfully Verified']);
            } else {
                $this->load->view('reset_password', ['msg' => 'Some Error Occurred']);
            }
        }
    }

    public function user_login() {

        $email = $this->input->get_post('email');
        $password = $this->input->get_post('password');

        if (empty($email) || empty($password)) {
            $result['status'] = error;
            $result['msg'] = 'Required fields must not be empty';
        } else {
            $login_data = array(
                'email' => $email,
                'password' => sha1($password),
                'account_type' => 'normal'
            );
            $res = $this->Home_model->checkRecord('users', $login_data);
            if ($res) {
                if ($res->status == 0) {
                    $result['status'] = 'pending';
                    $result['msg'] = 'Not verified';
                } else {
                    $token = $this->input->get_post('deviceToken');
                    $device_id = $this->input->get_post('device_id');

                    if (!empty($token)) {
                        if (empty($device_id)) {
                            $check = $this->Home_model->checkRecord('tokens', ['token' => "$token"]);
                            if ($check) {
                                $this->Home_model->updateRecord('tokens', ['token' => "$token"], ['user_email' => $res->email]);
                            } else {
                                $date = date('Y-m-d H:i:s');
                                $fields = array(
                                    'app_id' => "3f639b9a-f9cd-4c81-8bc9-80ff744ec0c4",
                                    'identifier' => $token,
                                    'language' => "en",
                                    'timezone' => "-28800",
                                    'game_version' => "1.0",
                                    'device_os' => "",
                                    'device_type' => "0",
                                    'device_model' => "iPhone",
                                    'test_type' => 1
                                );

                                $fields = json_encode($fields);

                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players");
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                                curl_setopt($ch, CURLOPT_POST, TRUE);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                                $response = curl_exec($ch);
                                curl_close($ch);

                                $this->Home_model->saveRecord('tokens', ['token' => $token, 'player_id' => $response->id, 'user_email' => $res->email, 'created_date' => $date]);
                            }
                        } else {
                            $check = $this->Home_model->checkRecord('tokens', ['device_id' => "$device_id"]);
                            if ($check) {
                                $this->Home_model->updateRecord('tokens', ['device_id' => "$device_id"], ['user_email' => $res->email]);
                            } else {
                                $this->Home_model->saveRecord('tokens', ['token' => $token, 'device_id' => $device_id, 'user_email' => $res->email, 'created_date' => $date]);
                            }
                        }
                    }

                    $result['status'] = success;
                    $result['msg'] = 'User Found';
                    $result['profile']['username'] = $res->username;
                    $result['profile']['email'] = $res->email;
                    $result['profile']['mobile'] = $res->mobile;
                }
            } else {
                $result['status'] = error;
                $result['msg'] = 'Invalid Username OR Password';
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function logout() {

        $token = $this->input->get_post('deviceToken');
        if (empty($token)) {
            $result['status'] = success;
            $result['msg'] = 'Successfully logged out';
        } else {
            $res = $this->Home_model->updateRecord('tokens', ['token' => "$token"], ['user_email' => '']);

            if ($res > 0) {
                $result['status'] = success;
                $result['msg'] = 'Successfully logged out';
            } else {
                $result['status'] = error;
                $result['msg'] = 'Some error occurred';
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function forgot_password() {

        $email = trim($this->input->get_post('email'));
        if (empty($email)) {
            $result['status'] = error;
            $result['msg'] = 'User Id required';
        } else {
            $check = $this->Home_model->checkRecord('users', ['email' => $email]);
            if ($check) {
                if ($check->status == 0) {
                    $result['status'] = 'pending';
                    $result['msg'] = 'Not verified';
                } else {
                    $msg = 'Please click the given link to Reset Password<br>
                            <a href="' . base_url() . 'password/reset/?status=' . $check->remember_token . '" targer="blank">
                                <img src="' . base_url() . 'assets/images/reset.png" width="120" height="40" /></a>';

                    $this->new_send_email($email, $check->username, 'Fridge Reset Password', $msg);

                    $result['status'] = success;
                    $result['msg'] = 'Email Sent';
                }
            } else {
                $result['status'] = error;
                $result['msg'] = 'Email not found';
            }
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function reset() {

        $this->form_validation->set_rules('new_pass', 'Password', 'required');
        $this->form_validation->set_rules('token', 'Token', 'required');
        $this->form_validation->set_rules('new_pass_conf', 'Password Confirmation', 'required|matches[new_pass]');

        if (!$this->form_validation->run() == FALSE) {
            $token = $this->input->post('token');
            $password = sha1($this->input->post('new_pass'));
            if ($this->Home_model->resetPassword($password, $token)) {
                $result['status'] = success;
                $result['msg'] = 'Password Updated';
            } else {
                $result['status'] = error;
                $result['msg'] = 'Invalid request';
            }
        }

        echo json_encode($result);
    }

    public function reset_password() {

        if (!isset($_POST['reset_btn'])) {
            $token = $_GET['status'];
            if (empty($token)) {
                $this->load->view('reset_password', ['msg' => 'Invalid Request']);
            } else {
                $check = $this->Home_model->checkRecord('users', ['remember_token' => "$token"]);
                if ($check) {
                    $this->session->set_userdata('token', $token);
                    $this->load->view('reset_password');
                } else {
                    $this->load->view('reset_password', ['msg' => 'Link Expired']);
                }
            }
        } else {
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('reset_password');
            } else {
                if ($this->session->userdata('token') == TRUE) {
                    $data = ['password' => sha1($this->input->post('password')), 'remember_token' => md5(time())];
                    $res = $this->Home_model->updateRecord('users', ['remember_token' => $this->session->userdata('token')], $data);
                    if ($res == 0 || $res == 1) {
                        $this->session->unset_userdata('token');
                        session_destroy();
                        $this->load->view('reset_password', ['msg' => 'Password Successfully Reset']);
                    } else {
                        $this->load->view('reset_password', ['msg' => 'Link Expired']);
                    }
                } else {
                    $this->load->view('reset_password', ['msg' => 'Invalid Request']);
                }
            }
        }
    }
    
    protected function new_send_email($to, $f_name='', $subject, $msg) {

        $headers = 'From: do-not-reply@communityfridge.org' . "\r\n" .
                'Reply-To: do-not-reply@communityfridge.org'."\r\n" .
                'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $msg, $headers);
    }

    protected function send_email($to, $f_name = '', $subject, $msg, $attachment = '') {

        $this->load->library('phpmailer');
        $mail = new PHPMailer(false);
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();

        // local
//        $mail->Host = "ssl://smtp.googlemail.com";
//        $mail->SMTPDebug = 0;
//        $mail->SMTPAuth = true;
//        $mail->Port = 465;
//        $mail->Username = "hamzasynergistics@gmail.com";
//        $mail->Password = "synergistics";
//        $mail->AddReplyTo('do-not-reply@communityfridge.org', '');

        // live                            
        $mail->Host = "localhost";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = "info@communityfridge.org";
        $mail->Password = 'info_123@';
        $mail->Port = "465";
        $mail->AddReplyTo('do-not-reply@communityfridge.org', '');

        $mail->AddAddress($to, $f_name);
        $mail->SetFrom('do-not-reply@communityfridge.org', 'Fridge App');
        $mail->Subject = $subject;
        $body = $msg;

        if (!empty($attachment)) {
            $mail->AddAttachment($attachment);
        }
        $mail->MsgHTML($body);
        $mail->Send();
    }

    public function resend_email() {

        $email = $this->input->get_post('email');
        if (empty($email)) {
            $result['status'] = error;
            $result['msg'] = 'User Id required';
        } else {
            $check = $this->Home_model->checkRecord('users', array('email' => $email));
            if ($check) {
                $msg = 'Dear User, <br><br>
                        Confirm your email address to complete your Sayarti account. Its easy &#45 just click on the button below.</p><br>
                        <a href="http://sayarti.ae/insurance/verification/?status=' . $check->token . '">Click here</a><br>
                        </body>
                        </html>';

                $this->new_send_email($email, $check->username, 'Sayarti Account Verification', $msg);

                $result['status'] = success;
                $result['msg'] = 'Please check your email';
            } else {
                $result['status'] = error;
                $result['msg'] = 'Email does not exist';
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function save_item() {
        
        $this->form_validation->set_rules('condition', 'Condition', 'required');
        $this->form_validation->set_rules('services', 'Services', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('lat', 'Latitude', 'required');
        $this->form_validation->set_rules('lng', 'Longitude', 'required');
        $this->form_validation->set_rules('area', 'Area', 'required');
        $this->form_validation->set_rules('streetAddress', 'Street Address', 'required');
        $this->form_validation->set_rules('accessTime', 'Access Time', 'required');
        $this->form_validation->set_rules('preferredFillTime', 'Preferred Fill Time', 'required');
        $this->form_validation->set_rules('userId', 'User Id', 'required');

        if ($this->form_validation->run() == FALSE) {

            $a = str_replace('<p>', '', validation_errors());
            $a = explode('</p>', $a);
            $b = array_pop($a);

            $result['status'] = error;
            $result['msg'] = 'Required field must not be empty';
            $result['error'] = $a;
        } else {
            $user_email = $this->input->get_post('userId');
            $fridge_id = $this->input->get_post('fridgeId');

            $check = $this->Home_model->checkRecord('users', array('email' => $user_email));
            if ($check) {
                $lat = $this->input->post('lat');
                $lng = $this->input->post('lng');
                $country = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=true"));

                $services = implode(',', $this->input->post('services'));
                $point = "GeomFromText('POINT($lat $lng)')";

                $item_data = $this->db->set(array(
                    'condition' => $this->input->post('condition'),
                    'services' => $services,
                    'status' => $this->input->post('status'),
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'country' => $country->results[count($country->results) - 1]->formatted_address,
                    'area' => $this->input->post('area'),
                    'address' => $this->input->post('streetAddress'),
                    'access_time' => $this->input->post('accessTime'),
                    'preferred_filling_time' => $this->input->post('preferredFillTime'),
                    'user_id' => $check->user_id
                ), true);
//                $item_data = $this->db->set(array('point' => 'Point(34.5 55.5)'), true);
                
//                echo'<pre>'; print_r($item_data); die;

                if ($fridge_id != '-1') {
                    $res = $this->Home_model->updateRecord('items', ['item_id' => $fridge_id], $item_data);
                    $this->Api_model->deleteItem($fridge_id);
                } else {
                    $item_data = array('created_at' => date('Y-m-d H:i:s'));
                    $res = $this->Home_model->saveRecord('items', $item_data);
                    
                    $this->Home_model->updateGEom($point, $res);
                }

                if ($res > 0) {

                    $res = ($fridge_id != '-1') ? $fridge_id : $res;

                    for ($i = 0; $i < 10; $i++) {
                        if (!empty($_FILES['image_' . $i]['name'])) {
                            $ext = pathinfo($_FILES['image_' . $i]['name'], PATHINFO_EXTENSION);
                            $t = uniqid() . '.' . $ext;
                            $path = 'assets/uploads/' . $t;
                            move_uploaded_file($_FILES['image_' . $i]['tmp_name'], $path);

                            $img_url = base_url() . $path;
                            $image = $this->Home_model->saveRecord('item_images', ['image' => $img_url, 'item_id' => $res]);
                            if ($image) {
                                $img_res[] = "Image $i uploaded";
                            } else {
                                $img_res[] = "Image $i could not be uploaded";
                            }
                        } else {
                            $i = 11;
                        }
                    }

                    $result['status'] = success;
                    $result['msg'] = 'Successfully Saved';
                    $result['images'] = $img_res;

//                    $msg = 'Dear User,<br>Your have requested a quote successfully.';
//                    $this->send_email($check->email, '', 'Sayarti Quote', $msg);
                } else {
                    $result['status'] = error;
                    $result['msg'] = 'Could not be Saved';
                }
            } else {
                $result['status'] = error;
                $result['msg'] = 'Invalid User Id';
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function save_fridge_refill() {

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $result['status'] = error;
            $result['msg'] = 'Invalid Request Method';
        } else {
            $this->form_validation->set_rules('fridgeId', 'Fridge Id', 'trim|required|integer');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
//            if (empty($_FILES['refillImage']['name'])) {
//                $this->form_validation->set_rules('refillImage', 'Image', 'required');
//            }

            if ($this->form_validation->run() == FALSE) {

                $a = str_replace('<p>', '', validation_errors());
                $a = explode('</p>', $a);
                $b = array_pop($a);

                $result['status'] = error;
                $result['msg'] = 'Required fields must not be empty';
                $result['error'] = $a;
            } else {
                if ($_FILES['refillImage']['name'] != '') {
                    $ext = pathinfo($_FILES['refillImage']['name'], PATHINFO_EXTENSION);
                    $t = uniqid() . '.' . $ext;
                    $path = 'assets/uploads/refills/' . $t;
                    move_uploaded_file($_FILES['refillImage']['tmp_name'], $path);

                    $img_url = base_url() . $path;
                } else {
                    $img_url = '';
                }

                $refill_data = [
                    'item_id' => $this->input->post('fridgeId'),
                    'image' => $img_url,
                    'english_description' => $this->input->post('description'),
                    'french_description' => '',
                    'arabic_description' => '',
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $res = $this->Home_model->saveRecord('fridge_refills', $refill_data);

                if ($res) {
                    $this->Home_model->updateRecord('items', ['item_id' => $this->input->post('fridgeId')], ['status' => 'Full']);
                    $result['status'] = success;
                    $result['msg'] = 'Successfully Saved';
                } else {
                    $result['status'] = error;
                    $result['msg'] = 'Could not be Saved';
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    function get_items() {

        $user_email = $this->input->get_post('userId');
        if (!empty($user_email)) {
            $check = $this->Home_model->checkRecord('users', array('email' => $user_email));
            if (!$check) {
                $result['status'] = error;
                $result['msg'] = 'Invalid User Id';

                header('Content-Type: application/json');
                echo json_encode($result);
                exit;
            }
        }

        $items = $this->Api_model->getUserItems($check->user_id);
        if (count($items) == 0) {
            $result['status'] = success;
            $result['msg'] = 'No record found';
        } else {
            $result['status'] = success;
            $result['msg'] = 'Items List';

            $index = 0;
            $start = 0;
            for ($i = $start; $i < count($items); $i++) {

                $result['items'][$index]['trackId'] = $index + 1;
                $result['items'][$index]['fridgeId'] = $items[$i]['item_id'];
                $result['items'][$index]['condition'] = trim($items[$i]['condition']);
                $result['items'][$index]['status'] = trim($items[$i]['status']);
                $result['items'][$index]['lat'] = $items[$i]['latitude'];
                $result['items'][$index]['lng'] = $items[$i]['longitude'];
                $result['items'][$index]['area'] = trim($items[$i]['area']);
                $result['items'][$index]['streetAddress'] = trim($items[$i]['address']);
                $result['items'][$index]['accessTime'] = trim($items[$i]['access_time']);
                $result['items'][$index]['preferredFillTime'] = trim($items[$i]['preferred_filling_time']);
                $result['items'][$index]['services'] = explode(',', $items[$i]['services']);
                $result['items'][$index]['isActive'] = $items[$i]['is_active'];

                for ($j = $i; $j < count($items); $j++) {
                    if ($items[$j]['img_item_id'] == $items[$i]['item_id']) {
                        $result['items'][$index]['images'][] = $items[$j]['image'];
                        $i = $j;
                    } else {
                        $j = count($items);
                    }
                }
                $index++;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    function delete_item() {

        $item_id = $this->input->get_post('fridgeId');
        $user_email = $this->input->get_post('userId');

        if (empty($user_email) && empty($item_id)) {
            $result['status'] = error;
            $result['msg'] = 'Fridge Id and User Id Required';
        } else if (empty($user_email)) {
            $result['status'] = error;
            $result['msg'] = 'User Id Required';
        } else if (empty($item_id)) {
            $result['status'] = error;
            $result['msg'] = 'Fridge Id Required';
        } else {
            $check_user = $this->Home_model->checkRecord('users', ['email' => "$user_email"]);
            if (!$check_user) {
                $result['status'] = error;
                $result['msg'] = 'Invalid User Id';
            } else {
                $check_item = $this->Home_model->checkRecord('items', ['user_id' => $check_user->user_id, 'item_id' => $item_id]);
                if (!$check_item) {
                    $result['status'] = error;
                    $result['msg'] = 'Requested Item does not exists';
                } else {
                    $res = $this->Api_model->deleteItem($item_id, $check_user->user_id);
                    if ($res == 1) {
                        $result['status'] = success;
                        $result['msg'] = 'Successfully Deleted';
                    } else {
                        $result['status'] = error;
                        $result['msg'] = 'Could not be Deleted';
                    }
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    function fridge_status() {

        $item_id = $this->input->get_post('fridgeId');
        $user_email = $this->input->get_post('userId');
        $is_active = $this->input->get_post('isActive');
        $active_status = ($is_active == 0) ? 'Inactive' : 'Active';

        if (empty($user_email) && empty($item_id)) {
            $result['status'] = error;
            $result['msg'] = 'Fridge Id, User Id and Fridge status Required';
        } else if (empty($user_email)) {
            $result['status'] = error;
            $result['msg'] = 'User Id Required';
        } else if (empty($item_id)) {
            $result['status'] = error;
            $result['msg'] = 'Fridge Id Required';
        } else {
            $check_user = $this->Home_model->checkRecord('users', ['email' => "$user_email"]);
            if (!$check_user) {
                $result['status'] = error;
                $result['msg'] = 'Invalid User Id';
            } else {
                $check_item = $this->Home_model->checkRecord('items', ['user_id' => $check_user->user_id, 'item_id' => $item_id]);
                if (!$check_item) {
                    $result['status'] = error;
                    $result['msg'] = 'Requested Item does not exists';
                } else {
                    $res = $this->Home_model->updateRecord('items', 
                            ['item_id' => $item_id, 'user_id' => $check_user->user_id], 
                            ['condition' => $active_status]
                    );
                    if ($res == 1) {
                        $result['status'] = success;
                        $result['msg'] = "Successfully $active_status";
                    } else {
                        $result['status'] = error;
                        $result['msg'] = "Could not be changed";
                    }
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function report() {

        $this->form_validation->set_rules('fridgeId', 'Fridge Id', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() == FALSE) {

            $a = str_replace('<p>', '', validation_errors());
            $a = explode('</p>', $a);
            $b = array_pop($a);

            $result['status'] = error;
            $result['msg'] = 'Required field must not be empty';
            $result['error'] = $a;
        } else {
            $type = $this->input->post('type');
            $message = $this->input->post('message');
            $fridge_id = $this->input->post('fridgeId');

            $check = $this->Home_model->getUserByFridgeId($fridge_id);
            if ($check) {
                if (strpos($type, 'eport') !== false) {
                    $body = "Dear User,<br/><br/>Your listed fridge is &#8220;$message&#8221;. Kindly check.<br/><br/><br/>
                            Regards,<br/>Community Fridge";
                }
                else{
                    $body = "Dear User,<br/><br/>Someone wrote regarding your fridge.<br/>
                            &#8220;$message&#8221;<br/><br/><br/>
                            Regards,<br/>Community Fridge";
                }
                
                $this->new_send_email($check->email, '', ucwords($type), $body);

                $result['status'] = success;
                $result['msg'] = 'Email Sent';
            } else {
                $result['status'] = error;
                $result['msg'] = 'Could not be sent';
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function request_refill() {

        $fridge_id = $this->input->post('fridgeId');
        if (empty($fridge_id)) {
            $result['status'] = error;
            $result['msg'] = 'Fridge Id required';
        } else {
            $res = $this->Home_model->updateRecord('items', ['item_id' => $this->input->post('fridgeId')], ['status' => 'Needs Refill']);
            if ($res == 0) {
                $result['status'] = success;
                $result['msg'] = 'No Change';
            }
            if ($res == 1) {
                $result['status'] = success;
                $result['msg'] = 'Successfully Updated';
            } else {
                $result['status'] = error;
                $result['msg'] = 'Could not be Updated';
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function get_activities() {

        $date = $this->input->get_post('date');
        if (empty($date)) {
            $result['status'] = error;
            $result['msg'] = 'Date required';
        } else {
            $activities = $this->Api_model->getAllActivities($date);

            if (count($activities)) {
                $result['status'] = success;
                $result['msg'] = 'User Actitvities';
                $result['data'] = $activities;

                foreach ($activities as $key => $act) {

                    $items = $this->Api_model->getItemsById($act['fridge_id']);
                    if (count($items) > 0) {
                        $index = 0;
                        $start = 0;
                        for ($i = $start; $i < count($items); $i++) {

                            $result['data'][$key]['fridge_detail'][$index]['fridgeId'] = $items[$i]['item_id'];
                            $result['data'][$key]['fridge_detail'][$index]['condition'] = trim($items[$i]['condition']);
                            $result['data'][$key]['fridge_detail'][$index]['status'] = trim($items[$i]['status']);
                            $result['data'][$key]['fridge_detail'][$index]['lat'] = $items[$i]['latitude'];
                            $result['data'][$key]['fridge_detail'][$index]['lng'] = $items[$i]['longitude'];
                            $result['data'][$key]['fridge_detail'][$index]['area'] = trim($items[$i]['area']);
                            $result['data'][$key]['fridge_detail'][$index]['streetAddress'] = trim($items[$i]['address']);
                            $result['data'][$key]['fridge_detail'][$index]['accessTime'] = trim($items[$i]['access_time']);
                            $result['data'][$key]['fridge_detail'][$index]['preferredFillTime'] = trim($items[$i]['preferred_filling_time']);

                            $result['data'][$key]['fridge_detail'][$index]['services'] = explode(',', $items[$i]['services']);
                            for ($j = $i; $j < count($items); $j++) {
                                if ($items[$j]['img_item_id'] == $items[$i]['item_id']) {
                                    $result['data'][$key]['fridge_detail'][$index]['images'][] = $items[$j]['image'];
                                    $i = $j;
                                } else {
                                    $j = count($items);
                                }
                            }
                            $index++;
                        }
                    }
                }
            } else {
                $result['status'] = error;
                $result['msg'] = 'No record found';
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function save_token() {

        $token = $this->input->get_post('deviceToken');

        if (empty($token)) {
            $result['status'] = 'Error';
            $result['msg'] = 'Token required';
        } else {
            $fields = array(
                'app_id' => "3f639b9a-f9cd-4c81-8bc9-80ff744ec0c4",
                'identifier' => $token,
                'language' => "en",
                'timezone' => "-28800",
                'game_version' => "1.0",
                'device_os' => "",
                'device_type' => "0",
                'device_model' => "iPhone",
                'test_type' => 2
            );

            $fields = json_encode($fields);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);
            $check = $this->Home_model->checkRecord('tokens', ['token' => $token]);
            if ($check) {
                $this->Home_model->updateRecord('tokens', ['token' => "$token"], ['token' => "$token", 'player_id' => "$response->id"]);

                $result['status'] = 'Success';
                $result['msg'] = 'Successfully Updated';
            } else {
                $date = date('Y-m-d H:i:s');
                $res = $this->Home_model->saveRecord('tokens', ['token' => "$token", 'player_id' => $response->id, 'created_date' => $date]);
                if ($res) {
                    $result['status'] = 'Success';
                    $result['msg'] = 'Successfully Saved';
                } else {
                    $result['status'] = 'Error';
                    $result['msg'] = 'Could not be saved';
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function save_android_token() {

        $token = $this->input->get_post('token');
        $device_id = $this->input->get_post('device_id');

        if (empty($token) && empty($device_id)) {
            $result['status'] = 'Error';
            $result['msg'] = 'Token & Deveice Id Required';
        } else if (empty($token)) {
            $result['status'] = 'Error';
            $result['msg'] = 'Token Required';
        } else if (empty($device_id)) {
            $result['status'] = 'Error';
            $result['msg'] = 'Device Id Required';
        } else {
            $token_data = array(
                'token' => $token,
                'device_id' => $device_id,
                'created_date' => date('Y-m-d H:i:s')
            );

            $check = $this->Home_model->checkRecord('tokens', ['device_id' => "$device_id"]);
            if ($check) {
                $this->Home_model->updateRecord('tokens', ['device_id' => "$device_id"], ['token' => $token]);
                $result['status'] = 'Success';
                $result['msg'] = 'Successfully Updated';
            } else {
                $res = $this->Home_model->saveRecord('tokens', $token_data);
                if ($res) {
                    $result['status'] = 'Success';
                    $result['msg'] = 'Successfully Saved';
                } else {
                    $result['status'] = 'Error';
                    $result['msg'] = 'Could not be saved';
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    /*public function test_android_push() {

        $ids[] = 'APA91bFQRtY8SCD4e6j1YeGKX-4GOQrF-2teOUF7TPuVhKmLNkLkMtAEdYnGyiqtaJwp7Opo5mDqANc7-SeuNrw5Cz5gIfl3E3MxEQa4SdvhB-Et_5RmtK7NoI9i99DjuPrGGfjZxh4V';

        define('API_ACCESS_KEY', 'AIzaSyAq208nQaq4tYa5ODrfbyiINwxfKO0qrwg');
        $registrationIds = $ids;

        $msg['notification'] = array
            (
            'title' => $_GET['title'],
            'message' => $_GET['msg']
        );

        $fields = array
            (
            'registration_ids' => $registrationIds,
            'data' => $msg
        );

        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;
    }*/    
    
    
    /*public function test_save_token() {

        $fields = array(
            'app_id' => "3f639b9a-f9cd-4c81-8bc9-80ff744ec0c4",
            'identifier' => '5da8a29523bcd16ae5508cf58cb3b3f4e6ee459d4588503e4fe22e2e36565624',
            'language' => "en",
            'timezone' => "-28800",
            'game_version' => "1.0",
            'device_os' => "",
            'device_type' => "0",
            'device_model' => "iPhone",
            'test_type' => 1
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    
    public function test_ios_notification() {

        $noti_title = 'Dear User';
        $msg = 'Welcome to Fridge App';
        
        $title = array(
            "en" => $noti_title
        );
        $content = array(
            "en" => $msg
        );

        $fields = array(
            'app_id' => "3f639b9a-f9cd-4c81-8bc9-80ff744ec0c4",
            'include_ios_tokens' => ['5da8a29523bcd16ae5508cf58cb3b3f4e6ee459d4588503e4fe22e2e36565624'],
            'contents' => $content,
            'heading' => $title,
            'data' => ['title' => $noti_title, 'body' => $msg],
            'ios_badgeType' => 'SetTo',
            'ios_badgeCount' => 1
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Authorization: Basic ZThlM2Q3YzYtZjAyYy00YWU0LWE3NWEtMWRlZmU4NTE0ZGIw'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }*/
    
    
}
