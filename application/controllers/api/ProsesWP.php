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
    
    public function proses_get()
    {
        header("Access-Control-Allow-Methods: DELETE");
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            if ($is_valid_token['data']->Role === "AnalystOfficer") {
                $idperiode = $this->uri->segment(3);
                $Output = $this->ProsesWPModel->HitungWP($idperiode);
                    $message = [
                        'status' => true,
                        'data' => $Output,
                        'message' => "Success!",
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
            }
        }
    }

}
