<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!is_user_logged_in()) {
            redirect('auth/login');
        }
        $this->load->model('User_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_user($user_id);

        if (!$user) {
            $data['error'] = 'User not found.';
            $this->load->view('dashboard/profile', $data);
            return;
        }

        $data['user'] = $user;
        
        $profile_pic = isset($user->profile_image) ? $user->profile_image : '';

        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            if ($this->input->post('current_password') || $this->input->post('new_password') || $this->input->post('confirm_password')) {
                $this->form_validation->set_rules('current_password', 'Current Password', 'required');
                $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
            }

            if ($this->form_validation->run() === FALSE) {
                $data['error'] = validation_errors();
            } else {
                if (!empty($_FILES['profile_image']['name'])) {
                    $config['upload_path']   = './uploads/profile/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size']      = 2048; // 2MB
                    $config['file_name']     = time() . '_' . $_FILES['profile_image']['name'];
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('profile_image')) {
                        $data['error'] = $this->upload->display_errors();
                        $this->load->view('dashboard/profile', $data);
                        return;
                    } else {
                        $upload_data = $this->upload->data();
                        $profile_pic = 'uploads/profile/' . $upload_data['file_name'];
                    }
                }

                $update_data = [
                    'full_name'     => $this->input->post('full_name'),
                    'username'      => $this->input->post('username'),
                    'email'         => $this->input->post('email'),
                    'profile_image' => $profile_pic
                ];

                if ($this->input->post('current_password')) {
                    if (!isset($user->password) || empty($user->password)) {
                        $data['error'] = 'User password is missing.';
                        $this->load->view('dashboard/profile', $data);
                        return;
                    }
                    if (!password_verify($this->input->post('current_password'), $user->password)) {
                        $data['error'] = 'Current password is incorrect.';
                        $this->load->view('dashboard/profile', $data);
                        return;
                    }
                    $update_data['password'] = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);
                }

                if ($this->User_model->update_user($user_id, $update_data)) {
                    $this->session->set_flashdata('message', 'Profile updated successfully.');
                    redirect('profile');
                } else {
                    $data['error'] = 'Profile update failed. Please try again.';
                }
            }
        }

        $this->load->view('dashboard/profile', $data);
    }
}
