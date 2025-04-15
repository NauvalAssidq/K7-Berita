<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function login() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data['errors'] = validation_errors();
                $this->load->view('auth/login', $data);
            } else {
                $username = trim($this->input->post('username', TRUE));
                $password = $this->input->post('password');
                
                $user = $this->User_model->login($username, $password);
                if ($user) {
                    $this->session->set_userdata([
                        'logged_in' => TRUE,
                        'user_id'   => $user->id,
                        'username'  => $user->username,
                        'role'      => $user->role,
                        'full_name' => $user->full_name,
                        
                    ]);
                    redirect('dashboard'); 
                } else {
                    $data['error'] = 'Username atau password tidak valid.';
                    $this->load->view('auth/login', $data);
                }
            }
        } else {
            $this->load->view('auth/login');
        }
    }

    public function username_check($str) {
        $this->db->where('username', $str);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('username_check', 'Bidang Username harus berisi nilai yang unik.');
            return FALSE;
        }
        return TRUE;
    }
    
    public function email_check($str) {
        $this->db->where('email', $str);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('email_check', 'Bidang Email harus berisi nilai yang unik.');
            return FALSE;
        }
        return TRUE;
    }
    
    public function register() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
            $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|max_length[100]');
            
            if ($this->form_validation->run() == FALSE) {
                $data['errors'] = validation_errors();
                $this->load->view('auth/register', $data);
            } else {
                $user_data = [
                    'username'  => trim($this->input->post('username', TRUE)),
                    'email'     => trim($this->input->post('email', TRUE)),
                    'password'  => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'role'      => ROLE_USER,
                    'full_name' => trim($this->input->post('full_name', TRUE)),
                ];
                $insert_id = $this->User_model->register($user_data);
                if ($insert_id) {
                    $this->session->set_flashdata('message', 'Registrasi berhasil. Silakan masuk.');
                    redirect('auth/login');
                } else {
                    $data['error'] = 'Registrasi gagal. Silakan coba lagi.';
                    $this->load->view('auth/register', $data);
                }
            }
        } else {
            $this->load->view('auth/register');
        }
    }
    
    public function logout() {
        $this->session->sess_destroy();
        $referrer = $this->agent->referrer();
        if (!$referrer || strpos($referrer, 'dashboard') !== false) {
            redirect('main');
        } else {
            redirect($referrer);
        }
    }
}
?>
