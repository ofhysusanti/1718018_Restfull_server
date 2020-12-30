<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class buku extends REST_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('bukuModel');
  }

  public function index_get()
  {
    $buku = $this->bukuModel->getAllData($this->get('id'));

    $data = [
      'status' => true,
      'data' => $buku
    ];

    $this->response($data, REST_Controller::HTTP_OK);
  }

  public function index_delete()
  {
    $id = $this->delete('id');
    if ($id === null) {
      $this->response([
        'status' => false,
        'msg' => 'Isi ID terlebih dahulu'
      ], REST_Controller::HTTP_BAD_REQUEST);
    } else {
      if ($this->bukuModel->deletebuku($id) > 0) {
        $this->response([
          'status' => true,
          'id' => $id,
          'msg' => 'Data berhasil dihapus'
        ], REST_Controller::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'msg' => 'Id tidak ditemukan'
        ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }
  }

  public function index_post()
  {
    $data = [
      'id' => $this->post('id'),
      'judul' => $this->post('judul'),
      'pengarang' => $this->post('pengarang'),
      'tahun_terbit' => $this->post('tahun_terbit'),
      'penerbit' => $this->post('penerbit'),
    ];

    $simpan = $this->bukuModel->tambahbuku($data);
    
    if ($simpan['status']) {
      $this->response(['status' => true, 'msg' => 'Data telah ditambahkan'], REST_Controller::HTTP_OK);
    } else {
      $this->response(['status' => false, 'msg' => $simpan['msg']], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function index_put()
  {
    $data = [
      'judul' => $this->put('judul'),
      'pengarang' => $this->put('pengarang'),
      'tahun_terbit' => $this->put('tahun_terbit'),
      'penerbit' => $this->put('penerbit'),
    ];

    $id = $this->put('id');
    
    $simpan = $this->bukuModel->updatebuku($data, $id);

    if ($simpan['status']) {
      $status = (int) $simpan['data'];
      if ($status >= 0) {
        $this->response(['status' => true, 'msg' => 'Data telah diupdate'], REST_Controller::HTTP_OK);
      } else {
        $this->response(['status' => false, 'msg' => 'Tidak ada data yang dirubah'], REST_Controller::HTTP_BAD_REQUEST);
      }
    } else {
      $this->response(['status' => false, 'msg' => $simpan['msg']], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
  

 
}
