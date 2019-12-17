<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Tokyo');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class DataPersyaratan extends \Restserver\Libraries\REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        $this->load->model('DataPersyaratan_model', 'DataPersyaratanModel');
    }

    public function insert_post()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
                $_POST = json_decode($this->security->xss_clean($this->input->raw_input_stream));
                $iddebitur = $_GET;
                $Output = $this->DataPersyaratanModel->Insert($_POST, $iddebitur['iddebitur']);
                if ($Output > 0 && !empty($Output)) {
                    $message = [
                        'status' => true,
                        'data' => $Output,
                        'message' => "Berhasil melakukan perubahan!",
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    $message = [
                        'status' => false,
                        'Data' => [],
                        'message' => "Gagal Menyimpan",
                    ];
                    $this->response($message, REST_Controller::HTTP_NO_CONTENT);
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
    public function select_get()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            $iddatapersyaratan = $this->get('iddatapersyaratan');
            $Output = $this->DataPersyaratanModel->Select($iddatapersyaratan);
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
                    'data' => [],
                    'message' => "Tidak Ada Data",
                ];
                $this->response($message, REST_Controller::HTTP_NO_CONTENT);
            }
        }
    }

    public function update_put()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            if ($is_valid_token['data']->Role === "CustomerService") {
                $iddatapersyaratan = $this->uri->segment(4);
                $_PUT = json_decode($this->security->xss_clean($this->input->raw_input_stream));
                $Output = $this->DataPersyaratanModel->Update($iddatapersyaratan, $_PUT);
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

    public function hapus_delete()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            if ($is_valid_token['data']->Role === "CustomerService") {
                $_POST = json_decode($this->security->xss_clean($this->input->raw_input_stream));
                $iddatapersyaratan = $_POST->iddebitur;
                $Output = $this->DataPersyaratanModel->Delete($iddatapersyaratan);
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
