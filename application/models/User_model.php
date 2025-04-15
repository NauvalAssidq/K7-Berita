<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // User Login
    public function login($username, $password) {
        $this->db->select('id, username, password, role');
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            $user = $query->row();
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    // User Registration
    public function register($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
    
    // Retrieve all users
    public function get_all_users() {
        $this->db->select('id, username, email, role, full_name');
        $query = $this->db->get('users');
        return $query->result();
    }    

    // Get total users
    public function get_total_users() {
        return $this->db->count_all('users');
    }

    // Get user growth
    public function get_daily_user_growth($days = 7) {
        $query = $this->db->query("
            SELECT DATE(created_at) as date, COUNT(id) as count 
            FROM users 
            WHERE created_at >= CURDATE() - INTERVAL ? DAY 
            GROUP BY DATE(created_at) 
            ORDER BY DATE(created_at) ASC
        ", array($days));
        
        return $query->result();
    }
    
    // Retrieve a single user by ID
    public function get_user($user_id) {
        $this->db->select('id, full_name, email, role, username, profile_image, password');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        return $this->db->get()->row();
    }
    
    // Update user details
    public function update_user($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }    
    
    // Count total users (supports search filter)
    public function get_users_count($search = null) {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('username', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('full_name', $search); // Search by full_name too
            $this->db->group_end();
        }
        return $this->db->count_all_results('users');
    }
    
    // Retrieve paginated users (supports search filter)
    public function get_users($limit, $offset, $search = null) {
        $this->db->select('id, full_name, username, email, role'); // Added full_name
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('full_name', $search);
            $this->db->or_like('username', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('users');
        return $query->result();
    }

    // Bulk delete    
    public function bulk_delete_users($ids) {
        $this->db->where_in('id', $ids);
        return $this->db->delete('users');
    }    

    // Delete a user
    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        return $this->db->delete('users');
    }
}