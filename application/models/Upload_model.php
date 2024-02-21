<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload_model extends CI_Model
{
    public function import_datauser($dataUpload)
    {
        $jumlah = count($dataUpload);
        if ($jumlah > 0) {
            $this->db->replace('user', $dataUpload);
        }
    }

    public function import_datatryout($dataUpload)
    {
        $jumlah = count($dataUpload);
        if ($jumlah > 0) {
            $this->db->insert('data_peserta', $dataUpload);
        }
    }

    public function import_datanilai($dataUpload)
    {
        $jumlah = count($dataUpload);
        if ($jumlah > 0) {
            $this->db->insert('data_nilai', $dataUpload);
        }
    }

    public function import_watshap($dataUpload)
    {
        $jumlah = count($dataUpload);
        if ($jumlah > 0) {
            $this->db->insert('data_watshap', $dataUpload);
        }
    }
}
