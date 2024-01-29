<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peserta_model extends CI_Model
{
    public function CreateNomor()
    {
        $this->db->select('RIGHT(data_peserta.no_peserta,4) as no_peserta', FALSE);
        $this->db->order_by('no_peserta', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('data_peserta');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->no_peserta) + 1;
        } else {
            $kode = 1;
        }
        $batas = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodetampil = "T" . $batas;
        return $kodetampil;
    }

    public function dataNilai($mapel)
    {
        if ($mapel == "total") {
            $urutan = "ORDER BY `data_nilai`.`no_peserta` ASC";
        }
        if ($mapel == "matematika") {
            $urutan = "ORDER BY `data_nilai`.`matematika` DESC, `data_nilai`.`waktu` ASC ";
        }
        if ($mapel == "umum") {
            $urutan = "ORDER BY `data_nilai`.`total` DESC , `data_nilai`.`waktu` ASC ";
        }
        if ($mapel == "ipa") {
            $urutan = "ORDER BY `data_nilai`.`ipa` DESC , `data_nilai`.`waktu` ASC ";
        }
        if ($mapel == "bindo") {
            $urutan = "ORDER BY `data_nilai`.`bindo` DESC , `data_nilai`.`waktu` ASC ";
        }
        if ($mapel == "bingg") {
            $urutan = "ORDER BY `data_nilai`.`bingg` DESC , `data_nilai`.`waktu` ASC ";
        }
        if ($mapel == "pai") {
            $urutan = "ORDER BY `data_nilai`.`pai` DESC , `data_nilai`.`waktu` ASC ";
        }
        $query = "SELECT `data_nilai`.*, `data_peserta`.*
        FROM `data_nilai` LEFT JOIN `data_peserta`
        ON `data_nilai`.`no_peserta` = `data_peserta`.`no_peserta`
        $urutan
      ";
        return $this->db->query($query)->result_array();
    }
}
