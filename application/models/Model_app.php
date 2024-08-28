<?php
class Model_app extends CI_model
{
    public function view($table)
    {
        return $this->db->get($table);
    }

    public function insert($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function edit($table, $data)
    {
        return $this->db->get_where($table, $data);
    }

    public function update($table, $data, $where)
    {
        return $this->db->update($table, $data, $where);
    }

    public function delete($table, $where)
    {
        return $this->db->delete($table, $where);
    }

    public function view_where($table, $data)
    {
        $this->db->where($data);
        return $this->db->get($table);
    }

    public function view_ordering_limit($table, $order, $ordering, $baris, $dari)
    {
        $this->db->select('*');
        $this->db->order_by($order, $ordering);
        $this->db->limit($dari, $baris);
        return $this->db->get($table);
    }

    public function view_where_ordering_limit($table, $data, $order, $ordering, $baris, $dari)
    {
        $this->db->select('*');
        $this->db->where($data);
        $this->db->order_by($order, $ordering);
        $this->db->limit($dari, $baris);
        return $this->db->get($table);
    }

    public function view_ordering($table, $order, $ordering)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order, $ordering);
        return $this->db->get()->result_array();
    }

    public function view_where_ordering($table, $data, $order, $ordering)
    {
        $this->db->where($data);
        $this->db->order_by($order, $ordering);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function view_join_one($table1, $table2, $field, $order, $ordering)
    {
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1 . '.' . $field . '=' . $table2 . '.' . $field);
        $this->db->order_by($order, $ordering);
        return $this->db->get()->result_array();
    }

    public function view_join_where($table1, $table2, $field, $where, $order, $ordering)
    {
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1 . '.' . $field . '=' . $table2 . '.' . $field);
        $this->db->where($where);
        $this->db->order_by($order, $ordering);
        return $this->db->get()->result_array();
    }

    function umenu_akses($link, $id)
    {
        return $this->db->query("SELECT * FROM modul,users_modul WHERE modul.id_modul=users_modul.id_modul AND users_modul.id_session='$id' AND modul.link='$link'")->num_rows();
    }

    public function cek_login($username, $password, $table)
    {
        // echo "SELECT * FROM $table where username='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."' AND blokir='N'";
        return $this->db->query("SELECT * FROM $table where username='" . $this->db->escape_str($username) . "' AND password='" . $this->db->escape_str($password) . "' AND blokir='N'");
    }

    public function cek_login_users($username, $password, $table)
    {
        return $this->db->query("SELECT * FROM $table where username='" . $this->db->escape_str($username) . "' AND password='" . $this->db->escape_str($password) . "'");
    }

    function grafik_kunjungan()
    {
        return $this->db->query("SELECT count(*) as jumlah, tanggal FROM statistik GROUP BY tanggal ORDER BY tanggal DESC LIMIT 10");
    }

    // Tambahan 
    function last_user_id()
    {
        return $this->db->query("SELECT MAX(id) id FROM users");
    }

    // Pemda
    public function xhrRefPemda($data)
    {
        $search = $data['search'];
        $ref = $data['ref'];
        $data['ref'] = $ref;

        if ($ref === 'provinsi') {
            $data['res'] = $this->db->query("SELECT id, provinsi FROM ref_provinsi WHERE provinsi LIKE '%$search%' ORDER BY provinsi ASC")->result_array();
            return $data;
        } else if ($ref === 'kabupaten') {
            $provinsi = $data['provinsi'];
            $data['res'] = $this->db->query("SELECT id, kabupaten FROM ref_kabupaten WHERE provinsi_id = '$provinsi' AND kabupaten LIKE '%$search%' ORDER BY kabupaten ASC")->result_array();
            return $data;
        } else if ($ref === 'kecamatan') {
            $kabupaten = $data['kabupaten'];
            $data['res'] = $this->db->query("SELECT id, kecamatan FROM ref_kecamatan WHERE kabupaten_id = '$kabupaten' AND kecamatan LIKE '%$search%' ORDER BY kecamatan ASC")->result_array();
            return $data;
        } else if ($ref === 'kelurahan') {
            $kabupaten = $data['kabupaten'];
            $kecamatan = $data['kecamatan'];
            $data['res'] = $this->db->query("SELECT id, kelurahan FROM ref_kelurahan WHERE kabupaten_id = '$kabupaten' AND kecamatan_id = '$kecamatan' AND kelurahan LIKE '%$search%' ORDER BY kelurahan ASC")->result_array();
            return $data;
        } else {
            return array();
        }
    }

    public function xhrMyKlinik($data)
    {
        $user_id = $data['user_id'];
        $data['res'] = $this->db->query("SELECT b.klinik_id id, b.klinik FROM users a INNER JOIN v_klinik b ON a.klinik_id = b.klinik_id WHERE a.user_id = '$user_id'")->result_array();
        return $data;
    }

    public function xhrLayanan($data)
    {
        $search = $data['search'];
        if (!empty($search)) {
            $data['res'] = $this->db->query("SELECT id_kategori_layanan id, nama_kategori_layanan layanan 
            FROM kategori_layanan WHERE nama_kategori_layanan LIKE '%$search%' 
            ORDER BY nama_kategori_layanan ASC")->result_array();
            return $data;
        } else {
            $data['res'] = $this->db->query("SELECT id_kategori_layanan id, nama_kategori_layanan layanan 
            FROM kategori_layanan ORDER BY nama_kategori_layanan ASC")->result_array();
            return $data;
        }
    }

    public function getLayanan($data)
    {
        $d = $this->db->query("SELECT * FROM kategori_layanan WHERE id_kategori_layanan IN ('$data')");
        return $d;
    }

    public function xhrKlinik($data)
    {
        $search = $data['search'];
        $ref = $data['ref'];
        $pro = $data['provinsi'];
        $kab = $data['kabupaten'];
        $kec = $data['kecamatan'];
        $kel = $data['kelurahan'];

        // 1
        if (!empty($pro) && !empty($kab) && !empty($kec) && !empty($kec)) {
            if (!empty($search)) {
                $data['res'] = $this->db->query("SELECT klinik_id id, klinik FROM v_klinik WHERE 
                    provinsi_id = '$pro' AND 
                    kabupaten_id = '$kab' AND 
                    kecamatan_id = '$kec' AND 
                    kelurahan_id = '$kel' AND 
                    klinik LIKE '%$search%' 
                ORDER BY klinik ASC")->result_array();
                return $data;
            } else {
                $data['res'] = $this->db->query("SELECT klinik_id id, klinik FROM v_klinik WHERE 
                    provinsi_id = '$pro' AND 
                    kabupaten_id = '$kab' AND 
                    kecamatan_id = '$kec' AND 
                    kelurahan_id = '$kel'
                ORDER BY klinik ASC")->result_array();
                return $data;
            }
        }

        // 2
        if (!empty($pro) && !empty($kab) && !empty($kec)) {
            if (!empty($search)) {
                $data['res'] = $this->db->query("SELECT klinik_id id, klinik FROM v_klinik WHERE 
                    provinsi_id = '$pro' AND 
                    kabupaten_id = '$kab' AND 
                    kecamatan_id = '$kec' AND
                    klinik LIKE '%$search%' 
                ORDER BY klinik ASC")->result_array();
                return $data;
            } else {
                $data['res'] = $this->db->query("SELECT klinik_id id, klinik FROM v_klinik WHERE 
                    provinsi_id = '$pro' AND 
                    kabupaten_id = '$kab' AND 
                    kecamatan_id = '$kec'
                ORDER BY klinik ASC")->result_array();
                return $data;
            }
        }

        // 3
        if (!empty($pro) && !empty($kab)) {
            if (!empty($search)) {
                $data['res'] = $this->db->query("SELECT klinik_id id, klinik FROM v_klinik WHERE 
                    provinsi_id = '$pro' AND 
                    kabupaten_id = '$kab' AND
                    klinik LIKE '%$search%' 
                ORDER BY klinik ASC")->result_array();
                return $data;
            } else {
                $data['res'] = $this->db->query("SELECT klinik_id id, klinik FROM v_klinik WHERE 
                    provinsi_id = '$pro' AND 
                    kabupaten_id = '$kab'
                ORDER BY klinik ASC")->result_array();
                return $data;
            }
        }

        // 4
        if (!empty($pro)) {
            if (!empty($search)) {
                $data['res'] = $this->db->query("SELECT klinik_id id, klinik FROM v_klinik WHERE 
                    provinsi_id = '$pro' AND
                    klinik LIKE '%$search%' 
                ORDER BY klinik ASC")->result_array();
                return $data;
            } else {
                $data['res'] = $this->db->query("SELECT klinik_id id, klinik FROM v_klinik WHERE 
                    provinsi_id = '$pro'
                ORDER BY klinik ASC")->result_array();
                return $data;
            }
        }

        if (empty($pro) && empty($kab) && empty($kec) && empty($kec)) {
            if (!empty($search)) {
                $data['res'] = $this->db->query("SELECT klinik_id id, klinik FROM v_klinik WHERE klinik LIKE '%$search%' ORDER BY klinik ASC")->result_array();
                return $data;
            } else {
                $data['res'] = $this->db->query("SELECT klinik_id id, klinik FROM v_klinik ORDER BY klinik ASC")->result_array();
                return $data;
            }
        }
    }

    public function xhrDokter($data)
    {
        $search = $data['search'];
        $ref = $data['ref'];
        $result['res'] = array();

        if ($ref === 'dokter') {
            $result['res'] = $this->db->query("SELECT user_id, nama_lengkap FROM v_dokter WHERE nama_lengkap LIKE '%$search%' ORDER BY nama_lengkap ASC")->result_array();
            return $result;
        }

        if ($ref === 'dokter-klinik') {
            $klinik = $data['klinik'];
            if (!empty($search)) {
                // $result['res'] = $this->db->query("SELECT * FROM v_jadwal WHERE klinik_id = '$klinik' AND status_jadwal = 'aktif' AND nama_lengkap LIKE '%$search%' GROUP BY dokter_id ORDER BY nama_lengkap ASC")->result_array();
                $result['res'] = $this->db->query("SELECT dokter_id, nama_lengkap, foto_dokter, klinik, jabatan FROM v_jadwal WHERE klinik_id = '$klinik' AND status_jadwal = 'aktif' AND nama_lengkap LIKE '%$search%' GROUP BY dokter_id ORDER BY nama_lengkap ASC")->result_array();
                return $result;
            } else {
                // $result['res'] = $this->db->query("SELECT * FROM v_jadwal WHERE klinik_id = '$klinik' AND status_jadwal = 'aktif' GROUP BY dokter_id ORDER BY nama_lengkap ASC")->result_array();
                $result['res'] = $this->db->query("SELECT dokter_id, nama_lengkap, foto_dokter, klinik, jabatan FROM v_jadwal WHERE klinik_id = '$klinik' AND status_jadwal = 'aktif' GROUP BY dokter_id ORDER BY nama_lengkap ASC")->result_array();
                return $result;
            }
        }

        if ($ref === 'dokter-jadwal') {
            $klinik = $data['klinik'];
            $dokter = $data['dokter'];
            $result['res'] = $this->db->query("SELECT * FROM v_jadwal WHERE klinik_id = '$klinik' AND status_jadwal = 'aktif' AND dokter_id = '$dokter' ORDER BY nama_lengkap ASC")->result_array();
            return $result;
        }
    }

    // Klinik
    public function fetch_klinik($d, $ref)
    {
        $search = $d['data']['search'];
        $currentPage = $d['data']['currentPage'];
        $perPage = $d['data']['perPage'];
        $offset = ($currentPage - 1) * $perPage;

        $sql1 = "SELECT klinik_id FROM v_klinik";
        $sql2 = "SELECT * FROM v_klinik";

        if (!empty($search)) {
            $sql1 .= " WHERE klinik LIKE '%$search%'";
            $sql2 .= " WHERE klinik LIKE '%$search%'";
        }
        $result = $this->db->query($sql1)->num_rows();
        $total_rows = $result;
        $total_pages = ceil($total_rows / $perPage);

        $sql2 .= " ORDER BY klinik DESC LIMIT $offset, $perPage";

        $q1 = $this->db->query($sql2)->result_array();
        $qx = $this->db->query($sql2)->num_rows();

        $data['total_rows'] = $qx;
        $data['items'] = $q1;
        $data['totalPage'] = $total_pages;

        return $data;
    }

    // Klinik
    public function fetch_klinik_3($d, $ref)
    {
        $filter = $d['data']['filter'];
        $search = $d['data']['search'];
        $currentPage = $d['data']['currentPage'];
        $perPage = $d['data']['perPage'];
        $offset = ($currentPage - 1) * $perPage;

        $sql1 = "SELECT a.klinik_id FROM v_klinik a LEFT JOIN v_konsul b ON a.klinik_id = b.klinik_id";
        $sql2 = "SELECT a.klinik_id, a.provinsi, a.kabupaten, a.kecamatan, a.kelurahan, a.klinik, a.alamat, a.foto, COUNT(b.id_konsul) ranke FROM v_klinik a LEFT JOIN v_konsul b ON a.klinik_id = b.klinik_id";

        if (!empty($search)) {
            if ($filter == 'klinik') {
                $sql1 .= " WHERE a.klinik LIKE '%$search%'";
                $sql2 .= " WHERE a.klinik LIKE '%$search%'";
            }

            if ($filter == 'provinsi') {
                $sql1 .= " WHERE a.provinsi LIKE '%$search%'";
                $sql2 .= " WHERE a.provinsi LIKE '%$search%'";
            }
        }

        $result = $this->db->query($sql1)->num_rows();
        $total_rows = $result;
        $total_pages = ceil($total_rows / $perPage);

        $sql2 .= " GROUP BY a.klinik_id ORDER BY provinsi, ranke ASC LIMIT $offset, $perPage";

        $q1 = $this->db->query($sql2)->result_array();
        $qx = $this->db->query($sql2)->num_rows();

        $data['total_rows'] = $qx;
        $data['items'] = $q1;
        $data['totalPage'] = $total_pages;

        return $data;
    }

    // Layanan
    public function fetch_layanan($d, $ref)
    {
        $search = $d['data']['search'];
        $currentPage = $d['data']['currentPage'];
        $perPage = $d['data']['perPage'];
        $offset = ($currentPage - 1) * $perPage;

        $sql1 = "SELECT id_kategori_layanan FROM kategori_layanan";
        $sql2 = "SELECT * FROM kategori_layanan";

        if (!empty($search)) {
            $sql1 .= " WHERE nama_kategori_layanan LIKE '%$search%'";
            $sql2 .= " WHERE nama_kategori_layanan LIKE '%$search%'";
        }
        $result = $this->db->query($sql1)->num_rows();
        $total_rows = $result;
        $total_pages = ceil($total_rows / $perPage);

        $sql2 .= " ORDER BY nama_kategori_layanan DESC LIMIT $offset, $perPage";

        $q1 = $this->db->query($sql2)->result_array();
        $qx = $this->db->query($sql2)->num_rows();

        $data['total_rows'] = $qx;
        $data['items'] = $q1;
        $data['totalPage'] = $total_pages;

        return $data;
    }

    // Layanan
    public function fetch_dokter($d, $ref)
    {
        $search = $d['data']['search'];
        $currentPage = $d['data']['currentPage'];
        $perPage = $d['data']['perPage'];
        $offset = ($currentPage - 1) * $perPage;

        $sql1 = "SELECT id FROM v_dokter";
        $sql2 = "SELECT * FROM v_dokter";

        if (!empty($search)) {
            $sql1 .= " WHERE nama_lengkap LIKE '%$search%'";
            $sql2 .= " WHERE nama_lengkap LIKE '%$search%'";
        }
        $result = $this->db->query($sql1)->num_rows();
        $total_rows = $result;
        $total_pages = ceil($total_rows / $perPage);

        $sql2 .= " ORDER BY nama_lengkap DESC LIMIT $offset, $perPage";

        $q1 = $this->db->query($sql2)->result_array();
        $qx = $this->db->query($sql2)->num_rows();

        $data['total_rows'] = $qx;
        $data['items'] = $q1;
        $data['totalPage'] = $total_pages;

        return $data;
    }

    public function xhrKonsul($d)
    {
        $klinik = $d['klinik'];
        $layanan = $d['layanan'];
        $gender = $d['gender'];
        $dokter = $d['dokter'];
        $tstart = $d['tstart'];
        $tend = $d['tend'];
        $currentPage = $d['currentPage'];
        $perPage = $d['perPage'];
        $offset = ($currentPage - 1) * $perPage;

        $sql1 = "SELECT id_konsul FROM v_laporan WHERE 1=1";
        $sql2 = "SELECT * FROM v_laporan WHERE 1=1";

        if (!empty($layanan)) {
            $sql1 .= " AND FIND_IN_SET('$layanan', kategori_layanan)";
            $sql2 .= " AND FIND_IN_SET('$layanan', kategori_layanan)";
        }

        if (!empty($klinik)) {
            $sql1 .= " AND klinik_id = '$klinik'";
            $sql2 .= " AND klinik_id = '$klinik'";
        }

        if (!empty($gender)) {
            $sql1 .= " AND gender_pasien = '$gender'";
            $sql2 .= " AND gender_pasien = '$gender'";
        }

        if (!empty($dokter)) {
            $sql1 .= " AND dokter_id = '$dokter'";
            $sql2 .= " AND dokter_id = '$dokter'";
        }

        if (!empty($tstart) && !empty($tend)) {
            $sql1 .= " AND tanggal >= '$tstart' AND tanggal <= '$tend'";
            $sql2 .= " AND tanggal >= '$tstart' AND tanggal <= '$tend'";
        }

        if (!empty($tstart) && empty($tend)) {
            $sql1 .= " AND tanggal >= '$tstart'";
            $sql2 .= " AND tanggal >= '$tstart'";
        }

        if (empty($tstart) && !empty($tend)) {
            $sql1 .= " AND tanggal <= '$tend'";
            $sql2 .= " AND tanggal <= '$tend'";
        }

        $all = $this->db->query($sql2)->result_array();
        $result = $this->db->query($sql1)->num_rows();
        $total_rows = $result;
        $total_pages = ceil($total_rows / $perPage);

        $sql2 .= " ORDER BY id_konsul DESC LIMIT $offset, $perPage";

        $q1 = $this->db->query($sql2)->result_array();
        $qx = $this->db->query($sql2)->num_rows();

        $data['all'] = $all;
        $data['total_rows'] = $qx;
        $data['items'] = $q1;
        $data['totalPage'] = $total_pages;

        return $data;
    }

    public function fetch_klinik_2($d)
    {
        $user_id = $d['data']['user_id'];
        $search = $d['data']['search'];
        $currentPage = $d['data']['currentPage'];
        $perPage = $d['data']['perPage'];
        $offset = ($currentPage - 1) * $perPage;

        $sql1 = "SELECT b.klinik_id FROM users a INNER JOIN v_klinik b ON a.klinik_id = b.klinik_id WHERE a.user_id = '$user_id'";
        $sql2 = "SELECT b.* FROM users a INNER JOIN v_klinik b ON a.klinik_id = b.klinik_id WHERE a.user_id = '$user_id'";

        if (!empty($search)) {
            $sql1 .= " AND b.klinik LIKE '%$search%'";
            $sql2 .= " AND b.klinik LIKE '%$search%'";
        }
        $result = $this->db->query($sql1)->num_rows();
        $total_rows = $result;
        $total_pages = ceil($total_rows / $perPage);

        $sql2 .= " ORDER BY b.klinik DESC LIMIT $offset, $perPage";

        $q1 = $this->db->query($sql2)->result_array();
        $qx = $this->db->query($sql2)->num_rows();

        $data['total_rows'] = $qx;
        $data['items'] = $q1;
        $data['totalPage'] = $total_pages;

        return $data;
    }

    public function klinik_rekomendasi()
    {
        return $this->db->query("SELECT COUNT(a.id_konsul) jumlah, a.klinik_id, a.klinik, a.alamat_klinik, b.foto FROM v_konsul a INNER JOIN v_klinik b ON a.klinik_id = b.klinik_id GROUP BY a.klinik_id ORDER BY jumlah DESC")->result_array();
    }

    public function fetch_single_klinik($kid)
    {
        $result = $this->db->query("SELECT * FROM v_klinik WHERE klinik_id = '$kid'")->result_array();
        return $result;
    }

    function myKlinik($user_id)
    {
        $result = $this->db->query("SELECT a.klinik_id, b.klinik FROM users a INNER JOIN klinik b ON a.klinik_id = b.id WHERE a.user_id = '$user_id'")->result_array();
        return $result;
    }

    public function info_dokter($id)
    {
        $result = $this->db->query("SELECT * FROM v_dokter WHERE user_id = '$id'")->row_array();
    }

    public function xhrJadwalx($d, $ref)
    {
        $currentPage = $d['data']['currentPage'];
        $perPage = $d['data']['perPage'];
        $offset = ($currentPage - 1) * $perPage;
        $ref = $d['data']['ref'];
        $did = $d['data']['did'];
        $kid = $d['data']['kid'];

        $sql1 = "SELECT 
            a.jadwal_id id,
            a.klinik_id,
            a.dokter_id,
            LEFT(a.tstart, 5) tstart, 
            LEFT(a.tend, 5) tend,
            a.kuota,
            a.timezone, 
            a.status_jadwal `status`, 
            a.nama_lengkap nama_dokter, 
            a.klinik,
            a.biaya_tarif 
        FROM v_jadwal a WHERE a.klinik_id = '$kid' ";
        $sql2 = "SELECT 
            a.jadwal_id id,
            a.klinik_id,
            a.dokter_id,
            LEFT(a.tstart, 5) tstart, 
            LEFT(a.tend, 5) tend,
            a.kuota,
            a.timezone, 
            a.status_jadwal `status`, 
            a.nama_lengkap nama_dokter, 
            a.klinik,
            a.biaya_tarif
        FROM v_jadwal a WHERE a.klinik_id = '$kid' ";

        if (!empty($did)) {
            $sql1 .= " AND a.dokter_id = '$did'";
            $sql2 .= " AND a.dokter_id = '$did'";
        }

        $result = $this->db->query($sql1)->num_rows();
        $total_rows = $result;
        $total_pages = ceil($total_rows / $perPage);

        $sql2 .= " ORDER BY a.jadwal_id DESC LIMIT $offset, $perPage";

        $q1 = $this->db->query($sql2)->result_array();
        $qx = $this->db->query($sql2)->num_rows();

        $data['total_rows'] = $qx;
        $data['items'] = $q1;
        $data['totalPage'] = $total_pages;

        return $data;
    }

    // return data if not started yet
    function timeNo($konsul)
    {
        $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND CURTIME() < tstart")->result_array();
        return $result;
    }

    // return data if starting
    function timeYes($konsul)
    {
        // $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND (CURTIME() >= tstart AND CURTIME() <= tend)")->result_array();
        $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND (DATE_ADD(NOW(), INTERVAL 7 HOUR) >= DATE_FORMAT(CONCAT(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d'), ' ', tstart), '%Y-%m-%d %H:%i:%s') AND DATE_ADD(NOW(), INTERVAL 7 HOUR) <= DATE_FORMAT(CONCAT(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d'), ' ', tend), '%Y-%m-%d %H:%i:%s'))")->result_array();
        return $result;
    }

    // return data if time is expired
    function timeEx($konsul)
    {
        // $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND CURTIME() > tend")->result_array();
        $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND DATE_ADD(NOW(), INTERVAL 7 HOUR) > DATE_FORMAT(CONCAT(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d'), ' ', tend), '%Y-%m-%d %H:%i:%s')")->result_array();
        return $result;
    }

    // Ini digunakan apabila timezone waktu di mysql server tidak dapat disamakan dengan waktu di server
    // // return data if not started yet
    // function timeNo($konsul) {
    //     // $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND CURTIME() < tstart")->result_array();
    //     $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND DATE_ADD(NOW(), INTERVAL 7 HOUR) < DATE_FORMAT(CONCAT(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d'), ' ', tstart), '%Y-%m-%d %H:%i:%s')")->result_array();
    //     return $result;
    // }

    // // return data if starting
    // function timeYes($konsul) {
    //     // $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND (CURTIME() >= tstart AND CURTIME() <= tend)")->result_array();
    //     $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND (DATE_ADD(NOW(), INTERVAL 7 HOUR) >= DATE_FORMAT(CONCAT(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d'), ' ', tstart), '%Y-%m-%d %H:%i:%s') AND DATE_ADD(NOW(), INTERVAL 7 HOUR) <= DATE_FORMAT(CONCAT(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d'), ' ', tend), '%Y-%m-%d %H:%i:%s'))")->result_array();
    //     return $result;
    // }

    // // return data if time is expired
    // function timeEx($konsul) {
    //     // $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND CURTIME() > tend")->result_array();
    //     $result = $this->db->query("SELECT * FROM v_konsul WHERE id_konsul = '$konsul' AND DATE_ADD(NOW(), INTERVAL 7 HOUR) > DATE_FORMAT(CONCAT(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d'), ' ', tend), '%Y-%m-%d %H:%i:%s')")->result_array();
    //     return $result;
    // }

    function disableKonsul($konsul)
    {
        $this->db->query("UPDATE konsul SET `status` = 'N' WHERE id_konsul = '$konsul'");
    }

    function latest_news()
    {
        return $this->db->query("SELECT a.*, DATE_FORMAT(a.tanggal, '%b %d, %Y') tanggalx FROM berita a ORDER BY a.id_berita DESC LIMIT 3")->result_array();
    }

    function comments5()
    {
        return $this->db->query("SELECT * FROM hubungi a ORDER BY a.id_hubungi DESC LIMIT 5")->result_array();
    }

    function unread()
    {
        // return $this->db->query("SELECT a.id_konsul, a.id_komentar, a.level FROM v_konsul a WHERE a.id_konsul = 19")->result_array();
        $dokter = $this->session->user_id;
        return $this->db->query("SELECT a.id_konsul, a.id_komentar, a.level FROM v_konsul a WHERE a.`level` IS NOT NULL AND a.dokter = '$dokter' GROUP BY a.id_konsul, a.id_komentar")->result_array();
    }
}
