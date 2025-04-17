<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $data = [];

    public function __construct() {
        parent::__construct();

        if ($this->db = $this->load->database('default', TRUE, TRUE)) {
        } else {
            log_message('error', 'Database connection failed.');
        }

        $this->load->helper(array('url', 'form', 'permission_helper', 'view_helper', 'file', 'text', 'date'));
        $this->load->library(array('pagination', 'session', 'user_agent'));

        if (is_user_logged_in()) {
            $this->load->model('User_model');
            $user_id = $this->session->userdata('user_id');
            $user = $this->User_model->get_user($user_id);
            $this->data['user'] = $user;
        }
    }

    /**
     * Render view with a common header and footer.
     *
     * @param string $view The view file (without .php extension)
     * @param array $data Data to be passed to the view
     */
    protected function render($view, $data = []) {
        $data = array_merge($this->data, $data);
        $this->load->view($view, $data);
    }
}
