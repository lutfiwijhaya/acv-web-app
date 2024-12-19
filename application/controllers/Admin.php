<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) redirect(site_url('login'));
        $this->load->model('Login_model', 'login_model');
        $this->load->model('Backend_model', 'backend_model');
        $this->load->model('Menu_model', 'menu_model');
        $this->load->model('Global_model', 'global_model');
    }

    function index()
    {
        $data['title']  = 'Achivon Prestasi Abadi';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        // $data['js_files'][] = base_url() . 'assets/admin/js/menu.js';
        $data['content'] = 'test';
        $this->template->load('template', 'dashboard', $data);
    }

    function login()
    {

        $query = $this->login_model->getLogin()->row_array();
        $this->session->set_userdata($query);
        $this->load->view('auth/login');
    }
    function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('status_login', 'Anda sudah berhasil keluar dari aplikasi');
        $this->load->view('auth/login', 'refresh');
    }

    function isLevel()
    {
        $this->output->set_content_type('application/json');
        $level = $this->backend_model->getIsLevel();
        echo json_encode($level);
    }
    function akses()
    {
        $data['css_files'][] = '';
        $data['js_files'][] = '';
        $data['level'] = $this->db->get_where('tbl_levels', array('id_posisi' =>  $this->uri->segment(3)))->row_array();
        $data['menu'] = $this->db->get_where('tbl_menus', array('is_main !=' => null))->result();
        $this->template->load('template', 'master/akses', $data);
    }

    function kasi_akses_ajax()
    {
        $id_menu        = $_GET['id_menu'];
        $id_user_level  = $_GET['level'];
        // chek data
        $params = array('id_menu' => $id_menu, 'id_posisi' => $id_user_level);
        $akses = $this->db->get_where('tbl_levels', $params);
        if ($akses->num_rows() < 1) {
            // insert data baru
            $this->db->insert('tbl_levels', $params);
        } else {
            $this->db->where('id_menu', $id_menu);
            $this->db->where('id_posisi', $id_user_level);
            $this->db->delete('tbl_levels');
        }
    }
    function menu()
    {
        $data['title']  = 'Data Menu';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/menu', $data);
    }
    function getMenus()
    {
        $this->output->set_content_type('application/json');
        $users = $this->backend_model->getMenus();
        echo json_encode($users);
    }
    public function ismain()
    {
        $this->output->set_content_type('application/json');
        $ismain = $this->backend_model->getIsMain();
        echo json_encode($ismain);
    }
    function updateMenu()
    {
        $title = $this->input->post('title', TRUE);
        $uri = $this->input->post('uri', TRUE);
        $icon = $this->input->post('icon', TRUE);
        $is_main = $this->input->post('is_main', TRUE);
        $order = $this->input->post('order', TRUE);
        $data = array();
        $data = array(
            'title'         => $title,
            'uri'           => $uri,
            'icon'          => $icon,
            'is_main'       => $is_main,
            'ordinal'         => $order
        );
        $where = array('_id' => $this->input->get('id'));
        $result = $this->global_model->update('tbl_menus', $data, $where);
        if ($result) {
            echo json_encode(array('message' => 'Update Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    function saveMenu()
    {
        $title = $this->input->post('title', TRUE);
        $uri = $this->input->post('uri', TRUE);
        $icon = $this->input->post('icon', TRUE);
        $is_main = $this->input->post('is_main', TRUE);
        $order = $this->input->post('order', TRUE);
        $data = array();
        $data = array(
            'title'         => $title,
            'uri'           => $uri,
            'icon'          => $icon,
            'is_main'       => $is_main,
            'ordinal'       => $order
        );
        $result = $this->global_model->insert('tbl_menus', $data);
        if ($result) {
            echo json_encode(array('message' => 'Save Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


   


    function aktifMenu()
    {
        $id = $this->input->post('id');
        $rows = $this->db->get_where('tbl_menus', array('_id' => $id))->row_array();
        if ($rows['is_aktif'] == 0) {
            $aktif = 1;
        } else {
            $aktif = 0;
        }
        $result = $this->global_model->update('tbl_menus', array('is_aktif' => $aktif), array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Menu ' . $rows['title'] . ' Aktif or Non Aktif Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    function destroyMenu()
    {
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_menus', array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    //modul user
    //list pegawai//
    function users()
    {
        $data['title']  = 'Data Pegawai';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/users', $data);
    }

    public function ping()
    {
        // Melakukan query ringan untuk menjaga koneksi tetap hidup
        $this->db->query('SELECT 1');
        echo 'Connection Alive';
    }






    //params
    public function set_menu_title()
    {
        // Ambil nilai menu_title dari request
        $menu_title = $this->input->post('menu_title');

        // Simpan ke session
        $this->session->set_userdata('menu_title', $menu_title);

        // Kirim respons balik ke frontend
        echo json_encode(['status' => 'success', 'menu_title' => $menu_title]);
    }





    public function getKodeBarangByKode()
    {
        $kode_barang = $this->input->post('kode_barang');
        $category = $this->input->post('category'); // Ambil category dari request

        if ($kode_barang && $category) {
            $this->db->select('id,kode_barang, category, inisial_kuantitas, level_1, level_2, level_3, level_4, remark');
            $this->db->from('wh_items');
            $this->db->where('kode_barang', $kode_barang);
            $this->db->where('category', $category); // Tambah filter category
            $this->db->where('is_deleted', '0');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $result = $query->row();
                echo json_encode($result);
            } else {
                echo json_encode(['error' => 'Data not found']);
            }
        } else {
            echo json_encode(['error' => 'Invalid kode_barang or category']);
        }
    }


    public function getKodeBarang()
    {
        $category = $this->input->get('category');

        $this->db->select('kode_barang');
        $this->db->from('wh_items');
        $this->db->where('category', $category);  // Filter berdasarkan category yang dipilih
        $query = $this->db->get();

        $result = $query->result();

        // Pastikan hasil dikembalikan dalam format JSON dengan array yang benar
        echo json_encode($result);
    }



    function params()
    {
        $data['title']  = 'Params Managements';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/params', $data);
    }

    function adminshare($desc)
    {
        $desc = urldecode($desc);
        $data['desc']  = $desc;
        $data['title']  = 'Share Managements';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/admin-shared', $data);
    }

    function filesharepid($desc)
    {
        $desc = urldecode($desc);
        $data['desc']  = $desc;
        $data['title']  = 'File P&ID';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/admin-shared-pid', $data);
    }

    function filesharedsteelstructure($desc)
    {
        $desc = urldecode($desc);
        $data['desc']  = $desc;
        $data['title']  = 'File Steel Structure';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/admin-shared-steelstructure', $data);
    }

    function fileshareequipment($desc)
    {
        $desc = urldecode($desc);
        $data['title']  = 'File Equipment';
        $data['desc']  = $desc;
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/admin-shared-equipment', $data);
    }

    function filesharedpiping($desc)
    {
        $desc = urldecode($desc);
        $data['title']  = 'File Piping';
        $data['desc']  = $desc;
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/admin-shared-piping', $data);
    }


    function getsharedfiles($desc)
    {
        $desc = urldecode($desc);
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getsharedFiles($desc);
        echo json_encode($stock);
    }

    function getsharedfilespiping($desc)
    {
        $desc = urldecode($desc);
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getsharedFilespiping($desc);
        echo json_encode($stock);
    }

    function getsharedfilesequipment($desc)
    {
        $desc = urldecode($desc);


        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getsharedfilesEquipment($desc);
        echo json_encode($stock);
    }

    function getsharedfilespid($desc)
    {
        $desc = urldecode($desc);
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getsharedFilespid($desc);
        echo json_encode($stock);
    }

    function getfilesharesteelstructure($desc)
    {
        $desc = urldecode($desc);
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getsharedFilessteelstructure($desc);
        echo json_encode($stock);
    }

    function getparams()
    {
        $this->output->set_content_type('application/json');
        $params = $this->backend_model->getParams();
        echo json_encode($params);
    }

    function saveParams()
    {
        $param_name = $this->input->post('param_name', TRUE);
        $param_group = $this->input->post('param_group', TRUE);
        $status = $this->input->post('status', TRUE);
        $remark = $this->input->post('remark', TRUE);
        $data = array();
        $data = array(
            'param_name'         => $param_name,
            'param_group'        => $param_group,
            'status'             => $status,
            'remark'             => $remark,
        );
        $result = $this->global_model->insert('params', $data);
        if ($result) {
            echo json_encode(array('message' => 'Save Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    //    public function saveDistribution() {
    //     // Ambil input dari post
    //     $date      = $this->input->post('tanggal');
    //     $no_req    = $this->input->post('no_req');
    //     $dist_type = $this->input->post('dist_type');
    //     $remark    = $this->input->post('remark');
    //     $item_id   = $this->input->post('item_id');
    //     $from      = $this->input->post('from');
    //     $id_from   = $this->input->post('id_from');
    //     $to        = $this->input->post('to');
    //     $id_to     = $this->input->post('id_to');
    //     $qty       = $this->input->post('quantity');
    //     $po_number = $this->input->post('po_number');

    //     // Validasi dan mapping nilai $from ke field yang sesuai di database
    //     if ($from == 'warehouse_id') {
    //         $from = 'from_warehouse_id';
    //     } else if ($from == 'employee_id') {
    //         $from = 'from_employee_id';
    //     } else {
    //         $from = 'from_supplier_id'; // Harus konsisten dengan nama kolom di database
    //     }

    //     // Data yang akan disimpan
    //     $data = array(
    //         'item_id'           => $item_id,
    //         $from               => $id_from, // Kunci dinamis tergantung nilai $from
    //         $to                 => $id_to,   // Diasumsikan $to adalah nama kolom yang benar
    //         'qty'               => $qty,
    //         'distribution_date' => $date,
    //         'remark'            => $remark,
    //         'po_id'             => $po_number,
    //         'request_id'        => $no_req,
    //         'distribution_type' => $dist_type // Koreksi typo dari distibution_type
    //     );

    //     // Simpan data
    //     $result = $this->global_model->insert('wh_distribution', $data);

    //     // Cek hasil dan berikan respons
    //     if ($result) {
    //         echo json_encode(array('message' => 'Save Success'));
    //     } else {
    //         echo json_encode(array('errorMsg' => 'Some errors occurred.'));
    //     }
    // }

    public function saveDistribution()
    {
        // Ambil input dari post
        $date      = $this->input->post('tanggal', TRUE);
        $no_req    = $this->input->post('no_req', TRUE);
        $dist_type = $this->input->post('dist_type', TRUE);
        $remark    = $this->input->post('remark', TRUE);
        $item_id   = $this->input->post('item_id', TRUE);
        $from      = $this->input->post('from', TRUE);
        $id_from   = $this->input->post('id_from', TRUE);
        $to        = $this->input->post('to', TRUE);
        $id_to     = $this->input->post('id_to', TRUE);
        $qty       = $this->input->post('quantity', TRUE);
        $po_number = $this->input->post('po_number', TRUE);
        $from_dist = '';
        $to_dist   = '';

        // Mapping nilai $from ke field yang sesuai di database
        if ($from == 'warehouse_id') {
            $from_dist = 'from_warehouse_id';
        } else if ($from == 'employee_id') {
            $from_dist = 'employee_id_from';
        } else {
            $from_dist = 'from_supplier_id';
        }

        if ($to == 'warehouse_id') {
            $to_dist = 'to_warehouse_id';
        } else if ($to == 'employee_id') {
            $to_dist = 'employee_id_to';
        } else {
            $to_dist = 'to_supplier_id';
        }

        // Data yang akan disimpan ke dalam wh_distribution
        $data = array(
            'item_id'           => $item_id,
            $from_dist          => $id_from,
            $to_dist            => $id_to,
            'qty'               => $qty,
            'distribution_date' => $date,
            'remark'            => $remark,
            'po_id'             => $po_number,
            'request_id'        => $no_req,
            'distribution_type' => $dist_type
        );

        // Simpan data ke wh_distribution
        $result = $this->global_model->insert('wh_distribution', $data);

        if ($result) {
            // 1. Kurangi stok dari `id_from`
            $this->db->set('quantity', 'quantity - ' . (int)$qty, FALSE);
            $this->db->where('item_id', $item_id);
            $this->db->where($from, $id_from);
            $this->db->update('wh_items_stock');

            // 2. Cek apakah ada stok di `id_to`
            $this->db->where('item_id', $item_id);
            $this->db->where($to, $id_to);
            $query = $this->db->get('wh_items_stock');

            if ($dist_type == 'Consumable' && $to == 'employee_id') {
                $qty = 0;
            }

            if ($query->num_rows() > 0) {
                // Jika ada, tambahkan stok
                $this->db->set('quantity', 'quantity + ' . (int)$qty, FALSE);
                $this->db->where('item_id', $item_id);
                $this->db->where($to, $id_to);
                $this->db->update('wh_items_stock');
            } else {
                // Jika tidak ada, lakukan insert
                $data_to_insert = array(
                    'item_id' => $item_id,
                    $to       => $id_to,
                    'quantity'     => $qty
                );
                $this->db->insert('wh_items_stock', $data_to_insert);
            }

            // Berikan respons sukses
            echo json_encode(array('message' => 'Save Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occurred.'));
        }
    }




    function updateParams()
    {
        $param_name = $this->input->post('param_name', TRUE);
        $param_group = $this->input->post('param_group', TRUE);
        $status = $this->input->post('status', TRUE);
        $remark = $this->input->post('remark', TRUE);
        $data = array();
        $data = array(
            'param_name'         => $param_name,
            'param_group'        => $param_group,
            'status'             => $status,
            'remark'             => $remark,
        );
        $where = array('id' => $this->input->get('id'));
        $result = $this->global_model->update('params', $data, $where);
        if ($result) {
            echo json_encode(array('message' => 'Update Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    function destroyParams()
    {
        $id = $this->input->post('id');
        $result = $this->global_model->delete('params', array('id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getCategoryParams()
    {

        $this->db->select('param_name');
        $this->db->from('params');
        $this->db->where('param_group', 'category');  // sesuaikan dengan group untuk kategori
        $query = $this->db->get();

        $result = $query->result();
        echo json_encode($result);
    }

    public function getDistributionValue()
    {

        $this->db->select('param_name,remark');
        $this->db->from('params');
        $this->db->where('param_group', 'distribution_value');  // sesuaikan dengan group untuk kategori
        $query = $this->db->get();
        $result = $query->result();
        echo json_encode($result);
    }

    public function getFromId()
    {

        $remark = $this->input->get('remark');
        if ($remark) {
            if ($remark == 'wh_warehouse') {
                $this->db->select('wh_name,id');
                $this->db->from($remark);
                $query = $this->db->get();
                $result = $query->result();
                echo json_encode($result);
            } else if ($remark == 'tbl_user') {
                $this->db->select('nama,_id');
                $this->db->from($remark);
                $query = $this->db->get();
                $result = $query->result();
                echo json_encode($result);
            } else {
                $this->db->select('wh_name');
                $this->db->from($remark);
                $query = $this->db->get();
                $result = $query->result();
                echo json_encode($result);
            }
        } else {
            echo json_encode(['error' => 'Invalid remark']);
        }
    }



    public function checkStock()
    {
        $item_id = $this->input->get('item_id');
        $from_id = $this->input->get('id_from');
        $from = $this->input->get('from');

        // Validasi item_id
        if (!$item_id) {
            echo json_encode(['error' => 'Invalid item_id']);
            return;
        }

        // Validasi kolom 'from' agar aman
        $valid_columns = ['warehouse_id', 'employee_id', 'supplier_id'];
        if (!in_array($from, $valid_columns)) {
            echo json_encode(['error' => 'Invalid from parameter']);
            return;
        }

        // Query ke database dengan SUM untuk menjumlahkan quantity
        $this->db->select_sum('quantity');
        $this->db->from('wh_items_stock');
        $this->db->where('item_id', $item_id);
        $this->db->where($from, $from_id);

        $query = $this->db->get();

        // Mengembalikan hasil query dalam format JSON
        if ($query->num_rows() > 0 && $query->row()->quantity !== null) {
            // Mengembalikan jumlah stok
            echo json_encode(['quantity' => $query->row()->quantity]);
        } else {
            echo json_encode(['error' => 'Stock not found']);
        }
    }

    public function getGroupParams()
    {
        $this->db->distinct();  // Menambahkan klausa DISTINCT
        $this->db->select('param_group');
        $this->db->from('params');
        $query = $this->db->get();

        $result = $query->result();
        echo json_encode($result);
    }

    public function getlevel1shared()
    {
        $this->db->select('param_name');
        $this->db->from('params');
        $this->db->where('param_group', 'KN_Chemical_Plant');  // sesuaikan dengan group untuk kategori
        $query = $this->db->get();

        $result = $query->result();
        echo json_encode($result);
    }

    public function getLevel2shared()
    {
        $level_1_shared = $this->input->get('level_1');  // Ambil level_1 yang dipilih

        $this->db->select('param_name,remark');
        $this->db->from('params');
        $this->db->where('status', $level_1_shared);
        $this->db->where('remark', 'KN_Chemical_Plant');  // Filter berdasarkan remark yang sesuai dengan level_1
        $query = $this->db->get();

        $result = $query->result();
        echo json_encode($result);
    }

    public function gettypefile()
    {
        $this->db->select('param_name');
        $this->db->from('params');
        $this->db->where('param_group', 'type_file');  // sesuaikan dengan group untuk kategori
        $query = $this->db->get();

        $result = $query->result();
        echo json_encode($result);
    }

    public function getInisialKuantitasParams()
    {
        $this->db->select('param_name');
        $this->db->from('params');
        $this->db->where('param_group', 'inisial_kuantitas');  // sesuaikan dengan group untuk kategori
        $query = $this->db->get();

        $result = $query->result();
        echo json_encode($result);
    }


    public function getLevel1Params()
    {
        $this->db->select('param_name,status');
        $this->db->from('params');
        $this->db->where('param_group', 'wh_level_1');  // Hanya ambil data untuk level 1
        $query = $this->db->get();

        $result = $query->result();
        echo json_encode($result);
    }

    public function getLevel2Params()
    {
        $level_1 = $this->input->get('level_1');  // Ambil level_1 yang dipilih

        $this->db->select('param_name,status');
        $this->db->from('params');
        $this->db->where('param_group', 'wh_level_2');
        $this->db->where('remark', $level_1);  // Filter berdasarkan remark yang sesuai dengan level_1
        $query = $this->db->get();

        $result = $query->result();
        echo json_encode($result);
    }

    public function getLevel3Params()
    {
        $level_2 = $this->input->get('level_2');  // Ambil level_1 yang dipilih

        $this->db->select('param_name,status');
        $this->db->from('params');
        $this->db->where('param_group', 'wh_level_3');
        $this->db->where('remark', $level_2);  // Filter berdasarkan remark yang sesuai dengan level_1
        $query = $this->db->get();

        $result = $query->result();
        echo json_encode($result);
    }

    public function getLevel4Params()
    {
        $level_3 = $this->input->get('level_3');  // Ambil level_1 yang dipilih

        $this->db->select('param_name,status');
        $this->db->from('params');
        $this->db->where('param_group', 'wh_level_4');
        $this->db->where('remark', $level_3);  // Filter berdasarkan remark yang sesuai dengan level_1
        $query = $this->db->get();

        $result = $query->result();
        echo json_encode($result);
    }




    public function getCountForLevel1()
    {
        $param_name = $this->input->get('param_name', TRUE);

        $this->db->from('wh_items');
        $this->db->where('level_1', $param_name);
        $count = $this->db->count_all_results();

        echo json_encode(array('count' => $count));
    }





    function saveUsers()
    {
        $nik               = $this->input->post('nik', TRUE);
        $password       = $this->input->post('password', TRUE);
        $options        = array("cost" => 4);
        $hashPassword    = password_hash($password, PASSWORD_BCRYPT, $options);
        $nama           = $this->input->post('nama', TRUE);
        $jk              = $this->input->post('jk', TRUE);
        $tempat         = $this->input->post('tempat_lahir', TRUE);
        $tgl_l          = $this->input->post('tgl_lahir', TRUE);
        $tgl_g            = $this->input->post('tgl_masuk', TRUE);
        $posisi           = $this->input->post('posisi', TRUE);
        $alamat           = $this->input->post('alamat', TRUE);
        $no_hp           = $this->input->post('no_hp', TRUE);
        $email           = $this->input->post('email', TRUE);
        $marital           = $this->input->post('marital', TRUE);
        $npwp           = $this->input->post('npwp', TRUE);
        $bpjs_ks           = $this->input->post('bpjs_ks', TRUE);
        $bpjs_kt           = $this->input->post('bpjs_kt', TRUE);
        $employee_id    = $this->input->post('id_employee', TRUE);

        // Konfigurasi upload file
        $config['upload_path'] = './uploads/';  // Direktori sementara untuk upload
        $config['allowed_types'] = 'jpg|jpeg|png';  // Tipe file yang diizinkan
        $config['max_size'] = 200;  // Batas ukuran file dalam KB

        $this->load->library('upload', $config);

        // Variabel untuk menyimpan nama file
        $file_name = null;

        if ($this->upload->do_upload('foto')) {
            $uploadData = $this->upload->data();
            $file_name = $uploadData['file_name'];  // Mendapatkan nama file yang di-upload

            // Simpan path dari file yang di-upload
            $file_path = base_url('uploads/') . $file_name;  // Path relatif file yang di-upload
        }

        // Menyimpan data ke database
        $data = array(
            'employee-id'    => $employee_id,
            'nik'            => $nik,
            'password'       => $hashPassword,
            'nama'           => $nama,
            'jk'             => $jk,
            'tempat_lahir'   => $tempat,
            'tgl_lahir'      => $tgl_l,
            'tgl_masuk'      => $tgl_g,
            'posisi'         => $posisi,
            'alamat'         => $alamat,
            'no_hp'          => $no_hp,
            'email'          => $email,
            'marital'        => $marital,
            'npwp'           => $npwp,
            'bpjs_ks'        => $bpjs_ks,
            'bpjs_kt'        => $bpjs_kt,
            'path_foto'      => $file_path   // Menyimpan path file gambar
        );

        $result = $this->global_model->insert('tbl_user', $data);
        if ($result) {
            echo json_encode(array('message' => 'Save Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    function saveItem()
    {
        // Mengambil input dari form
        $kode_barang        = $this->input->post('kode_barang', TRUE);
        $category           = $this->input->post('category', TRUE);
        $inisial_kuantitas  = $this->input->post('inisial_kuantitas', TRUE);
        $level_1            = $this->input->post('level_1', TRUE);
        $level_2            = $this->input->post('level_2', TRUE);
        $level_3            = $this->input->post('level_3', TRUE);
        $level_4            = $this->input->post('level_4', TRUE);
        $remark             = $this->input->post('remark', TRUE);

        // Validasi input (jika diperlukan)
        if (empty($kode_barang) || empty($category) || empty($level_1)) {
            echo json_encode(array('errorMsg' => 'Pastikan semua field yang diperlukan telah terisi.'));
            return;
        }

        // Konfigurasi upload file
        $config['upload_path'] = './uploads/foto-items';  // Direktori upload
        $config['allowed_types'] = 'jpg|jpeg|png';  // Tipe file yang diizinkan
        $config['max_size'] = 200;  // Batas ukuran file dalam KB

        // Menggunakan kode_barang sebagai nama file
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);  // Mendapatkan ekstensi file
        $config['file_name'] = $kode_barang . '.' . $ext;  // Nama file sesuai dengan kode_barang

        $this->load->library('upload', $config);

        // Variabel untuk menyimpan nama dan path file
        $file_name = null;
        $file_path = null;

        // Cek apakah ada file yang diupload
        if (!empty($_FILES['foto']['name'])) {  // Hanya upload jika ada file foto
            if ($this->upload->do_upload('foto')) {
                $uploadData = $this->upload->data();
                $file_name = $uploadData['file_name'];  // Mendapatkan nama file yang di-upload
                $file_path = base_url('uploads/foto-items/') . $file_name;  // Path relatif file yang di-upload
            } else {
                // Jika ada file namun gagal upload, tampilkan pesan error
                $error = $this->upload->display_errors();
                echo json_encode(array('errorMsg' => 'Upload gagal: ' . $error));
                return;
            }
        }

        // Data yang akan disimpan ke database
        $data = array(
            'kode_barang'       => $kode_barang,
            'category'          => $category,
            'inisial_kuantitas' => $inisial_kuantitas,
            'level_1'           => $level_1,
            'level_2'           => $level_2,
            'level_3'           => $level_3,
            'level_4'           => $level_4,
            'remark'            => $remark,
        );

        // Hanya tambahkan path_foto jika ada file yang berhasil diupload
        if ($file_path) {
            $data['path_foto'] = $file_path;
        }

        // Simpan ke database
        $result = $this->global_model->insert('wh_items', $data);

        // Cek hasil penyimpanan
        if ($result) {
            echo json_encode(array('message' => 'Save Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat menyimpan data.'));
        }
    }












    function updateItem()
    {
        $kode_barang        = $this->input->post('kode_barang', TRUE);
        $category           = $this->input->post('category', TRUE);
        $inisial_kuantitas  = $this->input->post('inisial_kuantitas', TRUE);
        $level_1            = $this->input->post('level_1', TRUE);
        $level_2            = $this->input->post('level_2', TRUE);
        $level_3            = $this->input->post('level_3', TRUE);
        $level_4            = $this->input->post('level_4', TRUE);
        $remark             = $this->input->post('remark', TRUE);

        // Ambil data item berdasarkan ID
        $item_id = $this->input->get('id');
        $current_item = $this->global_model->get_by_id('wh_items', array('id' => $item_id));

        if (!$current_item) {
            echo json_encode(array('errorMsg' => 'Item tidak ditemukan.'));
            return;
        }

        // Konfigurasi upload file
        $config['upload_path'] = './uploads/foto-items';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 200; // 200KB

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = $kode_barang . '.' . $ext;

        $this->load->library('upload', $config);

        // Inisialisasi file foto
        $file_name = null;
        $file_path = null;

        // Cek apakah ada file foto baru yang diunggah
        if (!empty($_FILES['foto']['name'])) {
            // Jika ada, hapus foto lama
            if ($current_item->path_foto && file_exists('./uploads/foto-items/' . basename($current_item->path_foto))) {
                unlink('./uploads/foto-items/' . basename($current_item->path_foto));
            }

            // Proses upload foto baru
            if ($this->upload->do_upload('foto')) {
                $uploadData = $this->upload->data();
                $file_name = $uploadData['file_name'];
                $file_path = base_url('uploads/foto-items/') . $file_name;  // Path baru untuk gambar yang di-upload
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(array('errorMsg' => 'Upload gagal: ' . $error));
                return;
            }
        }

        // Buat array data untuk update
        $data = array(
            'kode_barang'       => $kode_barang,
            'category'          => $category,
            'inisial_kuantitas' => $inisial_kuantitas,
            'level_1'           => $level_1,
            'level_2'           => $level_2,
            'level_3'           => $level_3,
            'level_4'           => $level_4,
            'remark'            => $remark
        );

        // Jika file foto diunggah, tambahkan path foto baru ke data update
        if ($file_path) {
            $data['path_foto'] = $file_path;
        }

        // Update data item
        $where = array('id' => $item_id);
        $result = $this->global_model->update('wh_items', $data, $where);

        if ($result) {
            echo json_encode(array('message' => 'Update Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occurred.'));
        }
    }

    function getUsers()
    {
        $this->output->set_content_type('application/json');
        $users = $this->backend_model->getUsers();
        echo json_encode($users);
    }
    function aktifUsers()
    {
        $id = $this->input->post('id');
        $rows = $this->db->get_where('tbl_user', array('_id' => $id))->row_array();
        if ($rows['is_aktif'] == 0) {
            $aktif = "1";
        } else {
            $aktif = "0";
        }
        $result = $this->global_model->update('tbl_user', array('is_aktif' => $aktif), array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'User ' . $rows['nama'] . ' Aktif or Non Aktif Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    function delete_item()
    {
        $id = $this->input->post('id');
        $rows = $this->db->get_where('wh_items', array('id' => $id))->row_array();
        if ($rows['is_deleted'] == 0) {
            $aktif = "1";
        } else {
            $aktif = "0";
        }
        $result = $this->global_model->update('wh_items', array('is_deleted' => $aktif), array('id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Item ' . $rows['kode_barang'] . ' Delete Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }



    function updateUsers()
    {
        $nik               = $this->input->post('nik', TRUE);
        $password       = $this->input->post('password', TRUE);
        $options        = array("cost" => 4);
        $hashPassword    = password_hash($password, PASSWORD_BCRYPT, $options);
        $nama           = $this->input->post('nama', TRUE);
        $jk              = $this->input->post('jk', TRUE);
        $tempat         = $this->input->post('tempat_lahir', TRUE);
        $tgl_l          = $this->input->post('tgl_lahir', TRUE);
        $tgl_g            = $this->input->post('tgl_masuk', TRUE);
        $posisi           = $this->input->post('posisi', TRUE);
        $alamat           = $this->input->post('alamat', TRUE);
        if ($password == '') {
            $data = array(
                'nik'            => $nik,
                'nama'            => $nama,
                'jk'            => $jk,
                'tempat_lahir'    => $tempat,
                'posisi'        => $posisi,
                'alamat'        => $alamat,
                'tgl_lahir'        => $tgl_l,
                'tgl_masuk'        => $tgl_g,
            );
        } else {
            $data = array(
                'nik'            => $nik,
                'password'        => $hashPassword,
                'nama'            => $nama,
                'jk'            => $jk,
                'tempat_lahir'    => $tempat,
                'posisi'        => $posisi,
                'alamat'        => $alamat,
                'tgl_lahir'        => $tgl_l,
                'tgl_masuk'        => $tgl_g,
            );
        }
        $where = array('_id' => $this->input->get('id'));
        $result = $this->global_model->update('tbl_user', $data, $where);
        if ($result) {
            echo json_encode(array('message' => 'Update Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }





    function destroyUsers()
    {
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_user', array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    //end list pegawai//


    //management - items
    function PO()
    {
        $data['title']  = 'Items Managements';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/PO', $data);
    }


    function getPO()
    {
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getPO();
        echo json_encode($stock);
    }

    public function getComboSupplier()
    {

        $this->db->select('id,nama');
        $this->db->from('tbl_supplier');
        $query = $this->db->get();
        $result = $query->result();
        echo json_encode($result);
    }

    public function savePO()
    {
        // Mengambil input dari form
        $po_number        = $this->input->post('po_number', TRUE);
        $Supplier_id      = $this->input->post('id_sup', TRUE);
        $expeted_date     = $this->input->post('expeted_date', TRUE);
        $total_amount     = $this->input->post('total_amount', TRUE);
        $status           = $this->input->post('status', TRUE);
        $po_date          = $this->input->post('po_date', TRUE);
        $po_description   = $this->input->post('po_description', TRUE);
        $item_description = $this->input->post('item_description', TRUE);

        // Validasi input (jika diperlukan)
        if (empty($po_number) || empty($Supplier_id) || empty($expeted_date)) {
            echo json_encode(array('errorMsg' => 'Pastikan semua field yang diperlukan telah terisi.'));
            return;
        }

        // Konfigurasi upload file
        $config['upload_path'] = './uploads/po-files';  // Direktori upload
        $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';  // Tipe file yang diizinkan
        $config['max_size'] = 1024;  // Batas ukuran file dalam KB

        // Menggunakan po_number sebagai nama file
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);  // Mendapatkan ekstensi file
        $config['file_name'] = $po_number . '.' . $ext;  // Nama file sesuai dengan po_number

        $this->load->library('upload', $config);

        // Variabel untuk menyimpan nama dan path file
        $file_name = null;
        $file_path = null;

        // Cek apakah ada file yang diupload
        if (!empty($_FILES['file']['name'])) {  // Hanya upload jika ada file
            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $file_name = $uploadData['file_name'];  // Mendapatkan nama file yang di-upload
                $file_path = base_url('uploads/po-files/') . $file_name;  // Path relatif file yang di-upload
            } else {
                // Jika ada file namun gagal upload, tampilkan pesan error
                $error = $this->upload->display_errors();
                echo json_encode(array('errorMsg' => 'Upload gagal: ' . $error));
                return;
            }
        }

        // Data yang akan disimpan ke database
        $data = array(
            'po_number'       => $po_number,
            'Supplier_id'     => $Supplier_id,
            'expeted_date'    => $expeted_date,
            'total_amount'    => $total_amount,
            'status'          => $status,
            'po_date'         => $po_date,
            'po_description'  => $po_description,
            'item_description' => $item_description,
        );

        // Hanya tambahkan file jika ada file yang berhasil diupload
        if ($file_path) {
            $data['file'] = $file_path;
        }

        // Simpan ke database
        $result = $this->global_model->insert('tbl_po', $data);

        // Cek hasil penyimpanan
        if ($result) {
            echo json_encode(array('message' => 'Purchase Order berhasil disimpan.'));
        } else {
            echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat menyimpan data.'));
        }
    }





    function stock()
    {
        $data['title']  = 'Items Managements';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/items-management', $data);
    }

    function getstock()
    {
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getStock();
        echo json_encode($stock);
    }

    function supplier()
    {
        $data['title']  = 'Supplier';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/supplier', $data);
    }

    function deleteSupplier()
    {
        // Mendapatkan ID supplier yang akan dihapus
        $id_supplier = $this->input->post('id', TRUE);

        // Melakukan penghapusan data supplier berdasarkan ID
        $result = $this->global_model->delete('tbl_supplier', array('id' => $id_supplier));

        // Mengembalikan hasil operasi ke dalam bentuk JSON
        if ($result) {
            echo json_encode(array('message' => 'Supplier berhasil dihapus'));
        } else {
            echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat menghapus Supplier'));
        }
    }


    function getsupplier()
    {
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getSupplier();
        echo json_encode($stock);
    }

    function saveSupplier()
    {
        // Mendapatkan input dari form
        $nama_supplier = $this->input->post('nama', TRUE);
        $PIC_name = $this->input->post('PIC_name', TRUE);
        $email = $this->input->post('email', TRUE);
        $phone = $this->input->post('phone', TRUE);
        $address = $this->input->post('address', TRUE);
        $bank_account = $this->input->post('bank_account', TRUE);
        $rek_bank = $this->input->post('rek_bank', TRUE);
        $tax = $this->input->post('tax', TRUE);
        $status = $this->input->post('status', TRUE);

        // Menyiapkan data untuk disimpan
        $data = array(
            'nama'         => $nama_supplier,
            'PIC_name'     => $PIC_name,
            'email'        => $email,
            'phone'        => $phone,
            'address'      => $address,
            'bank_account' => $bank_account,
            'rek_bank'     => $rek_bank,
            'tax'          => $tax,
            'status'       => $status,
            'created_at'   => date('Y-m-d H:i:s') // Menambahkan timestamp untuk created_at
        );

        // Insert data ke dalam database
        $result = $this->global_model->insert('tbl_supplier', $data);

        // Mengembalikan hasil operasi ke dalam bentuk JSON
        if ($result) {
            echo json_encode(array('message' => 'Supplier berhasil disimpan'));
        } else {
            echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat menyimpan supplier'));
        }
    }

    // function saveFileShared() {
    //     // Mendapatkan input dari form
    //     $level1 = $this->input->post('level1', TRUE);
    //     $file_name = $this->input->post('file_name', TRUE);
    //     $file_size = $this->input->post('size', TRUE);
    //     $type_file = $this->input->post('type_file', TRUE);
    //     $link = $this->input->post('link', TRUE);
    //     $remark = $this->input->post('remark', TRUE);

    //     // Menyiapkan data untuk disimpan
    //     $data = array(
    //         'level1'         => $level1,
    //         'name_file'      => $file_name,
    //         'size'           => $file_size,
    //         'type_file'      => $type_file,
    //         'link'           => $link,
    //         'remark'         => $remark,

    //     );

    //     // Insert data ke dalam database
    //     $result = $this->global_model->insert('file_shared', $data);

    //     // Mengembalikan hasil operasi ke dalam bentuk JSON
    //     if ($result) {
    //         echo json_encode(array('message' => 'Supplier berhasil disimpan'));
    //     } else {
    //         echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat menyimpan supplier'));
    //     }
    // }


    public function saveFileShared()
    {


        // Konfigurasi upload file
        $config['upload_path'] = './fileshared';
        $config['allowed_types'] = '*'; // Bisa diatur sesuai kebutuhan
        $config['max_size'] = 2097152; // Maksimal ukuran file dalam KB (2 GB)
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            // Jika gagal upload, kirimkan pesan error
            echo json_encode(array('errorMsg' => $this->upload->display_errors('', '')));
            return;
        }

        // Ambil informasi file yang diunggah
        $uploadData = $this->upload->data();

        // Data yang akan disimpan ke database
        $data = array(
            'level1'     => $this->input->post('level1', TRUE),
            'description'     => $this->input->post('description', TRUE),
            'name_file'  => $this->input->post('file_name', TRUE),
            'size'       => $this->input->post('size', TRUE),
            'type_file'  => $this->input->post('type_file', TRUE),
            'link'       => base_url('fileshared/' . $uploadData['file_name']), // URL lengkap
            'remark'     => $this->input->post('remark', TRUE),
            'upload_date' => date('Y-m-d H:i:s'),
        );

        // Insert data ke dalam database
        $result = $this->global_model->insert('file_shared', $data);

        // Respon operasi
        if ($result) {
            echo json_encode(array('message' => 'File berhasil diunggah dan disimpan.'));
        } else {
            echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat menyimpan file.'));
        }
    }

    public function saveFileShared_link()
    {
       


        // Data yang akan disimpan ke database
        $data = array(
            'level1'     => $this->input->post('level_1_link', TRUE),
            'description'     => $this->input->post('description_link', TRUE),
            'name_file'  => $this->input->post('name_file_link', TRUE),
            'type_file'  => $this->input->post('type_file_link', TRUE),
            'link'       => $this->input->post('link_link', TRUE),
            'remark'     => $this->input->post('remark_link', TRUE),
            'upload_date' => date('Y-m-d H:i:s'),
        );

        // Insert data ke dalam database
        $result = $this->global_model->insert('file_shared', $data);

        // Respon operasi
        if ($result) {
            echo json_encode(array('message' => 'File berhasil diunggah dan disimpan.'));
        } else {
            echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat menyimpan file.'));
        }
    }


    function getSubMenus2($id, $is_main)
    {
        $this->db->from('tbl_menus');
        $this->db->join('tbl_levels', 'tbl_menus._id=tbl_levels.id_menu');
        $this->db->where('is_aktif', 1);
        $this->db->where('tbl_levels.id_posisi', $id);
        $this->db->where('tbl_menus.is_main', $is_main);
        return $this->db->get();
    }

    function updateFileshare()
    {
        // Mendapatkan input dari form
        $id = $this->input->get('id', TRUE);
        $level1 = $this->input->post('level1', TRUE);
        $file_name = $this->input->post('file_name', TRUE);
        $file_size = $this->input->post('size', TRUE);
        $type_file = $this->input->post('type_file', TRUE);
        $link = $this->input->post('link', TRUE);
        $remark = $this->input->post('remark', TRUE);


        // Menyiapkan data untuk diupdate
        $data = array(
            'level1'    => $level1,
            'name_file'     => $file_name,
            'size'        => $file_size,
            'type_file'        => $type_file,
            'link'      => $link,
            'remark' => $remark,
            'upload_date'    => date('Y-m-d')
        );

        // Menentukan kondisi WHERE untuk mengupdate data berdasarkan ID supplier
        $where = array('id' => $id);

        // Melakukan update data di database
        $result = $this->global_model->update('file_shared', $data, $where);

        // Mengembalikan hasil operasi ke dalam bentuk JSON
        if ($result) {
            echo json_encode(array('message' => 'Update Supplier berhasil'));
        } else {
            echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat mengupdate Supplier'));
        }
    }

    function deletefileShared()
    {
        // Mendapatkan ID supplier yang akan dihapus
        $id = $this->input->post('id', TRUE);

        // Melakukan penghapusan data supplier berdasarkan ID
        $result = $this->global_model->delete('file_shared', array('id' => $id));

        // Mengembalikan hasil operasi ke dalam bentuk JSON
        if ($result) {
            echo json_encode(array('message' => 'Supplier berhasil dihapus'));
        } else {
            echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat menghapus Supplier'));
        }
    }



    function updateSupplier()
    {
        // Mendapatkan input dari form
        $id_supplier = $this->input->get('id', TRUE); // Mengambil ID supplier yang akan diupdate
        $nama_supplier = $this->input->post('nama', TRUE);
        $PIC_name = $this->input->post('PIC_name', TRUE);
        $email = $this->input->post('email', TRUE);
        $phone = $this->input->post('phone', TRUE);
        $address = $this->input->post('address', TRUE);
        $bank_account = $this->input->post('bank_account', TRUE);
        $rek_bank = $this->input->post('rek_bank', TRUE);
        $tax = $this->input->post('tax', TRUE);
        $status = $this->input->post('status', TRUE);

        // Menyiapkan data untuk diupdate
        $data = array(
            'nama'         => $nama_supplier,
            'PIC_name'     => $PIC_name,
            'email'        => $email,
            'phone'        => $phone,
            'address'      => $address,
            'bank_account' => $bank_account,
            'rek_bank'     => $rek_bank,
            'tax'          => $tax,
            'status'       => $status,
            'update_at'    => date('Y-m-d H:i:s') // Menambahkan timestamp untuk update_at
        );

        // Menentukan kondisi WHERE untuk mengupdate data berdasarkan ID supplier
        $where = array('id' => $id_supplier);

        // Melakukan update data di database
        $result = $this->global_model->update('tbl_supplier', $data, $where);

        // Mengembalikan hasil operasi ke dalam bentuk JSON
        if ($result) {
            echo json_encode(array('message' => 'Update Supplier berhasil'));
        } else {
            echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat mengupdate Supplier'));
        }
    }





    public function stock_details($id)
    {
        $data['title']  = 'Items Managements';
        $data['collapsed'] = '';

        // Mengirimkan id ke view
        $data['item_id'] = $id;

        // Menambahkan CSS dan JS Files
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';

        // Memuat view dan mengirimkan data
        $this->template->load('template', 'master/items-management-details', $data);
    }



    public function getstock_details($id)
    {
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getStockdetails($id); // Mengirimkan id ke model
        echo json_encode($stock);
    }


    public function setitem($id)
    {
        $data['title']  = 'Set Item 1';
        $data['collapsed'] = '';

        // Mengirimkan id ke view
        $data['id_barang'] = $id;

        // Menambahkan CSS dan JS Files
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';

        // Memuat view dan mengirimkan data
        $this->template->load('template', 'master/items-management-set', $data);
    }

    public function setitem2()
    {
        $data['title']  = 'Set Item 2';
        $data['collapsed'] = '';




        // Menambahkan CSS dan JS Files
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';

        // Memuat view dan mengirimkan data
        $this->template->load('template', 'master/items-management-set2', $data);
    }

    public function getsetitem($id)
    {
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getSetItem($id); // Mengirimkan id ke model
        echo json_encode($stock);
    }

    public function getsetitem2()
    {
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getSetItem2(); // Mengirimkan id ke model
        echo json_encode($stock);
    }


    function saveItemSet()
    {
        // Mengambil input dari form
        $kode_barang        = $this->input->post('item_id', TRUE);
        $category           = $this->input->post('name', TRUE);
        $inisial_kuantitas  = $this->input->post('qty', TRUE);
        $level_1            = $this->input->post('status', TRUE);
        $level_2            = $this->input->post('remark', TRUE);


        echo json_encode(array('message' => 'Teset'));

        // Validasi input (jika diperlukan)
        if (empty($kode_barang) || empty($category) || empty($level_1)) {
            echo json_encode(array('errorMsg' => 'Pastikan semua field yang diperlukan telah terisi.'));
            return;
        }

        // Konfigurasi upload file
        $config['upload_path'] = './uploads/foto-items-set';  // Direktori upload
        $config['allowed_types'] = 'jpg|jpeg|png';  // Tipe file yang diizinkan
        $config['max_size'] = 200;  // Batas ukuran file dalam KB

        // Menggunakan kode_barang sebagai nama file
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);  // Mendapatkan ekstensi file
        $config['file_name'] = $kode_barang . '.' . $ext;  // Nama file sesuai dengan kode_barang

        $this->load->library('upload', $config);

        // Variabel untuk menyimpan nama dan path file
        $file_name = null;
        $file_path = null;

        // Cek apakah ada file yang diupload
        if (!empty($_FILES['foto']['name'])) {  // Hanya upload jika ada file foto
            if ($this->upload->do_upload('foto')) {
                $uploadData = $this->upload->data();
                $file_name = $uploadData['file_name'];  // Mendapatkan nama file yang di-upload
                $file_path = base_url('uploads/foto-items-set/') . $file_name;  // Path relatif file yang di-upload
            } else {
                // Jika ada file namun gagal upload, tampilkan pesan error
                $error = $this->upload->display_errors();
                echo json_encode(array('errorMsg' => 'Upload gagal: ' . $error));
                return;
            }
        }

        // Data yang akan disimpan ke database
        $data = array(
            'item_id'       => $kode_barang,
            'name'          => $category,
            'qty' => $inisial_kuantitas,
            'status'           => $level_1,
            'remark'           => $level_2,
        );

        // Hanya tambahkan path_foto jika ada file yang berhasil diupload
        if ($file_path) {
            $data['doc'] = $file_path;
        }

        // Simpan ke database
        $result = $this->global_model->insert('wh_item_set', $data);

        // Cek hasil penyimpanan
        if ($result) {
            echo json_encode(array('message' => 'Save Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Terjadi kesalahan saat menyimpan data.'));
        }
    }





    //wh distribution

    function distribution()
    {
        $data['title']  = 'Distributions Managements';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/wh-distribution', $data);
    }

    function getdistribution()
    {
        $this->output->set_content_type('application/json');
        $stock = $this->backend_model->getDistribution();
        echo json_encode($stock);
    }


















    //list posisi//
    function posisi()
    {
        $data['title']  = 'Data Posisi';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $this->template->load('template', 'master/posisi', $data);
    }


    function getPosisi()
    {
        $this->output->set_content_type('application/json');
        $posisi = $this->backend_model->getPosisi();
        echo json_encode($posisi);
    }



    function savePosisi()
    {
        $posisi = $this->input->post('posisi', TRUE);
        $data = array();
        $data = array(
            'posisi'         => $posisi
        );
        $result = $this->global_model->insert('tbl_posisi', $data);
        if ($result) {
            echo json_encode(array('message' => 'Save Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }











    function updatePosisi()
    {
        $posisi = $this->input->post('posisi', TRUE);
        $data = array();
        $data = array(
            'posisi'         => $posisi
        );
        $where = array('_id' => $this->input->get('id'));
        $result = $this->global_model->update('tbl_posisi', $data, $where);
        if ($result) {
            echo json_encode(array('message' => 'Update Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }




    function destroyPosisi()
    {
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_posisi', array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    //end posisi//
    //end modul user//

    //modul gudang//
    //barang//
    function barang()
    {
        $data['title']  = 'Data Barang';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template', 'master/barang', $data);
    }
    function getBarang()
    {
        $this->output->set_content_type('application/json');
        $barang = $this->backend_model->getBarang();
        echo json_encode($barang);
    }
    function saveBarang()
    {
        $kode = $this->input->post('kode_barang', TRUE);
        $nama = $this->input->post('nama_barang', TRUE);
        $harga = $this->input->post('harga_barang', TRUE);
        $stok = $this->input->post('stok', TRUE);
        $data = array();
        $data = array(
            'kode_barang'         => $kode,
            'nama_barang'         => $nama,
            'harga_barang'         => $harga,
            'stok'         => $stok,
        );
        $result = $this->global_model->insert('tbl_barang', $data);
        if ($result) {
            echo json_encode(array('message' => 'Save Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    function updateBarang()
    {
        $kode = $this->input->post('kode_barang', TRUE);
        $nama = $this->input->post('nama_barang', TRUE);
        $harga = $this->input->post('harga_barang', TRUE);
        $stok = $this->input->post('stok', TRUE);
        $data = array();
        $data = array(
            'kode_barang'         => $kode,
            'nama_barang'         => $nama,
            'harga_barang'         => $harga,
            'stok'         => $stok,
        );
        $where = array('_id' => $this->input->get('id'));
        $result = $this->global_model->update('tbl_barang', $data, $where);
        if ($result) {
            echo json_encode(array('message' => 'Update Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    function destroyBarang()
    {
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_barang', array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    //end barang//
    //barang masuk//
    function barangMasuk()
    {
        $data['title']  = 'Data Barang Masuk';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template', 'master/barangMasuk', $data);
    }
    function isBarang()
    {
        $barang = $this->backend_model->isBarang();
        $this->output->set_content_type('application/json');
        echo json_encode($barang->result());
    }
    function saveBarangMasuk()
    {
        $kode = $this->input->post('kode_faktur', TRUE);
        $id = $this->input->post('kode_barang', TRUE);
        $jumlah = $this->input->post('jumlah', TRUE);
        $tgl = $this->input->post('tgl', TRUE);
        $data = array();
        $data = array(
            'kode_faktur'         => $kode,
            'id_barang'         => $id,
            'jumlah'         => $jumlah,
            'tgl_masuk'         => $tgl,
        );
        $oldData = $this->backend_model->getBarangById($id)->row()->stok;
        $dataUpdate = array();
        $stokBaru = $oldData + $jumlah;
        $dataUpdate = array(
            'stok' => $stokBaru,
        );
        $result = $this->global_model->insert('tbl_barang_masuk', $data);
        if ($result) {
            $where = array('_id' => $id);
            $update = $this->global_model->update('tbl_barang', $dataUpdate, $where);
            if ($update) {
                echo json_encode(array('message' => 'Save Success'));
            } else {
                echo json_encode(array('errorMsg' => 'Gagal Update'));
            }
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    function getBarangMasuk()
    {
        $this->output->set_content_type('application/json');
        $barang = $this->backend_model->getBarangMasuk();
        echo json_encode($barang);
    }
    function editBarangMasuk() {}
    function destroyBarangMasuk()
    {
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_barang_masuk', array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    //end barang masuk//
    //end Modul Gudang//

    //Modul Transaksi//
    // penjualan //
    function penjualan()
    {
        $data['title']  = 'Data Penjualan';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template', 'master/penjualan', $data);
    }
    function getPenjualan()
    {
        $month = date('m');
        $this->output->set_content_type('application/json');
        $barang = $this->backend_model->getPenjualan($month);
        echo json_encode($barang);
    }
    function getDetailPenjualan()
    {
        $data['title']  = 'Data Penjualan';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $detail = $this->backend_model->getDetailPenjualan($this->uri->segment(3))->row();
        $detailTagih = $this->backend_model->getDetailPenagihan($detail->no_faktur);
        $tunggakan = 0;
        if ($detail->status_penjualan != 0) {
            $wajibBayar = $detail->total / $detail->status_penjualan;
            $awalBeli = new DateTime($detail->tgl_transaksi);
            $tgltempo = date('Y') . '-' . date('m') . '-' . $detail->tgl_tempo;
            $skrg = new DateTime($tgltempo);
            $interval = $awalBeli->diff($skrg)->m;
            if (substr($detail->tgl_transaksi, 8, 2) > $detail->tgl_tempo) {
                $interval += 1;
            }
            if (date('d') < $detail->tgl_tempo) {
                $interval -= 1;
            }
            $tunggakan = $wajibBayar * ($interval + 1);
        }
        $data['tunggakan'] = $tunggakan;
        $data['detail'] = $detail;
        $data['detailtagih'] = $detailTagih->result();
        $this->template->load('template', 'master/detailpenjualan', $data);
    }
    function penjualanApprove()
    {
        $data['title']  = 'Data Penjualan';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template', 'master/penjualanapprove', $data);
    }
    function getApprovePenjualan()
    {
        $this->output->set_content_type('application/json');
        $barang = $this->backend_model->getPenjualanApprove();
        echo json_encode($barang);
    }
    function approvePenjualan()
    {
        $id         = $this->input->post('id');
        $idPenagih  = $this->input->post('id_penagih');
        $rows = $this->db->get_where('tbl_penjualan', array('_id' => $id))->row();
        $id_barang = $rows->id_barang;
        $status = $rows->status_penjualan;
        $tgl = $rows->tgl_transaksi;
        //
        $barang = $this->backend_model->getBarangById($id_barang)->row();
        $bayar = "0";
        $total = $barang->harga_barang;
        if ($status == 0) {
            $tempo = 0;
            $dataPenagihan = array(
                'kode_bayar'        => $rows->no_faktur . '-1',
                'no_faktur'         => $rows->no_faktur,
                'total_bayar'       => $total,
                'tgl_bayar'         => $tgl,
                'id_user'           => $rows->id_user,
                'status'            => '1',
            );
            $isTagih = $this->global_model->insert('tbl_penagihan', $dataPenagihan);
            if (!$isTagih) {
                echo json_encode(array('errorMsg' => 'Error Penagihan.'));
            }
        } else {
            $totalTagih = $total / $status;
            $dataPenagihan = array(
                'kode_bayar'        => $rows->no_faktur . '-1',
                'no_faktur'       => $rows->no_faktur,
                'total_bayar'       => $totalTagih,
                'tgl_bayar'         => $tgl,
                'id_user'        => $rows->id_user,
                'status'            => '1',
            );
            $isTagih = $this->global_model->insert('tbl_penagihan', $dataPenagihan);
            if (!$isTagih) {
                echo json_encode(array('errorMsg' => 'Error Penagihan.'));
            }
            $tempo = $rows->tgl_tempo;
            $bayar = "1";
        }
        $stokLama = $barang->stok;
        $dataStok = array();
        $stokBaru = $stokLama - 1;
        $dataStok = array(
            'stok' => $stokBaru,
        );
        $where = array('_id' => $id_barang);
        $update = $this->global_model->update('tbl_barang', $dataStok, $where);
        if (!$update) {
            echo json_encode(array('errorMsg' => 'Error Update Stok.'));
        }
        //
        if ($rows->status_approve == '0') {
            $approve = '1';
        } else {
            $approve = '0';
        }
        $data = array();
        $data = array(
            'status_penjualan'  => $status,
            'status_bayar'      => $bayar,
            'tgl_tempo'         => $tempo,
            'status_approve'    => $approve,
            'id_penagih'        => $idPenagih
        );
        $result = $this->global_model->update('tbl_penjualan', $data, array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Faktur ' . $rows->no_faktur . ' Approve Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    function updatePenjualan()
    {
        $id = $this->input->get('id');
        $data = array();
        $data = array(
            'nama_pembeli'      => $this->input->post('nama_pembeli'),
            'alamat'            => $this->input->post('alamat_pembeli'),
            'no_telp'           => $this->input->post('no_tlfn'),
            'tgl_transaksi'     => $this->input->post('tgl_jual'),
            'tgl_tempo'         => $this->input->post('tgl_tempo'),
        );
        $result = $this->global_model->update('tbl_penjualan', $data, array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Update Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    function savePenjualan()
    {
        $kode = $this->input->post('kode_faktur', TRUE);
        $nama = $this->input->post('nama_pembeli', TRUE);
        $alamat = $this->input->post('alamat_pembeli', TRUE);
        $tlfn = $this->input->post('no_tlfn', TRUE);
        $id_barang = $this->input->post('id_barang', TRUE);
        $status = $this->input->post('status_penjualan', TRUE);
        $idSales = $this->session->_id;
        $tgl = $this->input->post('tgl_jual', TRUE);
        $tempo = $this->input->post('tgl_tempo');
        $barang = $this->backend_model->getBarangById($id_barang)->row();
        $bayar = "0";
        $total = $barang->harga_barang;
        //dont touch
        // if($status == 0){
        //     $tempo = 0;
        //     $dataPenagihan = array(
        //         'kode_bayar'        => $kode . '-1',
        //         'no_faktur'       => $kode,
        //         'total_bayar'       => $total,
        //         'tgl_bayar'         => $tgl,
        //         'id_user'        => $idSales,
        //     );
        //     $isTagih = $this->global_model->insert('tbl_penagihan',$dataPenagihan);
        //     if(!$isTagih){
        //         echo json_encode(array('errorMsg'=>'Error Penagihan.'));
        //     }
        // }else{
        //     $totalTagih = $total/$status;
        //     $dataPenagihan = array(
        //         'kode_bayar'        => $kode . '-1',
        //         'no_faktur'       => $kode,
        //         'total_bayar'       => $totalTagih,
        //         'tgl_bayar'         => $tgl,
        //         'id_user'        => $idSales,
        //     );
        //     $isTagih = $this->global_model->insert('tbl_penagihan',$dataPenagihan);
        //     if(!$isTagih){
        //         echo json_encode(array('errorMsg'=>'Error Penagihan.'));
        //     }
        //     $tempo = $this->input->post('tgl_tempo');
        //     $bayar = "1";
        // }
        // $stokLama = $barang->stok;
        // $dataStok = array();
        // $stokBaru = $stokLama-1;
        // $dataStok = array(
        //     'stok' => $stokBaru,
        // );
        // $where = array('_id'=>$id_barang);
        // $update = $this->global_model->update('tbl_barang',$dataStok, $where);
        // if(!$update){
        //     echo json_encode(array('errorMsg'=>'Error Update Stok.'));
        // }
        //-----///
        $data = array();
        $data = array(
            'no_faktur'         => $kode,
            'nama_pembeli'      => $nama,
            'alamat'            => $alamat,
            'no_telp'           => $tlfn,
            'tgl_transaksi'     => $tgl,
            'id_barang'         => $id_barang,
            'id_user'           => $idSales,
            'status_penjualan'  => $status,
            'status_bayar'      => $bayar,
            'tgl_tempo'         => $tempo,
            'total'             => $total
        );
        $result = $this->global_model->insert('tbl_penjualan', $data);
        if ($result) {
            echo json_encode(array('message' => 'Save Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    function saveCatatanPenjualan()
    {
        $idPenjualan = $this->input->get('id');
        $catatan = $this->input->post('catatan');
        $data = array(
            'id_penjualan'  => $idPenjualan,
            'catatan'       => $catatan
        );
        $result = $this->global_model->insert('tbl_catatan', $data);
        if ($result) {
            echo json_encode(array('message' => 'Save Catatan Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    function isKodePenjualan()
    {
        $this->output->set_content_type('application/json');
        $barang = $this->backend_model->getPenjualanKredit();
        echo json_encode($barang->result());
    }
    // end penjualan
    // penagihan
    function penagihan()
    {
        $data['title']  = 'Data Penagihan';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template', 'master/penagihan', $data);
    }
    function getPenagihan()
    {
        $this->output->set_content_type('application/json');
        $barang = $this->backend_model->getPenagihan();
        echo json_encode($barang);
    }
    function destroyPenagihan()
    {
        $id = $this->input->post('id');
        $result = $this->global_model->delete('tbl_penagihan', array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Deleted Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    function editPenagihan() {}
    function savePenagihan()
    {
        $kode = $this->input->get('kode', TRUE);
        $total = $this->input->post('total_bayar', TRUE);
        $tgl_bayar = $this->input->post('tgl_bayar', TRUE);
        $kaliBayar = $this->backend_model->getTotalBayar($kode);
        $kodeBaru = $kode . '-' . (($kaliBayar->num_rows()) + 1);
        $id = 1;
        $data = array(
            'kode_bayar'    => $kodeBaru,
            'no_faktur'     => $kode,
            'total_bayar'   => $total,
            'tgl_bayar'     => $tgl_bayar,
            'id_user'       => $id,
        );
        $result = $this->global_model->insert('tbl_penagihan', $data);
        if ($result) {
            echo json_encode(array('message' => 'Save Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    //end penagihan
    //end modul transaksi

    //Modul Laporan
    //end modul laporan

    //modul approval//
    //approve penjualan//

    function isPenagih()
    {
        $this->output->set_content_type('application/json');
        $data = $this->backend_model->getIsPenagih();
        echo json_encode($data);
    }
    function gantiPenagih()
    {
        $id         = $this->input->get('id');
        $idPenagih  = $this->input->post('id_kolektor');
        $result     = $this->global_model->update('tbl_penjualan', array('id_penagih' => $idPenagih), array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Ganti Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    function inputTagihan()
    {
        $data['title']  = 'Data Penjualan';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template', 'master/inputtagihan', $data);
    }
    function penagihanApprove()
    {
        $data['title']  = 'Data Penjualan';
        $data['collapsed'] = '';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/material/easyui.css';
        $data['css_files'][] = base_url() . 'assets/admin/easyui/themes/icon.css';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/jquery.easyui.min.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/datagrid-groupview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/easyui/plugins/datagrid-scrollview.js';
        $data['js_files'][] = base_url() . 'assets/admin/plugins/accounting/accounting.min.js';
        $this->template->load('template', 'master/penagihanapprove', $data);
    }
    function getApprovePenagihan()
    {
        $this->output->set_content_type('application/json');
        $data = $this->backend_model->getApprovePenagihan();
        echo json_encode($data);
    }
    function approvePenagihan()
    {
        $id         = $this->input->post('id');
        $rows       = $this->db->get_where('tbl_penagihan', array('_id' => $id))->row_array();
        if ($rows['status'] == '0') {
            $approve = '1';
        } else {
            $approve = '0';
        }
        $result = $this->global_model->update('tbl_penagihan', array('status' => $approve,), array('_id' => $id));
        if ($result) {
            echo json_encode(array('message' => 'Faktur ' . $rows['no_faktur'] . ' Approve Success'));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
    function getFakturTagihan()
    {
        $month = date('m');
        $id = $this->session->_id;
        $posisi = $this->session->posisi;
        if ($posisi == 6) {
            $data = $this->backend_model->getFakturTagihanById($month, $id);
        } else {
            $data = $this->backend_model->getFakturTagihan($month);
        }
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
}
