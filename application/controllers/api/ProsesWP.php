<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Tokyo');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class ProsesWP extends \Restserver\Libraries\REST_Controller
{
    public function __construct($config='rest')
    {
        parent::__construct($config);

        $this->load->model('ProsesWP_model', 'ProsesWPModel');
    }
    
    public function proses_delete()
    {
        header("Access-Control-Allow-Methods: DELETE");
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            if ($is_valid_token['data']->Role === "AnalystOfficer") {
                $_POST = json_decode($this->security->xss_clean($this->input->raw_input_stream));
                $idKriteria = $this->uri->segment(3);
                $Output = $this->KriteriaModel->ProsesWPModel($idKriteria);
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
