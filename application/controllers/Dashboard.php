<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
        if (!is_user_logged_in()) {
            redirect('auth/login');
        }

        $allowed_roles = array(ROLE_ADMIN, ROLE_WRITER, ROLE_EDITOR);
        if (!in_array($this->session->userdata('role'), $allowed_roles)) {
            redirect('main');
        }
    }

    public function index() {
        $this->load->model('News_model');
        $this->load->model('User_model');

        $total_news = $this->News_model->get_news_count();
        $published_news = $this->News_model->get_news_count_by_status(1);
        $news_snippet = $this->News_model->get_latest_news(5);

        $total_users = $this->User_model->get_total_users();
        $user_growth = $this->User_model->get_daily_user_growth(14);

        $dates = [];
        $counts = [];

        foreach ($user_growth as $growth) {
            $dates[] = $growth->date;
            $counts[] = $growth->count;
        }

        // **Added Section: Retrieve current user's data including profile image**
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_user($user_id);

        $data['title']              = "Dashboard";
        $data['username']           = $this->session->userdata('username');
        $data['role']               = $this->session->userdata('role');
        $data['total_news']         = $total_news;
        $data['published_news']     = $published_news;
        $data['total_users']        = $total_users;
        $data['news_snippet']       = $news_snippet;
        $data['user_growth_labels'] = json_encode($dates);
        $data['user_growth_counts'] = json_encode($counts);
        
        $data['user']               = $user;

        $this->load->view('dashboard/index', $data);
    }
}
?>
