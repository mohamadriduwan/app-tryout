<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  public function index()
  {
    $data['title'] = 'Menu Management';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('menu', 'Menu', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/index', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> New Menu added!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('menu');
    }
  }


  public function submenu()
  {
    $data['title'] = 'Submenu Management';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $this->load->model('Menu_model', 'menu');

    $data['subMenu'] = $this->menu->getSubMenu();
    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required');
    $this->form_validation->set_rules('icon', 'icon', 'required');

    if ($this->form_validation->run() ==  false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/submenu', $data);
      $this->load->view('templates/footer');
    } else {
      $data = [
        'title' => $this->input->post('title'),
        'menu_id' => $this->input->post('menu_id'),
        'url' => $this->input->post('url'),
        'icon' => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active')
      ];
      $this->db->insert('user_sub_menu', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New sub menu added!</div>');
      redirect('menu/submenu');
    }
  }

  public function editMenu()
  {
    $data['title'] = 'Menu';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $menu = $this->input->post('menu');
    $menuid = $this->input->post('id');
    $this->form_validation->set_rules('menu', 'Menu', 'required');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal !</strong> Nama Menu tidak boleh kosong
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('menu');
    } else {
      $this->db->set('menu', $menu);
      $this->db->where('id', $menuid);
      $this->db->update('user_menu');
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> Menu has Edited!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('menu');
    }
  }

  public function deleteMenu()
  {

    $data['title'] = 'Menu';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['role'] = $this->db->get('user_menu')->result_array();

    $menuid = $this->input->post('id');

    $this->db->delete('user_menu', ['id' => $menuid]);
    $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> Menu sudah dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
    redirect('menu');
  }

  public function activesubMenu()
  {
    $submenu_id = $this->input->post('subMenuId');

    $result = $this->db->get_where('user_sub_menu', ['id' => $submenu_id])->row_array();

    $title = $result['title'];

    if ($result['is_active'] < 1) {
      $this->db->set('is_active', 1);
      $this->db->where('id', $submenu_id);
      $this->db->update('user_sub_menu');
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> ' . $title . ' diaktifkan!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
    } else {
      $this->db->set('is_active', 0);
      $this->db->where('id', $submenu_id);
      $this->db->update('user_sub_menu');
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> ' . $title . ' di non Aktifkan!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
    };
  }

  public function editSubmenu()
  {
    $data['title'] = 'subMenu';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $subMenuId = $this->input->post('id');
    $subMenuTitle = $this->input->post('title');
    $menuId = $this->input->post('menu_id');
    $subMenuUrl = $this->input->post('url');
    $subMenuIcon = $this->input->post('icon');

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('menu_id', 'MenuId', 'required');
    $this->form_validation->set_rules('url', 'url', 'required');
    $this->form_validation->set_rules('icon', 'icon', 'required');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal !</strong> data harus lengkap
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('menu/submenu');
    } else {
      $data = [
        'menu_id' => $menuId,
        'title' => $subMenuTitle,
        'url' => $subMenuUrl,
        'icon' => $subMenuIcon
      ];

      $this->db->where('id', $subMenuId);
      $this->db->update('user_sub_menu', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> subMenu has Edited!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('menu/submenu');
    }
  }

  public function deleteSubmenu()
  {

    $data['title'] = 'subMenu';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $subMenuId = $this->input->post('id');

    $this->db->delete('user_sub_menu', ['id' => $subMenuId]);
    $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Berhasil !</strong> subMenu sudah dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
    redirect('menu/submenu');
  }
}
