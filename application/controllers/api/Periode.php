<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Tokyo');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Periode extends \Restserver\Libraries\REST_Controller
{
    public function __construct($config='rest')
    {
        parent::__construct($config);

        $this->load->model('Periode_model', 'PeriodeModel');
    }
    public function insert_post()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        header("Access-Control-Allow-Methods: POST");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
            exit();
        }else{
            $_POST = json_decode($this->security->xss_clean($this->input->raw_input_stream));
            $this->load->library('Authorization_Token');
            $is_valid_token = $this->authorization_token->validateToken();
            if ($is_valid_token['status'] === true) {
                if ($is_valid_token['data']->Role === "AnalystOfficer") {
                    $Output = $this->PeriodeModel->Insert($_POST);
                    if ($Output > 0 && !empty($Output)) {
                        $message = [
                            'status' => true,
                            'data' => $Output,
                            'message' => "Success!",
                        ];
                        $this->response($message, REST_Controller::HTTP_OK);
                    } else {
                        $message = [
                            'status' => false,
                            'Data' => null,
                            'message' => "Gagal Menyimpan",
                        ];
                        $this->response($message, REST_Controller::HTTP_NO_CONTENT);
                    }
                } else {
                    $message = [
                        'status' => false,
                        'Data' => null,
                        'message' => "Anda tidak memiliki akses",
                    ];
                    $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
                }
            } else {
                $message = [
                    'status' => false,
                    'Data' => null,
                    'message' => "Session Habis",
                ];
                $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
        
    }
    public function update_put()
    {
        header("Access-Control-Allow-Methods: PUT");
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            if ($is_valid_token['data']->Role === "KomiteKredit") {
                $idKriteria = $this->uri->segment(3);
                $_PUT = json_decode($this->security->xss_clean($this->input->raw_input_stream));
                $Output = $this->PeriodeModel->Update($idKriteria, $_PUT);
                if ($Output == true) {
                    $message = [
                        'status' => true,
                        'message' => "Success!",
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    $message = [
                        'status' => false,
                        'message' => "Tidak Ada Data",
                    ];
                    $this->response($message, REST_Controller::HTTP_NO_CONTENT);
                }
            }
        }
    }
    public function select_get()
    {
        header("Access-Control-Allow-Methods: GET");
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            $Output = $this->PeriodeModel->Select();
            if (!empty($Output)) {
                $message = [
                    'status' => true,
                    'data' => $Output,
                    'message' => "Success!",
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'status' => false,
                    'data' => null,
                    'message' => "Tidak Ada Data",
                ];
                $this->response($message, REST_Controller::HTTP_NO_CONTENT);
            }

        }else{
            $message = [
                'status' => false,
                'Data' => null,
                'message' => "Session Habis",
            ];
            $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function hapus_delete()
    {
        header("Access-Control-Allow-Methods: DELETE");
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            if ($is_valid_token['data']->Role === "KomiteKredit") {
                $_POST = json_decode($this->security->xss_clean($this->input->raw_input_stream));
                $idKriteria = $this->uri->segment(3);
                $Output = $this->PeriodeModel->Delete($idKriteria);
                if ($Output === true) {
                    $message = [
                        'status' => true,
                        'message' => "Success!",
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    $message = [
                        'status' => false,
                        'message' => "Tidak Ada Data",
                    ];
                    $this->response($message, REST_Controller::HTTP_NO_CONTENT);
                }
            }
        }
    }

}
