<?php

class Fullcalendar_model extends CI_Model
{
    public function search($date)
    {
        $this->db->select("*");
        $this->db->from("bf_agenda");
        $this->db->where("tgl_agenda", $date);
        $query = $this->db->get();
        return $query->result_array();
    }
}
