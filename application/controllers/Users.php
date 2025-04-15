<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!is_user_logged_in()) {
            redirect('auth/login');
        }
        if ($this->session->userdata('role') !== ROLE_ADMIN) {
            show_error('You do not have permission to access this page.', 403);
        }
        $this->load->model('User_model');
        $this->load->library(['form_validation', 'pagination']);
    }

    public function index() {
        $data['title'] = "Manajemen User";
        $search = $this->input->get('search');
        $data['search'] = $search;
    
        $config['base_url'] = site_url('users/index');
        $config['total_rows'] = (int)$this->User_model->get_users_count($search);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'offset';
        $config['first_url'] = site_url('users/index?offset=0');

        $config['full_tag_open'] = '<nav class="flex items-center justify-between px-4 sm:px-0"><div class="flex flex-1 justify-between sm:justify-end"><div class="flex space-x-2">';
        $config['full_tag_close'] = '</div></div></nav>';

        $config['first_tag_open'] = '';
        $config['first_tag_close'] = '';
        $config['last_tag_open'] = '';
        $config['last_tag_close'] = '';

        $config['prev_tag_open'] = '<span class="relative inline-flex items-center px-2 py-2 text-gray-400 hover:text-gray-500">';
        $config['prev_tag_close'] = '</span>';
        $config['prev_link'] = '<span class="material-icons-round">chevron_left</span>';

        $config['next_tag_open'] = '<span class="relative inline-flex items-center px-2 py-2 text-gray-400 hover:text-gray-500">';
        $config['next_tag_close'] = '</span>';
        $config['next_link'] = '<span class="material-icons-round">chevron_right</span>';

        $config['cur_tag_open'] = '<span aria-current="page" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-blue-600 border-t-2 border-blue-500">';
        $config['cur_tag_close'] = '</span>';

        $config['num_tag_open'] = '<span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-t-2 border-transparent hover:border-gray-300">';
        $config['num_tag_close'] = '</span>';

        $config['attributes'] = array(
            'class' => 'inline-flex items-center'
        );
    
        $this->pagination->initialize($config);
    
        if ($this->input->get('offset') === NULL) {
            $_GET['offset'] = '0';
        }
        $offset_param = $this->input->get('offset');
        if ($offset_param === NULL || !ctype_digit($offset_param)) {
            $offset = 0;
        } else {
            $offset = (int)$offset_param;
        }
        $data['offset'] = $offset;
    
        $data['users'] = $this->User_model->get_users($config['per_page'], $offset, $search);
        $data['pagination'] = $this->pagination->create_links();
    
        $this->render('dashboard/users/index', $data);
    }
    
    public function edit($user_id) {
        $data['title'] = "Edit User Role";
        $user = $this->User_model->get_user($user_id);
        if (!$user) {
            show_404();
        }
    
        $data['roles'] = ['Admin', 'Editor', 'Writer', 'User'];
        $data['user_to_edit'] = $user; // This is the key change - consistent naming
    
        if ($this->input->post()) {
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|max_length[100]');
    
            if ($this->form_validation->run() === TRUE) {
                $new_role = $this->input->post('role');
                $full_name = $this->input->post('full_name');
    
                $update_data = [
                    'role' => $new_role,
                    'full_name' => !empty($full_name) ? $full_name : NULL
                ];
    
                if ($this->User_model->update_user($user_id, $update_data)) {
                    $this->session->set_flashdata('message', 'User details updated successfully.');
                    redirect('users');
                } else {
                    $data['error'] = 'Failed to update user details. Please try again.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }
    
        $this->render('dashboard/users/edit', $data);
    }

    public function user_statistics() {
        $this->load->model('User_model');
        
        $data['total_users'] = $this->User_model->get_total_users();
        $data['user_growth'] = $this->User_model->get_daily_user_growth(7); // Last 7 days
        
        $this->load->view('dashboard/user_statistics', $data);
    }
    

    public function delete($user_id) {
        $user = $this->User_model->get_user($user_id);
        if (!$user) {
            show_404();
        }
        if ($this->User_model->delete_user($user_id)) {
            $this->session->set_flashdata('message', 'User deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user. Please try again.');
        }
        redirect('users');
    }

    public function bulk_delete() {
        $ids = $this->input->post('selected_users');
        if (!empty($ids)) {
            $this->User_model->bulk_delete_users($ids);
            $this->session->set_flashdata('message', 'Selected users have been deleted.');
        } else {
            $this->session->set_flashdata('error', 'No users selected.');
        }
        redirect('users');
    }
}
?>    
