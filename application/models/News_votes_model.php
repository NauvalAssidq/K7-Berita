<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_votes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Cast a vote for a specific news item
    public function cast_vote($news_id, $user_id, $vote) {
        // Check if the user has already voted for this news
        $this->db->select('id');
        $this->db->from('news_votes');
        $this->db->where('news_id', $news_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // If a vote already exists, update it
            $this->db->set('vote', $vote);
            $this->db->where('news_id', $news_id);
            $this->db->where('user_id', $user_id);
            return $this->db->update('news_votes');
        } else {
            // Otherwise, insert a new vote
            $data = [
                'news_id' => $news_id,
                'user_id' => $user_id,
                'vote'    => $vote,
                'created_at' => date('Y-m-d H:i:s')
            ];
            return $this->db->insert('news_votes', $data); // Return true if inserted successfully
        }
    }

    // Get total votes (upvotes and downvotes) for a specific news item
    public function get_votes($news_id) {
        $this->db->select('
            SUM(CASE WHEN vote = "up" THEN 1 ELSE 0 END) as upvotes,
            SUM(CASE WHEN vote = "down" THEN 1 ELSE 0 END) as downvotes
        ');
        $this->db->from('news_votes');
        $this->db->where('news_id', $news_id);
        $query = $this->db->get();
        return $query->row(); // Return an object with upvotes and downvotes
    }
}
