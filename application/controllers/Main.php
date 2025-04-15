<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->model('News_votes_model');
        $this->load->model('Comments_model');
        $this->load->model('Category_model');
        $this->load->library('pagination');
        $this->load->helper(array('text', 'content', 'url'));
    }

    public function index() {
        $data['title'] = "Laman Utama";

        $search = $this->input->get('search', true) ?: '';
        $category_id = $this->input->get('category_id', true) ?: '';
        

        $data['search'] = $search;
        $data['category_id'] = $category_id;
        $data['categories'] = $this->Category_model->get_all_categories();

        $config['base_url'] = site_url('main/index?search=' . urlencode($search) . '&category_id=' . urlencode($category_id));
        $config['total_rows'] = (int)$this->News_model->get_news_count($search, $category_id);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'offset';
        $config['first_url'] = site_url('main/index?offset=0&search=' . urlencode($search) . '&category_id=' . urlencode($category_id));
        $config['full_tag_open'] = '<div class="flex justify-center space-x-2 mt-4">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<span class="px-3 py-1 bg-blue-600 text-white rounded">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">';
        $config['num_tag_close'] = '</span>';
        $config['attributes'] = ['class' => ''];

        $this->pagination->initialize($config);
        $offset_param = $this->input->get('offset');
        $offset = ($offset_param === null || !ctype_digit($offset_param)) ? 0 : (int)$offset_param;
        $data['offset'] = $offset;

        $news_list = $this->News_model->get_news($config['per_page'], $offset, $search, $category_id);
        $filtered_news = array_filter($news_list, function($news) {
            return $news->published == 1;
        });
        foreach ($filtered_news as &$news) {
            $votes = $this->News_votes_model->get_votes($news->id);

            $news->upvotes = isset($votes->upvotes) ? (int)$votes->upvotes : 0;
            $news->downvotes = isset($votes->downvotes) ? (int)$votes->downvotes : 0;
            $news->net_votes = $news->upvotes - $news->downvotes;
            $news->comment_count = $this->Comments_model->count_comments($news->id, 'approved');
            $news->thumbnail = extract_first_image($news->content);
        }
        unset($news);
        $data['news_list'] = array_values($filtered_news);

        $featured_news = $this->News_model->get_latest_news(4);
        $featured_filtered = array_filter($featured_news, function($news) {
            return $news->published == 1;
        });
        foreach ($featured_filtered as &$news) {
            $votes = $this->News_votes_model->get_votes($news->id);

            $news->upvotes = isset($votes->upvotes) ? (int)$votes->upvotes : 0;
            $news->downvotes = isset($votes->downvotes) ? (int)$votes->downvotes : 0;
            $news->net_votes = $news->upvotes - $news->downvotes;
            $news->comment_count = $this->Comments_model->count_comments($news->id, 'approved');
            $news->thumbnail = extract_first_image($news->content);
        }
        $data['featured_news'] = array_values($featured_filtered);
        $data['pagination'] = $this->pagination->create_links();

        $this->render('main/index', $data);
        $this->load->view('main/partials/footer', $data);
    }

    private function check_logged_in() {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            $this->session->set_flashdata('error', 'You must be logged in to comment or vote.');
            redirect('auth/login');
        }
        return $user_id;
    }

    public function news($slug) {
        $this->db->select('news.*, users.full_name AS author_name');
        $this->db->from('news');
        $this->db->join('users', 'users.id = news.author_id', 'left');
        $this->db->where('news.slug', $slug);
        $news_query = $this->db->get();
        $news = $news_query->row();
    
        if (!$news) {
            show_404();
            return;
        }
    
        $comments = $this->Comments_model->get_comments_by_news_id($news->id);
        $votes = $this->News_votes_model->get_votes($news->id);
    
        $news->upvotes = isset($votes->upvotes) ? (int)$votes->upvotes : 0;
        $news->downvotes = isset($votes->downvotes) ? (int)$votes->downvotes : 0;
        $news->net_votes = $news->upvotes - $news->downvotes;
    
        $author = $news->author_name;

        $featured_news = $this->News_model->get_latest_news(4);
        $featured_filtered = array_filter($featured_news, function($n) {
            return $n->published == 1;
        });
        foreach ($featured_filtered as &$n) {
            $v = $this->News_votes_model->get_votes($n->id);
            $n->upvotes = isset($v->upvotes) ? (int)$v->upvotes : 0;
            $n->downvotes = isset($v->downvotes) ? (int)$v->downvotes : 0;
            $n->net_votes = $n->upvotes - $n->downvotes;
            $n->comment_count = $this->Comments_model->count_comments($n->id, 'approved');
            $n->thumbnail = extract_first_image($n->content);
        }
        $featured_filtered = array_values($featured_filtered);
    
        $data = [
            'title'    => $news->title,
            'news'     => $news,
            'comments' => $comments,
            'votes'    => $votes,
            'author'   => $author,
            'featured_news' => $featured_filtered
        ];
    
        $this->render('main/news_details', $data);
        $this->load->view('main/partials/footer', $data);
    } 

    public function add_comment($news_id) {
        $user_id = $this->check_logged_in();
    
        $full_name = $this->session->userdata('full_name');
        $email = $this->session->userdata('email');
        $comment = $this->input->post('comment');
        
        $data = [
            'news_id' => $news_id,
            'user_id' => $user_id,
            'comment' => $comment,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
    
        if ($this->Comments_model->create_comment($data)) {
            redirect('main/news/' . $this->get_news_slug_by_id($news_id));
        } else {
            $this->session->set_flashdata('error', 'Failed to add comment. Please try again.');
            redirect('main/news/' . $this->get_news_slug_by_id($news_id));
        }
    }

    public function vote($news_id, $vote) {
        $user_id = $this->check_logged_in();

        if (!in_array($vote, ['up', 'down'])) {
            $this->session->set_flashdata('error', 'Invalid vote type.');
            redirect('main/news/' . $this->get_news_slug_by_id($news_id));
        }

        if ($this->News_votes_model->cast_vote($news_id, $user_id, $vote)) {
            redirect('main/news/' . $this->get_news_slug_by_id($news_id));
        } else {
            $this->session->set_flashdata('error', 'Failed to vote. Please try again.');
            redirect('main/news/' . $this->get_news_slug_by_id($news_id));
        }
    }

    private function get_news_slug_by_id($news_id) {
        $this->db->where('id', $news_id);
        $query = $this->db->get('news');
        $news = $query->row();
        return $news ? $news->slug : '';
    }

}
?>
