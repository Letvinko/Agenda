<?php

class Fullcalendar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('FullCalendar_model');
    }

    function index()
    {
        $todayDate = date('Y-m-d');

        $data = [];
        for ($i = 1; $i <= 7; $i++) {
            $temptgl = $i - 1;
            $date = strtotime($todayDate);
            $date = strtotime("+{$temptgl} day", $date);
            $date = date('Y-m-d', $date);
            $tanggal = $date;
            $temp = $this->FullCalendar_model->search($tanggal);
            $data["tanggalan{$i}"] = $temp;
        }
        $data = ['res' => $data];
        $this->load->view('Agenda', $data);
    }

    function loadRealtime()
    {

        $data = [];
        for ($i = 1; $i <= 7; $i++) {
            $tanggal = $this->input->post("tanggal{$i}");
            $temp = $this->FullCalendar_model->search($tanggal);
            $data["tanggalan{$i}"] = $temp;
        }
        $data = ['res' => $data];
        $this->load->view('dataTemplate', $data);
    }
}
