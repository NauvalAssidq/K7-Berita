<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!is_user_logged_in()) {
            redirect('auth/login');
        }

        $allowed_roles = array(ROLE_ADMIN, ROLE_WRITER, ROLE_EDITOR);
        if (!in_array($this->session->userdata('role'), $allowed_roles)) {
            show_error('You do not have permission to access this page.', 403);
        }
        $this->load->model(['Category_model','User_model']);
        $this->load->library(['form_validation', 'pagination']);
    }

    public function index() {
        $data['title'] = "Manajemen Kategori";
        $search = $this->input->get('search');
        $data['search'] = $search;
    
        $profile_pic = isset($user->profile_image) ? $user->profile_image : '';

        $config['base_url'] = site_url('categories/index');
        $config['total_rows'] = (int)$this->Category_model->count_categories($search);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'offset';
        $config['first_url'] = site_url('categories/index?offset=0');
    
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
    
        $data['categories'] = $this->Category_model->get_paginated_categories($config['per_page'], $offset, $search);
        $data['pagination'] = $this->pagination->create_links();
    
        $this->render('dashboard/categories/index', $data);
    }
    
    public function create() {
        $data['title'] = "Create Category";
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Category Name', 'required|trim');
            $this->form_validation->set_rules('slug', 'Slug', 'required|trim|is_unique[categories.slug]');
            
            if ($this->form_validation->run() === TRUE) {
                $category_data = [
                    'name'       => $this->input->post('name'),
                    'slug'       => $this->input->post('slug'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                if ($this->Category_model->create_category($category_data)) {
                    $this->session->set_flashdata('message', 'Category created successfully.');
                    redirect('categories');
                } else {
                    $data['error'] = 'Failed to create category. Please try again.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }
        
        $this->render('dashboard/categories/create', $data);
    }

    public function edit($id) {
        $data['title'] = "Edit Category";
        $category = $this->Category_model->get_category($id);
        if (!$category) {
            show_404();
        }
        $data['category'] = $category;
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Category Name', 'required|trim');
            $slug_rule = 'required|trim';
            if ($this->input->post('slug') != $category->slug) {
                $slug_rule .= '|is_unique[categories.slug]';
            }
            $this->form_validation->set_rules('slug', 'Slug', $slug_rule);

            if ($this->form_validation->run() === TRUE) {
                $category_data = [
                    'name'       => $this->input->post('name'),
                    'slug'       => $this->input->post('slug'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                if ($this->Category_model->update_category($id, $category_data)) {
                    $this->session->set_flashdata('message', 'Category updated successfully.');
                    redirect('categories');
                } else {
                    $data['error'] = 'Failed to update category. Please try again.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }
        
        $this->render('dashboard/categories/edit', $data);
    }

    public function delete($id) {
        if ($this->Category_model->delete_category($id)) {
            $this->session->set_flashdata('message', 'Category deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete category.');
        }
        redirect('categories');
    }

    public function bulk_delete() {
        $ids = $this->input->post('category_ids');
        if (!empty($ids)) {
            $this->Category_model->bulk_delete($ids);
            $this->session->set_flashdata('message', 'Selected categories deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'No categories selected.');
        }
        redirect('categories');
    }
}
