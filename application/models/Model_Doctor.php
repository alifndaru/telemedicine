<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Doctor extends CI_Model
{

    public function get_dokter($level = 'user', $limit = 5, $dari = 0, $specialization = null)
    {
        $this->db->select('users.*, klinik.klinik');
        $this->db->from('users');
        $this->db->join('klinik', 'klinik.id = users.klinik_id');
        $this->db->where('users.level', $level);

        if ($specialization) {
            $this->db->where('users.spesialis', $specialization);
        }

        $this->db->limit($limit, $dari);
        $query = $this->db->get();
        return $query->result_array();
    }



    public function count_all_doctors($level = 'user', $specialization = null)
    {
        $this->db->from('users');
        $this->db->where('level', $level);

        if ($specialization) {
            $this->db->where('spesialis', $specialization);
        }

        return $this->db->count_all_results();
    }

    public function get_specializations()
    {
        $this->db->distinct();
        $this->db->select('spesialis');
        $this->db->from('users');
        $this->db->where('level', 'user'); // Assuming you're filtering by user level
        return $this->db->get()->result_array();
    }
}
