<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Create a new comment
    public function create_comment($data) {
        $this->db->insert('comments', $data);
        return $this->db->insert_id(); // Return the inserted comment ID
    }

    // Get all comments for a specific news item
    public function get_comments_by_news_id($news_id, $status = 'approved') {
        $this->db->select('
            comments.id, 
            comments.comment, 
            comments.created_at, 
            users.full_name AS user_name
        ');
        $this->db->from('comments');
        $this->db->join('users', 'comments.user_id = users.id', 'left'); // Join to get the user name
        $this->db->where('comments.news_id', $news_id);
        $this->db->where('comments.status', $status);
        $this->db->order_by('comments.created_at', 'DESC');
    
        return $this->db->get()->result(); // Return as an array of objects
    }
    

    // Count comments for a specific news item
    public function count_comments($news_id, $status = 'approved') {
        $this->db->from('comments');
        $this->db->where('news_id', $news_id);
        $this->db->where('status', $status);
        return $this->db->count_all_results(); // Return count of comments
    }

    // Delete a comment by ID
    public function delete_comment($comment_id) {
        $this->db->where('id', $comment_id);
        return $this->db->delete('comments'); // Return true if deleted successfully
    }

    public function get_pending_comments() {
        $this->db->select('
            comments.id, 
            comments.comment as content, 
            comments.created_at, 
            comments.status, 
            news.slug AS news_slug, 
            news.title AS news_title, 
            users.full_name AS author_name
        ');
        $this->db->from('comments');
        $this->db->join('news', 'comments.news_id = news.id', 'left');
        $this->db->join('users', 'comments.user_id = users.id', 'left');
        $this->db->where('comments.status', 'pending');
        $this->db->order_by('comments.created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    
    

    // Approve a comment
    public function approve_comment($comment_id) {
        $this->db->where('id', $comment_id);
        return $this->db->update('comments', ['status' => 'approved']);
    }

    // Reject a comment (mark as 'rejected' instead of deleting)
    public function reject_comment($comment_id) {
        $this->db->where('id', $comment_id);
        return $this->db->update('comments', ['status' => 'rejected']);
    }
}
?>
