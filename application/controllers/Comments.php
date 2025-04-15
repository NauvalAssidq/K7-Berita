<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Comments_model');
        $this->load->model('News_model');

        if (!is_user_logged_in()) {
            redirect('auth/login');
        }

        $allowed_roles = array(ROLE_ADMIN, ROLE_WRITER, ROLE_EDITOR);
        if (!in_array($this->session->userdata('role'), $allowed_roles)) {
            show_error('You do not have permission to access this page.', 403);
        }
    }

    public function index() {
        $data['title'] = "Manajemen Komentar";
        $data['comments'] = $this->Comments_model->get_pending_comments();

        $this->render('dashboard/comments/index', $data);
    }

    public function approve($id) {
        if ($this->Comments_model->approve_comment($id)) {
            $this->session->set_flashdata('success', 'Comment approved successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to approve comment.');
        }
        redirect('comments');
    }

    public function reject($id) {
        if ($this->Comments_model->reject_comment($id)) {
            $this->session->set_flashdata('success', 'Comment rejected successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to reject comment.');
        }
        redirect('comments');
    }

    public function delete($id) {
        if ($this->Comments_model->delete_comment($id)) {
            $this->session->set_flashdata('success', 'Comment deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete comment.');
        }
        redirect('comments');
    }
}
?>
