<?php
defined('BASEPATH') or exit('No direct script access allowed');

class bukuModel extends CI_Model
{
  public function getAllData($id)
  {
    if($id !== null) $this->db->where('id', $id);
    return $this->db->get('tb_buku')->result();
  }

  public function deletebuku($id)
  {
    $this->db->delete('tb_buku', ['id' => $id]);
    return $this->db->affected_rows();
  }

  public function tambahbuku($data)
  {
    try {
      $this->db->insert('tb_buku', $data);
      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi kesalahan: ' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }

  public function updatebuku($data, $id)
  {
    try {
      $this->db->where('id', $id);
      $this->db->update('tb_buku', $data);

      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi kesalahan: ' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }

}