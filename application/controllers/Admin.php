<?php
defined('BASEPATH') or exit('No direct script access allowed');

// tambahan upload exel

require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

// sampai sini upload exel

class Admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/footer');
  }

  public function role()
  {
    $data['title'] = 'Role';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['role'] = $this->db->get('user_role')->result_array();
    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/role', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_role', ['role' => $this->input->post('role')]);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> New Role added!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('admin/role');
    }
  }

  public function editRole()
  {
    $data['title'] = 'Role';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $role = $this->input->post('role');
    $roleid = $this->input->post('id');
    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal !</strong> Nama Role tidak boleh kosong
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('admin/role');
    } else {
      $this->db->set('role', $role);
      $this->db->where('id', $roleid);
      $this->db->update('user_role');
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> Role Edited
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('admin/role');
    }
  }

  public function roleDelet()
  {

    $data['title'] = 'Role';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['role'] = $this->db->get('user_role')->result_array();

    $roleid = $this->input->post('id');

    $this->db->delete('user_role', ['id' => $roleid]);
    $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> Role sudah dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
    redirect('admin/role');
  }

  public function roleAccess($role_id)
  {
    $data['title'] = 'Role Access';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

    $this->db->where('id !=', 1);
    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/role-access', $data);
    $this->load->view('templates/footer');
  }


  public function changeAccess()
  {
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('roleId');

    $data = [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ];

    $result = $this->db->get_where('user_access_menu', $data);

    if ($result->num_rows() < 1) {
      $this->db->insert('user_access_menu', $data);
    } else {
      $this->db->delete('user_access_menu', $data);
    }

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
  }

  public function users()
  {
    $data['title'] = 'Users';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->model('Admin_model', 'admin');

    $data['role'] = $this->db->get('user_role')->result_array();
    $data['pengguna'] = $this->admin->getUsers();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/users', $data);
    $this->load->view('templates/footer');
  }

  public function addUser()
  {
    $data['title'] = 'Users';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->model('Admin_model', 'admin');

    $data['role'] = $this->db->get('user_role')->result_array();
    $data['pengguna'] = $this->admin->getUsers();

    $this->form_validation->set_rules('name', 'Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.email]', [
      'is_unique' => 'This email has already registered!'
    ]);
    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
      'matches' => 'Password dont match!',
      'min_length' => 'Password too short!'
    ]);
    $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal !</strong> Isi data masih salah
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('admin/users');
    } else {
      $email = $this->input->post('email', true);
      $data = [
        'name' => htmlspecialchars($this->input->post('name', true)),
        'email' => htmlspecialchars($email),
        'image' => 'default.jpg',
        'password' => $this->input->post('password1'),
        'role_id' => $this->input->post('role_id'),
        'is_active' => 1,
        'date_created' => time()
      ];

      $this->db->insert('user', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> User Has Created!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('admin/users');
    }
  }

  public function editUser()
  {
    $data['title'] = 'Users';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->model('Admin_model', 'admin');

    $data['role'] = $this->db->get('user_role')->result_array();
    $data['pengguna'] = $this->admin->getUsers();

    $this->form_validation->set_rules('name', 'Name', 'required|trim');
    $this->form_validation->set_rules('password1', 'Password', 'trim|min_length[3]|matches[password2]', [
      'matches' => 'Password dont match!',
      'min_length' => 'Password too short!'
    ]);
    $this->form_validation->set_rules('password2', 'Password', 'trim|matches[password1]');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal !</strong> Isi data masih salah
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('admin/users');
    } else {
      $email = $this->input->post('email', true);
      $password = $this->input->post('password1', true);
      if ($password == "") {
        $data = [
          'name' => htmlspecialchars($this->input->post('name', true)),
          'email' => htmlspecialchars($email),
          'role_id' => $this->input->post('role_id'),
        ];
      } else {
        $data = [
          'name' => htmlspecialchars($this->input->post('name', true)),
          'email' => htmlspecialchars($email),
          'password' => $password,
          'role_id' => $this->input->post('role_id'),
        ];
      }
      $this->db->where('email', $email);
      $this->db->update('user', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> Data sudah diEdit!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('admin/users');
    }
  }
  public function deleteUser()
  {

    $data['title'] = 'Pengguna';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['pengguna'] = $this->db->get('user')->result_array();

    $this->db->delete('user', ['id' => $this->input->post('id')]);

    $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Berhasil !</strong> Data sudah diHapus!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
    redirect('admin/users');
  }

  public function uploadUsers()
  {
    $this->load->model('Upload_model');

    $config['upload_path'] = './temp/';
    $config['allowed_types'] = 'xlsx|xls';
    $config['file_name'] = 'doc' . time();
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('importexcel')) {
      $file = $this->upload->data();
      $reader = ReaderEntityFactory::createXLSXReader();

      $reader->open('temp/' . $file['file_name']);
      foreach ($reader->getSheetIterator() as $sheet) {
        $numRow = 1;
        foreach ($sheet->getRowIterator() as $row) {
          if ($numRow > 1) {
            $dataUpload = array(
              'name'  => $row->getCellAtIndex(1),
              'email'  => $row->getCellAtIndex(2),
              'image'      => "default.jpg",
              'password' => $row->getCellAtIndex(3),
              'role_id' => $row->getCellAtIndex(4),
              'is_active' => 1,
              'date_created' => time()
            );
            $this->Upload_model->import_datauser($dataUpload);
          }
          $numRow++;
          $jumlah = $numRow - 2;
        }
        $reader->close();
        unlink('temp/' . $file['file_name']);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil !</strong> ' . $jumlah . 'users ditambahkan!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
        redirect('admin/users');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Gagal !</strong> 0 users ditambahkan!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>');
      redirect('admin/users');
    };
  }
}
