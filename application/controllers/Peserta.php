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

    $datapeserta = $this->db->get('data_peserta')->result_array();
    foreach ($datapeserta as $dp) :
      $jumlah[] = $dp['asal_sekolah'];
    endforeach;
    $data['dasar'] = array_unique($jumlah);
    $data['jumlahdasar'] = array_count_values($jumlah);

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
  public function watshap()
  {
    $data['title'] = 'Watshap';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['pengguna'] = $this->db->get('data_watshap')->result_array();


    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('peserta/watshap', $data);
    $this->load->view('templates/footer');
  }

  public function kirimWA()
  {
    $data['title'] = 'Watshap';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $siswa = $this->db->get('data_watshap')->result_array();

    $numRow = 1;
    foreach ($siswa as $s) :

      $nohp = $s['no_hp'];
      $nama = $s['nama'];
      $tokenujian = $s['token'];
      $ruang = $s['ruang'];

      // kadang ada penulisan no hp 0811 239 345
      $nohp = str_replace(" ", "", $nohp);
      // kadang ada penulisan no hp (0274) 778787
      $nohp = str_replace("(", "", $nohp);
      // kadang ada penulisan no hp (0274) 778787
      $nohp = str_replace(")", "", $nohp);
      // kadang ada penulisan no hp 0811.239.345
      $nohp = str_replace(".", "", $nohp);

      // cek apakah no hp mengandung karakter + dan 0-9
      if (!preg_match('/[^+0-9]/', trim($nohp))) {
        // cek apakah no hp karakter 1-3 adalah +62
        if (substr(trim($nohp), 0, 2) == '62') {
          $hp = trim($nohp);
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif (substr(trim($nohp), 0, 1) == '0') {
          $hp = '62' . substr(trim($nohp), 1);
        }
      }

      //WA SEND
      $token = "FXPeBUgeKxbQWFAWS11vECpNikLJ8owxWBoyXFAk8AMXcWdViP";
      $phone = $hp; //untuk group pakai groupid contoh: 62812xxxxxx-xxxxx
      $message = "Assalamu'alaikum," . PHP_EOL . "Kepada : *" . $nama . "*" . PHP_EOL . "No Pendaftaran : " . $tokenujian . PHP_EOL . "Berdasarkan hasil Tes Masuk MTs. Ma'arif Bakung 2024, anda dinyatakan *DITERIMA* sebagai siswa baru di MTs. Ma'arif Bakung, untuk itu *WALI SISWA* harap hadir di MTs. Ma'arif Bakung pada :" . PHP_EOL . "Hari: Senin, 12 Februari 2024" . PHP_EOL . "Waktu : Jam 08.00 WIB" . PHP_EOL . "Tempat : Ruang Multimedia Lt.2" . PHP_EOL . "Keperluan : Wawancara" . PHP_EOL . "Demikian pengumuman ini," . PHP_EOL . "Wassalamu'alaikum";
      $messageid = ""; //optional
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://lite.wanesia.com/api/send_express',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'token=' . $token . '&number=' . $phone . '&message=' . $message . '&messageid=' . $messageid,
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      //AKHIR WA SEND

      $data = [
        'keterangan' => 1
      ];

      $this->db->where('token', $tokenujian);
      $this->db->update('data_watshap', $data);
      $numRow++;

    endforeach;
    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Berhasil !</strong> ' . $numRow . ' Watshap Terkirim!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>');
    redirect('peserta/watshap');
  }

  public function uploadWatshap()
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
              'token'  => $row->getCellAtIndex(1),
              'nisn'  => $row->getCellAtIndex(2),
              'nama'   => $row->getCellAtIndex(3),
              'kelas' => $row->getCellAtIndex(4),
              'asal_sekolah' => $row->getCellAtIndex(5),
              'no_hp' => $row->getCellAtIndex(6),
              'ruang' => $row->getCellAtIndex(7)
            );
            $this->Upload_model->import_watshap($dataUpload);
          }
          $numRow++;
          $jumlah = $numRow - 2;
        }
        $reader->close();
        unlink('temp/' . $file['file_name']);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil !</strong> ' . $jumlah . ' Watshap ditambahkan!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
        redirect('peserta/watshap');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Gagal !</strong> 0 Watshap ditambahkan!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>');
      redirect('peserta/watshap');
    };
  }
  public function HapusWA()
  {
    $this->db->TRUNCATE('data_watshap');

    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Berhasil !</strong> Menghapus semua data!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>');
    redirect('peserta/watshap');
  }
}
