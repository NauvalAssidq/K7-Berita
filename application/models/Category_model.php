<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_all_categories() {
        $query = $this->db->get('categories');
        return $query->result();
    }

    public function get_categories($limit, $offset, $search = null) {
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('slug', $search);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('categories');
        return $query->result();
    }

    public function count_categories($search = null) {
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('slug', $search);
        }
        $this->db->from('categories');
        return $this->db->count_all_results();
    }

    public function get_paginated_categories($limit, $offset, $search = null) {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('slug', $search);
            $this->db->group_end();
        }
        $query = $this->db->get('categories', $limit, $offset);
        return $query->result();
    }

    public function create_category($data) {
        return $this->db->insert('categories', $data);
    }

    public function get_category($id) {
        return $this->db->get_where('categories', ['id' => $id])->row();
    }

    public function update_category($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    public function delete_category($id) {
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }

    public function bulk_delete($ids) {
        $this->db->where_in('id', $ids);
        return $this->db->delete('categories');
    }
}