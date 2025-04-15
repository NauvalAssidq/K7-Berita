<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!is_user_logged_in()) {
            redirect('auth/login');
        }
        if (!in_array($this->session->userdata('role'), [ROLE_ADMIN, ROLE_EDITOR, ROLE_WRITER])) {
            show_error('You do not have permission to access this page.', 403);
        }
        $this->load->model('News_model');
        $this->load->model('Category_model');
        $this->load->library(['form_validation', 'upload']);
    }

    public function index() {
        $data['title'] = "Manajemen Berita";
        $search = $this->input->get('search');
        $data['search'] = $search;
        
        $config['base_url'] = site_url('news/index');
        $config['total_rows'] = (int)$this->News_model->get_news_count($search);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'offset';
        $config['first_url'] = site_url('news/index?offset=0');
        
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
        
        $this->pagination->initialize($config);
        
        $news_list = $this->News_model->get_news($config['per_page'], $offset, $search);
        foreach ($news_list as $news) {
            $news->media = $this->News_model->get_news_media($news->id);
        }
        $data['news_list'] = $news_list;
        $data['pagination'] = $this->pagination->create_links();
        
        $this->render('dashboard/news/index', $data);
    }  

    public function create() {
        $data['title'] = "Create News Article";
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            $this->form_validation->set_rules('content', 'Content', 'required|trim');
            $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
            
            if ($this->form_validation->run() === TRUE) {
                $news_data = [
                    'title'       => $this->input->post('title'),
                    'slug'        => url_title($this->input->post('title'), '-', TRUE),
                    'content'     => $this->input->post('content'),
                    'category_id' => $this->input->post('category_id'),
                    'author_id'   => $this->session->userdata('user_id'),
                    'published'   => $this->input->post('published') ? 1 : 0,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s')
                ];
                
                $news_id = $this->News_model->create_news($news_data);
                
                if ($news_id) {
                    if (isset($_FILES['media_files']) && !empty($_FILES['media_files']['name'][0])) {
                        $files = $_FILES;
                        $fileCount = count($_FILES['media_files']['name']);
                        $uploadErrors = array();
                        
                        $config['upload_path']   = './uploads/news/';
                        $config['allowed_types'] = 'gif|jpg|jpeg|png|mp4';
                        $config['max_size']      = 4096;
                        
                        for ($i = 0; $i < $fileCount; $i++) {
                            if (!empty($files['media_files']['name'][$i])) {
                                $_FILES['media_file']['name']     = $files['media_files']['name'][$i];
                                $_FILES['media_file']['type']     = $files['media_files']['type'][$i];
                                $_FILES['media_file']['tmp_name'] = $files['media_files']['tmp_name'][$i];
                                $_FILES['media_file']['error']    = $files['media_files']['error'][$i];
                                $_FILES['media_file']['size']     = $files['media_files']['size'][$i];
                                
                                $config['file_name'] = time() . '_' . $_FILES['media_file']['name'];
                                $this->upload->initialize($config);
                                
                                if (!$this->upload->do_upload('media_file')) {
                                    $uploadErrors[] = $this->upload->display_errors();
                                } else {
                                    $uploadData = $this->upload->data();
                                    $filePath = 'uploads/news/' . $uploadData['file_name'];
                                    
                                    $media_data = [
                                        'news_id'   => $news_id,
                                        'file_path' => $filePath,
                                        'media_type'=> 'image',
                                        'created_at'=> date('Y-m-d H:i:s')
                                    ];
                                    $this->News_model->add_news_media($media_data);
                                }
                            }
                        }
                        
                        if (!empty($uploadErrors)) {
                            $data['upload_errors'] = implode("<br>", $uploadErrors);
                        }
                    }
                    $this->session->set_flashdata('message', 'News article created successfully.');
                    redirect('news');
                } else {
                    $data['error'] = 'Failed to create news article. Please try again.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }
        
        $data['categories'] = $this->Category_model->get_categories(100, 0);
        $this->render('dashboard/news/create', $data);
    }

    public function edit($id) {
        $data['title'] = "Edit News Article";
        $news_item = $this->News_model->get_news_by_id($id);
        if (!$news_item) {
            show_404();
        }
        $data['news_item'] = $news_item;
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            $this->form_validation->set_rules('content', 'Content', 'required|trim');
            $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
            
            if ($this->form_validation->run() === TRUE) {
                $news_data = [
                    'title'       => $this->input->post('title'),
                    'slug'        => url_title($this->input->post('title'), '-', TRUE),
                    'content'     => $this->input->post('content'),
                    'category_id' => $this->input->post('category_id'),
                    'published'   => $this->input->post('published') ? 1 : 0,
                    'updated_at'  => date('Y-m-d H:i:s')
                ];
                
                if ($this->News_model->update_news($id, $news_data)) {
                    if (isset($_FILES['media_files']) && !empty($_FILES['media_files']['name'][0])) {
                        $files = $_FILES;
                        $fileCount = count($_FILES['media_files']['name']);
                        $uploadErrors = array();
                        
                        $config['upload_path']   = './uploads/news/';
                        $config['allowed_types'] = 'gif|jpg|jpeg|png|mp4';
                        $config['max_size']      = 4096;
                        
                        for ($i = 0; $i < $fileCount; $i++) {
                            if (!empty($files['media_files']['name'][$i])) {
                                $_FILES['media_file']['name']     = $files['media_files']['name'][$i];
                                $_FILES['media_file']['type']     = $files['media_files']['type'][$i];
                                $_FILES['media_file']['tmp_name'] = $files['media_files']['tmp_name'][$i];
                                $_FILES['media_file']['error']    = $files['media_files']['error'][$i];
                                $_FILES['media_file']['size']     = $files['media_files']['size'][$i];
                                
                                $config['file_name'] = time() . '_' . $_FILES['media_file']['name'];
                                $this->upload->initialize($config);
                                
                                if (!$this->upload->do_upload('media_file')) {
                                    $uploadErrors[] = $this->upload->display_errors();
                                } else {
                                    $uploadData = $this->upload->data();
                                    $filePath = 'uploads/news/' . $uploadData['file_name'];
                                    
                                    $media_data = [
                                        'news_id'   => $id,
                                        'file_path' => $filePath,
                                        'media_type'=> 'image',
                                        'created_at'=> date('Y-m-d H:i:s')
                                    ];
                                    $this->News_model->add_news_media($media_data);
                                }
                            }
                        }
                        
                        if (!empty($uploadErrors)) {
                            $data['upload_errors'] = implode('<br>', $uploadErrors);
                        }
                    }
                    $this->session->set_flashdata('message', 'News article updated successfully.');
                    redirect('news');
                } else {
                    $data['error'] = 'Failed to update news article. Please try again.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }
        
        $data['categories'] = $this->Category_model->get_categories(100, 0);
        $this->render('dashboard/news/edit', $data);
    }

    public function delete($id) {
        if ($this->News_model->delete_news($id)) {
            $this->session->set_flashdata('message', 'News article deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete news article.');
        }
        redirect('news');
    }

    public function bulk_delete() {
        $ids = $this->input->post('selected_news');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $this->News_model->delete_news($id);
            }
            $this->session->set_flashdata('message', 'Selected news articles have been deleted.');
        } else {
            $this->session->set_flashdata('error', 'No news articles selected.');
        }
        redirect('news');
    }

    public function upload_image() {
        header('Content-Type: application/json');
        
        $config['upload_path']   = './uploads/news_images/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = 2048; // in KB
        $config['encrypt_name']  = TRUE;
        
        $this->upload->initialize($config);
        
        if (!$this->upload->do_upload('image')) {
            echo json_encode(['error' => $this->upload->display_errors('', '')]);
        } else {
            $uploadData = $this->upload->data();
            $imageURL = base_url('uploads/news_images/' . $uploadData['file_name']);
            echo json_encode(['success' => true, 'url' => $imageURL]);
        }
    }

    public function vote() {
        if (!$this->input->is_ajax_request() || !is_user_logged_in()) {
            show_error('No direct access allowed', 403);
        }
    
        $news_id = $this->input->post('news_id');
        $vote = $this->input->post('vote');
    
        if ($vote === 'up') {
            $result = $this->News_model->increment_upvote($news_id);
        } elseif ($vote === 'down') {
            $result = $this->News_model->increment_downvote($news_id);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid vote type']);
            return;
        }
    
        if ($result) {
            $news = $this->News_model->get_news_by_id($news_id);
            echo json_encode([
                'success' => true,
                'upvotes' => $news->upvotes,
                'downvotes' => $news->downvotes
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Vote failed']);
        }
    }
    
}
?>
