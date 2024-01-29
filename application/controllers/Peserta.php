<?php
defined('BASEPATH') or exit('No direct script access allowed');

// tambahan upload exel

require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

// sampai sini upload exel

class Peserta extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  public function monitoring()
  {
    $data['title'] = 'Monitoring';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['jumlah'] = $this->db->get('data_peserta')->num_rows();
    $data['jumlahbelum'] = $this->db->get_where('data_peserta', ['pembayaran' => '0'])->num_rows();
    $data['jumlahbayar'] = $this->db->get_where('data_peserta', ['pembayaran' => '1'])->num_rows();
    $data['jumlahgratis'] = $this->db->get_where('data_peserta', ['pembayaran' => '2'])->num_rows();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('peserta/monitoring', $data);
    $this->load->view('templates/footer');
  }

  public function data()
  {
    $data['title'] = 'Data Peserta';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['pengguna'] = $this->db->get('data_peserta')->result_array();


    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('peserta/data', $data);
    $this->load->view('templates/footer');
  }

  public function addUser()
  {
    $data['title'] = 'Data Peserta';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['pengguna'] = $this->db->get('data_peserta')->result_array();

    $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
    $this->form_validation->set_rules('asal_sekolah', 'Asal_Sekolah', 'required|trim');
    $this->form_validation->set_rules('no_hp', 'No_hp', 'required|trim');
    $this->form_validation->set_rules('nisn', 'nisn', 'required|trim|is_unique[data_peserta.nisn]|min_length[10]', [
      'is_unique' => 'NISN Sudah Terdaftar!',
      'min_length' => 'NISN Harus 10 Digit'
    ]);
    $this->load->model('Peserta_model');
    $no_peserta = $this->Peserta_model->CreateNomor();

    if ($this->form_validation->run() == false) {
      if (form_error('nisn')) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal !</strong> ' . form_error('nisn') . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal !</strong> Isi data masih ada yang kosong
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>');
      }
      redirect('peserta/data');
    } else {
      $string = "0123456789";
      $password = substr(str_shuffle($string), 0, 8);
      $nisn = $this->input->post('nisn', true);
      $data = [
        'no_peserta' => $no_peserta,
        'nama' => htmlspecialchars($this->input->post('nama', true)),
        'nisn' => htmlspecialchars($nisn),
        'kelas' => $this->input->post('kelas'),
        'asal_sekolah' => $this->input->post('asal_sekolah'),
        'no_hp' => $this->input->post('no_hp'),
        'password' => $password,
        'date_created' => date('Y-m-d H:i:s')
      ];

      $this->db->insert('data_peserta', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> Peserta Tryout berhasil ditambahkan!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('peserta/data');
    }
  }

  public function deleteUser()
  {

    $data['title'] = 'Data Peserta';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['pengguna'] = $this->db->get('data_peserta')->result_array();

    $this->db->delete('data_peserta', ['id' => $this->input->post('id')]);

    $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Berhasil !</strong> Data sudah diHapus!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
    redirect('peserta/data');
  }

  public function editUser()
  {
    $data['title'] = 'Data Peserta';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['pengguna'] = $this->db->get('data_peserta')->result_array();

    $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
    $this->form_validation->set_rules('asal_sekolah', 'Asal_Sekolah', 'required|trim');
    $this->form_validation->set_rules('no_hp', 'No_hp', 'required|trim');
    $this->form_validation->set_rules('nisn', 'nisn', 'required|trim|min_length[10]', [
      'min_length' => 'NISN Harus 10 Digit'
    ]);

    if ($this->form_validation->run() == false) {
      if (form_error('nisn')) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal !</strong> ' . form_error('nisn') . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal !</strong> Isi data masih ada yang kosong
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>');
      }
      redirect('peserta/data');
    } else {
      $no_peserta = $this->input->post('no_peserta', true);
      $nisn = $this->input->post('nisn', true);
      $data = [
        'nama' => htmlspecialchars($this->input->post('nama', true)),
        'nisn' => htmlspecialchars($nisn),
        'kelas' => $this->input->post('kelas'),
        'asal_sekolah' => $this->input->post('asal_sekolah'),
        'no_hp' => $this->input->post('no_hp'),
        'date_update' => date('Y-m-d H:i:s')
      ];

      $this->db->where('no_peserta', $no_peserta);
      $this->db->update('data_peserta', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> Data sudah diEdit!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('peserta/data');
    }
  }

  public function uploadUsers()
  {
    $this->load->model('Upload_model');

    $config['upload_path'] = './temp/';
    $config['allowed_types'] = 'xlsx|xls';
    $config['file_name'] = 'doc' . time();
    $this->load->library('upload', $config);

    $this->load->model('Peserta_model');
    $string = "0123456789";
    if ($this->upload->do_upload('importexcel')) {
      $file = $this->upload->data();
      $reader = ReaderEntityFactory::createXLSXReader();
      $reader->open('temp/' . $file['file_name']);
      foreach ($reader->getSheetIterator() as $sheet) {
        $numRow = 1;
        foreach ($sheet->getRowIterator() as $row) {
          $no_peserta = $this->Peserta_model->CreateNomor();
          $password = substr(str_shuffle($string), 0, 8);
          if ($numRow > 1) {
            $dataUpload = array(
              'nisn'  => $row->getCellAtIndex(1),
              'nama'  => $row->getCellAtIndex(2),
              'no_peserta'   => $no_peserta,
              'kelas' => $row->getCellAtIndex(3),
              'asal_sekolah' => $row->getCellAtIndex(4),
              'no_hp' => $row->getCellAtIndex(5),
              'password' => $password,
              'date_created' => date('Y-m-d H:i:s')
            );
            if ($dataUpload['nisn'] == "") {
            } else {
              $this->Upload_model->import_datatryout($dataUpload);
            }
          }
          $numRow++;
          $jumlah = $numRow - 2;
        }
        $reader->close();
        unlink('temp/' . $file['file_name']);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil !</strong> users ditambahkan!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
        redirect('peserta/data');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Gagal !</strong> 0 users ditambahkan!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>');
      redirect('peserta/data');
    };
  }

  public function editBayar()
  {
    $data['title'] = 'Data Peserta';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


    $no_peserta = $this->input->post('no_peserta', true);
    $data = [
      'pembayaran' => $this->input->post('pembayaran')
    ];

    $this->db->where('no_peserta', $no_peserta);
    $this->db->update('data_peserta', $data);

    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> Pencatatan Pembayaran berhasil!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
    redirect('peserta/cetakkartu');
  }

  public function cetakKartu()
  {
    $data['title'] = 'Cetak Kartu';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['pengguna'] = $this->db->get('data_peserta')->result_array();


    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('peserta/cetakkartu', $data);
    $this->load->view('templates/footer');
  }

  public function kartu($id)
  {
    $this->load->library('pdfgenerator');
    $id = $id;
    $data['siswa'] = $this->db->get_where('data_peserta', ['no_peserta' => $id])->row_array();
    $data['title'] = "Cetak Kartu";
    $file_pdf = $data['title'] . " " . $id;
    $paper = 'A4';
    $orientation = "portrait";
    $html = $this->load->view('peserta/kartu', $data, true);
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }

  public function cetakBanyak()
  {
    $no_peserta1 = $this->input->post('no_pendaftaran1', true);
    $no_peserta2 = $this->input->post('no_pendaftaran2', true);

    $this->db->where('no_peserta >=', $no_peserta1);
    $this->db->where('no_peserta <=', $no_peserta2);
    $data['siswa'] = $this->db->get('data_peserta')->result_array();


    $this->load->library('pdfgenerator');
    $data['title'] = "Cetak Banyak Kartu";
    $file_pdf = $data['title'];
    $paper = 'A4';
    $orientation = "portrait";
    $html = $this->load->view('peserta/banyakkartu', $data, true);
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }

  public function dataNilai()
  {
    $data['title'] = 'Nilai Tryout';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->model('Peserta_model', 'Peserta');

    $data['nilai'] = $this->Peserta->dataNilai("total");


    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('peserta/datanilai', $data);
    $this->load->view('templates/footer');
  }

  public function uploadNilai()
  {
    $this->load->model('Upload_model');

    $config['upload_path'] = './temp/';
    $config['allowed_types'] = 'xlsx|xls';
    $config['file_name'] = 'doc' . time();
    $this->load->library('upload', $config);

    $this->load->model('Peserta_model');
    if ($this->upload->do_upload('importexcel')) {
      $file = $this->upload->data();
      $reader = ReaderEntityFactory::createXLSXReader();
      $reader->open('temp/' . $file['file_name']);
      foreach ($reader->getSheetIterator() as $sheet) {
        $numRow = 1;
        foreach ($sheet->getRowIterator() as $row) {
          if ($numRow > 1) {
            $dataUpload = array(
              'no_peserta'  => $row->getCellAtIndex(1),
              'matematika'  => $row->getCellAtIndex(2),
              'ipa'   => $row->getCellAtIndex(3),
              'bindo' => $row->getCellAtIndex(4),
              'bingg' => $row->getCellAtIndex(5),
              'pai' => $row->getCellAtIndex(6),
              'total' => $row->getCellAtIndex(7),
              'waktu' => $row->getCellAtIndex(8)
            );
            $this->Upload_model->import_datanilai($dataUpload);
          }
          $numRow++;
          $jumlah = $numRow - 2;
        }
        $reader->close();
        unlink('temp/' . $file['file_name']);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil !</strong> ' . $jumlah . ' Nilai ditambahkan!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
        redirect('peserta/datanilai');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Gagal !</strong> 0 Nilai ditambahkan!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>');
      redirect('peserta/datanilai');
    };
  }

  public function ranking()
  {
    $data['title'] = 'Ranking';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->model('Peserta_model', 'Peserta');
    $data['nilaiUmum'] = $this->Peserta->dataNilai("umum");
    $data['nilaiMatematika'] = $this->Peserta->dataNilai("matematika");
    $data['nilaiIpa'] = $this->Peserta->dataNilai("ipa");
    $data['nilaiBindo'] = $this->Peserta->dataNilai("bindo");
    $data['nilaiBingg'] = $this->Peserta->dataNilai("bingg");
    $data['nilaiPai'] = $this->Peserta->dataNilai("pai");


    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('peserta/ranking', $data);
    $this->load->view('templates/footer');
  }

  public function sertifikat()
  {
    $this->load->library('pdfgenerator');

    $no_peserta = $this->input->post('no_peserta');
    $nama = $this->input->post('nama');
    $asal_sekolah = $this->input->post('asal_sekolah');
    $ranking = $this->input->post('ranking');
    $mapel = $this->input->post('mapel');

    $data['siswa'] = [
      'no_peserta' => $no_peserta,
      'nama' => $nama,
      'asal_sekolah' => $asal_sekolah,
      'ranking' => $ranking,
      'mapel' => $mapel
    ];


    $data['title'] = "Cetak Sertifikat";
    $file_pdf = $data['title'] . " " . $no_peserta;
    $paper = 'A4';
    $orientation = "Landscape";
    $html = $this->load->view('peserta/sertifikat', $data, true);
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
}
