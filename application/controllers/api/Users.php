<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Tokyo');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Users extends \Restserver\Libraries\REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        $this->load->model('User_model', 'UserModel');
    }

    public function changepassword_post()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            $_POST = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
            $Output = $this->UserModel->ChangesPassword($_POST, $is_valid_token['data']->id);
            if (!empty($Output) && $Output != false) {
                $message = [
                    'status' => true,
                    'message' => "Changes Password Success",
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'status' => false,
                    'message' => "Password Lama Anda Tidak Sesuai",
                ];
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $message = [
                'status' => false,
                'message' => "Anda tidak memiliki Akses",
            ];
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function changeuser_post()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            $_POST = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
            $Output = $this->UserModel->ChangesUsername($_POST, $is_valid_token['data']->id);
            if (!empty($Output) && $Output != false) {
                $message = [
                    'status' => true,
                    'message' => "Changes Username Success",
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'status' => false,
                    'message' => "Gagal, Hubungi Admin",
                ];
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $message = [
                'status' => false,
                'message' => "Anda tidak memiliki Akses",
            ];
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     *  Add New User
     * @method : POST
     */
    public function register_post()
    {
        header("Access-Control-Allow-Origin: *");
        $_POST = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
        $InsertData = [
            'Username' => $this->input->post('Username'),
            'Password' => md5($this->input->post('Password')),
            'Email' => $this->input->post('Email'),
            'Nama' => $this->input->post('Nama'),
            'Alamat' => $this->input->post('Alamat'),
            'Kontak' => $this->input->post('Kontak'),
        ];
        
        $cek = $this->UserModel->CekData();
        if ($cek > 0) {
            $this->load->library('Authorization_Token');
            $is_valid_token = $this->authorization_token->validateToken();
            if ($is_valid_token['status'] === true) {
                
                $Output = $this->UserModel->insert_user($InsertData);
                if ($Output > 0 && !empty($Output)) {
                    $Role = $this->input->post('Role');
                    $InsertRole = [
                        'IdUser' => $Output,
                        'Idrole' => $Role['Idrole']
                    ];
                    $inputRole= $this->UserModel->insert_role($InsertRole);
                    $message = [
                        'status' => true,
                        'Data' => $Output,
                        'message' => "Registrasi Berhasil",
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    $message = [
                        'status' => false,
                        'Data' => null,
                        'message' => "Registrasi Gagal",
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } else {
            
            $Output = $this->UserModel->insert_user($InsertData);
            
            if ($Output > 0 && !empty($Output)) {
                $InsertRole = [
                    'IdUser' => $Output,
                    'Idrole' => 1
                ];
                $inputRole= $this->UserModel->insert_role($InsertRole);
                
                $message = [
                    'status' => true,
                    'Data' => $Output,
                    'message' => "Registrasi Berhasil",
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'status' => false,
                    'Data' => null,
                    'message' => "Registrasi Gagal",
                ];
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }

    }

    public function login_post()
    {

        // $_POST = $this->security->xss_clean($_POST);
        $_POST = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
        $this->form_validation->set_rules('Username', 'Username', 'trim|required');
        $this->form_validation->set_rules('Password', 'trim|required|max_length[100]');
        if ($this->form_validation->run() == false) {
            $message = array(
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors(),
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $Output = $this->UserModel->user_login($this->input->post('Username'), $this->input->post('Password'));
            if (!empty($Output && $Output != false)) {
                $this->load->library('Authorization_Token');

                $token_data['id'] = $Output[0]->IdUser;
                $token_data['Username'] = $Output[0]->Username;
                $token_data['Email'] = $Output[0]->Email;
                $token_data['Nama'] = $Output[0]->Nama;
                $token_data['Role'] = $Output[0]->Role;
                $token_data['time'] = time();

                $UserToken = $this->authorization_token->generateToken($token_data);
                // print_r($this->authorization_token->userData());
                // exit;

                $return_data = [
                    'IdUser' => $Output[0]->IdUser,
                    'Username' => $Output[0]->Username,
                    'Email' => $Output[0]->Email,
                    'Nama' => $Output[0]->Nama,
                    'Role' => $Output[0]->Role,
                    'Token' => $UserToken,
                ];

                $message = [
                    'status' => true,
                    'data' => $return_data,
                    'message' => "Login Berhasil",
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'status' => false,
                    'message' => "Periksa Username dan Password",
                ];
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    // /**
    //  *  Fetch All User Data
    //  * @method : GET
    //  */
    // public function fetch_all_users_get()
    // {
    //     header("Access-Control-Allow-Origin: *");
    //     $data = $this->User_model->fetch_all_users();
    //     $this->response($data);
    // }
}
