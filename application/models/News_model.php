<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Create a new news article.
     * @param array $data - News article data.
     * @return mixed - Inserted news ID or false.
     */
    public function create_news($data) {
        if ($this->db->insert('news', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Retrieve news articles with pagination and optional search.
     * @param int $limit - Number of records to retrieve.
     * @param int $offset - Offset for pagination.
     * @param string|null $search - Optional search term.
     * @return array - List of news articles.
     */
    public function get_news($limit, $offset, $search = null, $category = null) {
        $this->db->select('news.*, categories.name AS category_name, categories.slug AS category_slug, users.full_name as author_name');
        $this->db->join('categories', 'categories.id = news.category_id', 'left');
        $this->db->from('news');
        $this->db->join('users', 'news.author_id = users.id', 'left');
    
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('news.title', $search);
            $this->db->or_like('news.content', $search);
            $this->db->or_like('categories.name', $search);
            $this->db->group_end();
        }
    
        if (!empty($category)) {
            $this->db->where('news.category_id', $category);
        }
    
        $this->db->order_by('news.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    

    /**
     * Count total news articles, optionally filtered by a search term.
     * @param string|null $search - Optional search term.
     * @return int - Total number of news articles.
     */
    public function get_news_count($search = null, $category_id = null) {
        $this->db->from('news');
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->or_like('content', $search);
            $this->db->or_like('slug', $search);
            $this->db->group_end();
        }

        if (!empty($category)) {
            $this->db->where('news.category_id', $category);
        }

        return $this->db->count_all_results();
    }

    /**
     * Retrieve a single news article by its ID.
     * @param int $id - News article ID.
     * @return object|null - News article record or null if not found.
     */
    public function get_news_by_id($id) {
        $this->db->select('news.*, categories.name AS category_name, users.full_name, users.username');
        $this->db->from('news');
        $this->db->join('categories', 'news.category_id = categories.id', 'left');
        $this->db->join('users', 'news.author_id = users.id', 'left');
        $this->db->where('news.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Update a news article.
     * @param int $id - News article ID.
     * @param array $data - Data to update.
     * @return bool - True if update successful, false otherwise.
     */
    public function update_news($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('news', $data);
    }

    /**
     * Delete a news article.
     * @param int $id - News article ID.
     * @return bool - True if deletion successful, false otherwise.
     */
    public function delete_news($id) {
        $this->db->where('id', $id);
        return $this->db->delete('news');
    }

    /**
     * Insert a media record into the news_media table.
     * @param array $media_data - Media record data.
     * @return bool - True if insert successful, false otherwise.
     */
    public function add_news_media($media_data) {
        return $this->db->insert('news_media', $media_data);
    }

    /**
     * (Optional) Retrieve all media records associated with a news article.
     * @param int $news_id - News article ID.
     * @return array - List of media records.
     */
    public function get_news_media($news_id) {
        $this->db->where('news_id', $news_id);
        $query = $this->db->get('news_media');
        return $query->result();
    }

    public function bulk_delete_news($ids) {
        $this->db->where_in('id', $ids);
        return $this->db->delete('news');
    }

    // Count news articles filtered by published status
    public function get_news_count_by_status($status) {
        $this->db->from('news');
        $this->db->where('published', $status);
        return $this->db->count_all_results();
    }

    // Get the latest news articles (e.g., by created_at descending)
    public function get_latest_news($limit) {
        $this->db->select('news.*, categories.name AS category_name, users.full_name, users.username');
        $this->db->from('news');
        $this->db->join('categories', 'news.category_id = categories.id', 'left');
        $this->db->join('users', 'news.author_id = users.id', 'left');
        $this->db->order_by('news.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    public function cast_vote($news_id, $user_id, $vote) {
        // Remove any previous vote
        $this->db->where(['news_id' => $news_id, 'user_id' => $user_id])->delete('news_votes');
        
        // Insert new vote
        $data = [
            'news_id' => $news_id,
            'user_id' => $user_id,
            'vote'    => $vote
        ];
        return $this->db->insert('news_votes', $data);
    }
    
    public function get_votes($news_id) {
        $this->db->select("SUM(CASE WHEN vote = 'up' THEN 1 ELSE 0 END) as upvotes, 
                            SUM(CASE WHEN vote = 'down' THEN 1 ELSE 0 END) as downvotes");
        $this->db->from('news_votes');
        $this->db->where('news_id', $news_id);
        return $this->db->get()->row();
    }

    public function get_news_by_slug($slug)
    {
        return $this->db->where('slug', $slug)->get('news')->row();
    }

    public function get_related_news($category_id, $exclude_id)
    {
        return $this->db->where('category_id', $category_id)
                        ->where('id !=', $exclude_id)
                        ->limit(4)
                        ->order_by('created_at', 'DESC')
                        ->get('news')
                        ->result();
    }   
}
?>
