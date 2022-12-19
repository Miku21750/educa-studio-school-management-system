<?php

namespace App\Controller;

use Slim\App;

class LibraryController
{

    public static function index($app, $request, $response, $args)
    {
        $id_book = $args['id_book'];
        // return var_dump($id_parent);

        $data = $app->db->select('tbl_books', '*');

        // var_dump($data);

        $app->view->render($response, 'library/all-book.html', [
            'data' => $data,
            'id_book' => $id_book,

        ]);
    }

    public static function tampil_data($app, $req, $rsp, $args)
    {
        $book = $app->db->select(
            'tbl_books',
            [
                '[><]tbl_subjects' => 'id_subject',
                '[><]tbl_classes' => 'id_class',
            ],
            '*'
        );
        // return var_dump($book);

        $totaldata = count($book);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');

        $conditions = [
            "LIMIT" => [$start, $limit],

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                // 'id_book_type' => $type,

            ];
            $conditions['OR'] = [
                'tbl_books.name_book[~]' => '%' . $search . '%',
                'tbl_books.code_book[~]' => '%' . $search . '%',
                'tbl_books.writer_book[~]' => '%' . $search . '%',
                'tbl_books.publish_date[~]' => '%' . $search . '%',
                'tbl_books.upload_date[~]' => '%' . $search . '%',

            ];
            $book = $app->db->select(
                'tbl_books',
                [
                    '[><]tbl_subjects' => 'id_subject',
                    '[><]tbl_classes' => 'id_class',
                ],
                '*',
                $limit
            );
            $totaldata = count($book);
            $totalfiltered = $totaldata;
        }

        $book = $app->db->select('tbl_books', [
            '[><]tbl_subjects' => 'id_subject',
            '[><]tbl_classes' => 'id_class',
        ], '*', $conditions);

        $data = array();

        if (!empty($book)) {
            $no = $req->getParam('start') + 1;
            foreach ($book as $m) {

                $datas['No'] = $no . '.';
                $datas['code_book'] = $m['code_book'];
                $datas['name_book'] = $m['name_book'];
                $datas['subject'] = $m['subject_name'];
                $datas['writer'] = $m['writer_book'];
                $datas['class'] = $m['class'];
                $datas['published'] = $m['publish_date'];
                $datas['creating_date'] = $m['upload_date'];
                $datas['aksi'] = '<div class="dropdown">
                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item book_remove btn btn-light" data="' . $m['id_book'] . '" data-target="#confirmation-modal">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="btn dropdown-item book_detail btn btn-light" data="' . $m['id_book'] . '" id="show_book" data-toggle="modal" data-target="detail_book">
                        <i class="fas fa-edit text-dark-pastel-green"></i>
                        Ubah
                    </a>
                </div>
            </div>';
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($book);
        // return var_dump($book);

        $json_data = array(
            "draw" => intval($req->getParam('draw')),
            "recordsTotal" => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        // return var_dump($data);
        // return var_dump($json_data);
        echo json_encode($json_data);
    }

    public static function tampil_dataS($app, $req, $rsp, $args)
    {
        $book = $app->db->select(
            'tbl_books',
            [
                '[><]tbl_subjects' => 'id_subject',
                '[><]tbl_classes' => 'id_class',
            ],
            '*'
        );
        // return var_dump($book);

        $totaldata = count($book);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');

        $conditions = [
            "LIMIT" => [$start, $limit],

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                // 'id_book_type' => $type,

            ];
            $conditions['OR'] = [
                'tbl_books.name_book[~]' => '%' . $search . '%',
                'tbl_books.code_book[~]' => '%' . $search . '%',
                'tbl_books.writer_book[~]' => '%' . $search . '%',
                'tbl_books.publish_date[~]' => '%' . $search . '%',
                'tbl_subjects.subject_name[~]' => '%' . $search . '%',

            ];
            $book = $app->db->select(
                'tbl_books',
                [
                    '[><]tbl_subjects' => 'id_subject',
                    '[><]tbl_classes' => 'id_class',
                ],
                '*',
                // $limit
                $conditions
            );
            $totaldata = count($book);
            $totalfiltered = $totaldata;
        }

        $book = $app->db->select('tbl_books', [
            '[><]tbl_subjects' => 'id_subject',
            '[><]tbl_classes' => 'id_class',
        ], '*', $conditions);

        $data = array();

        if (!empty($book)) {
            $no = $req->getParam('start') + 1;
            foreach ($book as $m) {

                $datas['No'] = $no . '.';
                $datas['code_book'] = $m['code_book'];
                $datas['name_book'] = $m['name_book'];
                $datas['subject'] = $m['subject_name'];
                $datas['writer'] = $m['writer_book'];
                $datas['class'] = $m['class'];
                $datas['creating_date'] = $m['upload_date'];
                $datas['status'] = $m['status_buku'];

                $siswa = $app->db->select('tbl_peminjaman','*', [
                    'id_user' => $_SESSION['id_user'],
                    'ket' => 'Dipinjam',
                    'ket' => 'Proses',
                ]);

                if ($m['status_buku'] == 'Dipinjam') {
                    $datas['aksi'] = '';
                }elseif ($siswa != null) {
                    $datas['aksi'] = '';
                } else {
                    $datas['aksi'] = '<div class="dropdown">
                    <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                        aria-expanded="false">
                        <span class="flaticon-more-button-of-three-dots"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item btn btn-light item_pinjam" data="' . $m['id_book'] . '">
                        <i class="fas fa-book text-success"></i>
                        Ajukan Pinjaman
                    </a>
                        
                    </div>
                </div>';
                }

                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($book);
        // return var_dump($book);

        $json_data = array(
            "draw" => intval($req->getParam('draw')),
            "recordsTotal" => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        // return var_dump($data);
        // return var_dump($json_data);
        echo json_encode($json_data);
    }

    public static function detail($app, $request, $response, $args)
    {
        $id_book = $args['data'];
        // return var_dump($id_book);

        $book = $app->db->select('tbl_books', [
            '[><]tbl_subjects' => 'id_subject',
            '[><]tbl_classes' => 'id_class',
        ], '*', [
            'id_book' => $id_book,
        ]);

        // return var_dump($book);
        // $json_data = array(
        //     'data' => $data,
        // );

        unset($_SESSION['berhasil']);

        // return var_dump($json_data);

        return $response->withJson($book);

        // echo json_encode($json_data);
    }

    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];

        $del = $app->db->delete('tbl_books', [
            "id_book" => $id,
        ]);

        // return $rsp->withJson($del);
        $json_data = array(
            "draw" => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function update_book_detail($app, $request, $response, $args)
    {
        $data = $args['data'];

        $update = $app->db->update('tbl_books', [
            "name_book" => $data['name_book'],
            "id_subject" => $data['subject'],
            "writer_book" => $data['writer_book'],
            "id_class" => $data['class_book'],
            "publish_date" => $data['publish_date'],
            "upload_date" => $data['upload_date'],
            "code_book" => $data['code_book'],
        ], [
            "id_book" => $data['id_book'],
        ]);

        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);

        // return var_dump($update);
        // return $response->withRedirect('/api/library/getBook');
    }

    public static function add_book($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);

        $data = $app->db->insert('tbl_books', [
            "name_book" => $data['name_book'],
            "id_subject" => $data['subject'],
            "writer_book" => $data['writer_book'],
            "id_class" => $data['class_book'],
            "publish_date" => $data['publish_date'],
            "upload_date" => $data['upload_date'],
            "code_book" => $data['code_book'],
        ]);
        // return die(var_dump($data));
        $_SESSION['berhasil'] = true;
        // unset($_SESSION['berhasil']);

        return $rsp->withRedirect('/add-book');

        // $berhasil = isset($_SESSION['berhasil']);
        // unset($_SESSION['berhasil']);

        // $app->view->render($rsp, 'library/add-book.html', [
        //     'type' => $_SESSION['type'],
        //     'berhasil' => $berhasil,
        // ]);
    }

    public static function option_book($app, $req, $rsp, $args)
    {
        $class = $app->db->select('tbl_classes', [
            'class',
            'id_class',
        ], [
            'GROUP' => [
                'class',
            ],
        ]);
        $subject = $app->db->select('tbl_subjects', '*');

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);

        $app->view->render($rsp, 'library/add-book.html', [
            'class' => $class,
            'subject' => $subject,
            'berhasil' => $berhasil,
        ]);
    }

    public static function option_book_detail($app, $req, $rsp, $args)
    {
        // $class = $app->db->query("SELECT class FROM tbl_classes")->fetchAll();
        $class = $app->db->select('tbl_classes', [
            'class',
            'id_class',
        ], [
            'GROUP' => [
                'class',
            ],
        ]);
        $subject = $app->db->select('tbl_subjects', '*');

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);

        $app->view->render($rsp, 'library/all-book.html', [
            'class' => $class,
            'subject' => $subject,
            'berhasil' => $berhasil,
        ]);
    }
    public static function peminjaman($app, $req, $rsp, $args)
    {
        // $class = $app->db->query("SELECT class FROM tbl_classes")->fetchAll();
        $class = $app->db->select('tbl_classes', [
            'class',
            'id_class',
        ], [
            'GROUP' => [
                'class',
            ],
        ]);
        $subject = $app->db->select('tbl_subjects', '*');

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);

        $app->view->render($rsp, 'library/all-peminjaman.html', [
            'class' => $class,
            'subject' => $subject,
            'berhasil' => $berhasil,
        ]);
    }
    public static function tampil_data_peminjaman($app, $req, $rsp, $args)
    {
        $book = $app->db->select(
            'tbl_peminjaman',
            [
                '[><]tbl_books' => 'id_book',
                '[><]tbl_users' => 'id_user',
                '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],

            ],
            '*'
        );
        // return  var_dump($book);
        // die();

        $totaldata = count($book);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');

        $conditions = [
            "LIMIT" => [$start, $limit],

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                // 'id_book_type' => $type,

            ];
            $conditions['OR'] = [
                'tbl_books.name_book[~]' => '%' . $search . '%',
                'tbl_books.code_book[~]' => '%' . $search . '%',
                'tbl_books.writer_book[~]' => '%' . $search . '%',
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_peminjaman.ket[~]' => '%' . $search . '%',

            ];
            $book = $app->db->select(
                'tbl_peminjaman',
                [
                    '[><]tbl_books' => 'id_book',
                    '[><]tbl_users' => 'id_user',
                    '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                    '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],

                ],
                '*',
                // $limit
                $conditions
            );
            $totaldata = count($book);
            $totalfiltered = $totaldata;
        }

        $book = $app->db->select(
            'tbl_peminjaman',
            [
                '[><]tbl_books' => 'id_book',
                '[><]tbl_users' => 'id_user',
                '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],

            ],
            '*',
            $conditions
        );

        $data = array();

        if (!empty($book)) {
            $no = $req->getParam('start') + 1;
            foreach ($book as $m) {
                $date = date("Y-m-d ");

                if ($date >  $m['tgl_kembali'] && $m['ket'] == 'Dipinjam' or $m['ket'] == 'Denda') {
                    // untuk menghitung selisih hari terlambat
                    $t = date_create($m['tgl_kembali']);
                    $n = date_create(date('Y-m-d'));
                    $terlambat = date_diff($t, $n);
                    $hari = $terlambat->format("%a");
                    // menghitung denda
                    $denda = $hari * 100;
                } else {
                    $hari = ' - ';
                    $denda = 0;
                }



                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                $datas['kelas'] = $m['class'] . ' ' . $m['section'];
                $datas['id_buku'] = $m['code_book'];
                $datas['judul'] = $m['name_book'];
                $datas['penulis'] = $m['writer_book'];
                $datas['tanggal_pinjam'] = $m['tgl_pinjam'];
                $datas['tanggal_pengembalian'] = $m['tgl_kembali'];
                $datas['telat'] = $hari;
                $datas['denda'] = 'Rp. ' . number_format($denda, 0, ',', '.');

                if ($m['ket'] == "Proses") {
                    $datas['status'] = '<p class="badge badge-pill badge-warning d-block my-2 py-3 px-4">' . $m['ket'] . '</p>';
                } elseif ($m['ket'] == "Dipinjam") {
                    $datas['status'] = '<p class="badge badge-pill badge-info d-block my-2 py-3 px-4">' . $m['ket'] . '</p>';
                } elseif ($m['ket'] == "Dikembalikan") {
                    $datas['status'] = '<p class="badge badge-pill badge-success d-block my-2 py-3 px-4">' . $m['ket'] . '</p>';
                }elseif ($m['ket'] == "Proses Pengembalian") {
                    $datas['status'] = '<p class="badge badge-pill badge-warning d-block my-2 py-3 px-4">' . $m['ket'] . '</p>';
                } else {
                    $datas['status'] = '<p class="badge badge-pill badge-danger d-block my-2 py-3 px-4">' . $m['ket'] . '</p>';
                }

                $datas['aksi'] = '<div class="dropdown">
                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_peminjaman'] . '">
                    <i class="fas fa-trash text-danger"></i>
                    Hapus
                </a>
                <a class="dropdown-item btn btn-light item_ubah_pinjam" data="' . $m['id_peminjaman'] . '">
                    <i class="fas fa-edit text-info"></i>
                    Ubah
                </a>
                    
                   
                </div>
            </div>';
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($book);
        // return var_dump($book);

        $json_data = array(
            "draw" => intval($req->getParam('draw')),
            "recordsTotal" => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        // return var_dump($data);
        // return var_dump($json_data);
        echo json_encode($json_data);
    }
    public static function tampil_data_peminjaman_siswa($app, $req, $rsp, $args)
    {   
        $id_user = $args['data'];
        $book = $app->db->select(
            'tbl_peminjaman',
            [
                '[><]tbl_users' => 'id_user',
                '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],
                '[><]tbl_books' => 'id_book',

            ],
            '*',[
                'tbl_users.id_user' => $id_user,
            ]
        );
        // return  var_dump($book);
        // die();

        $totaldata = count($book);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');

        $conditions = [
            "LIMIT" => [$start, $limit],
            'id_user' => $id_user
        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                'id_user' => $id_user
            ];
            $conditions['OR'] = [
                'tbl_books.name_book[~]' => '%' . $search . '%',
                'tbl_books.code_book[~]' => '%' . $search . '%',
                'tbl_books.writer_book[~]' => '%' . $search . '%',
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_peminjaman.ket[~]' => '%' . $search . '%',

            ];
            $book = $app->db->select(
                'tbl_peminjaman',
                [
                    '[><]tbl_books' => 'id_book',
                    '[><]tbl_users' => 'id_user',
                    '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                    '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],

                ],
                '*',
                $conditions
            );
            $totaldata = count($book);
            $totalfiltered = $totaldata;
        }

        $book = $app->db->select(
            'tbl_peminjaman',
            [
                '[><]tbl_books' => 'id_book',
                '[><]tbl_users' => 'id_user',
                '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],

            ],
            '*',
            $conditions
        );

        $data = array();

        if (!empty($book)) {
            $no = $req->getParam('start') + 1;
            foreach ($book as $m) {
                $date = date("Y-m-d ");

                if ($date >  $m['tgl_kembali'] && $m['ket'] == 'Dipinjam' or $m['ket'] == 'Denda') {
                    // untuk menghitung selisih hari terlambat
                    $t = date_create($m['tgl_kembali']);
                    $n = date_create(date('Y-m-d'));
                    $terlambat = date_diff($t, $n);
                    $hari = $terlambat->format("%a");
                    // menghitung denda
                    $denda = $hari * 100;
                } else {
                    $hari = ' - ';
                    $denda = 0;
                }



                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                $datas['kelas'] = $m['class'] . ' ' . $m['section'];
                $datas['id_buku'] = $m['code_book'];
                $datas['judul'] = $m['name_book'];
                $datas['penulis'] = $m['writer_book'];
                $datas['tanggal_pinjam'] = $m['tgl_pinjam'];
                $datas['tanggal_pengembalian'] = $m['tgl_kembali'];
                $datas['telat'] = $hari;
                $datas['denda'] = 'Rp. ' . number_format($denda, 0, ',', '.');

                if ($m['ket'] == "Proses") {
                    $datas['status'] = '<p class="badge badge-pill badge-warning d-block my-2 py-3 px-4">' . $m['ket'] . '</p>';
                } elseif ($m['ket'] == "Dipinjam") {
                    $datas['status'] = '<p class="badge badge-pill badge-info d-block my-2 py-3 px-4">' . $m['ket'] . '</p>';
                } elseif ($m['ket'] == "Dikembalikan") {
                    $datas['status'] = '<p class="badge badge-pill badge-success d-block my-2 py-3 px-4">' . $m['ket'] . '</p>';
                }elseif ($m['ket'] == "Proses Pengembalian") {
                    $datas['status'] = '<p class="badge badge-pill badge-warning d-block my-2 py-3 px-4">' . $m['ket'] . '</p>';
                } else {
                    $datas['status'] = '<p class="badge badge-pill badge-danger d-block my-2 py-3 px-4">' . $m['ket'] . '</p>';
                }


               if ($m['ket'] == 'Dipinjam'  ) {
                $datas['aksi'] = '<div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right btn btn-light item_pengembalian" data="' . $m['id_peminjaman'] . '">
                    <a class="dropdown-item"  >
                        <i class="fas fa-book text-success"></i>
                        Ajukan Pengembalian
                    </a>    
                </div>
                </div>';                
                } else {
                    $datas['aksi'] = '';
                }
                    
                   
               
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($book);
        // return var_dump($book);

        $json_data = array(
            "draw" => intval($req->getParam('draw')),
            "recordsTotal" => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        // return var_dump($data);
        // return var_dump($json_data);
        echo json_encode($json_data);
    }
    public static function pinjam($app, $req, $rsp, $args)
    {
        $id_buku = $args['data'];
        $id_user = $_SESSION['id_user'];
        $tgl_pinjam = date("Y-m-d ");
        $tujuh_hari = mktime(0, 0, 0, date("n"), date("j") + 7, date("Y"));
        $kembali        = date("Y-m-d", $tujuh_hari);

        $update = $app->db->update('tbl_books', [
            "status_buku" => 'Dipinjam',
        ], [
            "id_book" => $id_buku['kode'],
        ]);


        $data = $app->db->insert('tbl_peminjaman', [
            "id_book" => $id_buku['kode'],
            "id_user" => $id_user,
            "tgl_pinjam" => $tgl_pinjam,
            "tgl_kembali" => $kembali,
            "ket" => "Proses",
        ]);



        // die(var_dump($id_buku));
        // return $rsp->withJson($del);
        $json_data = array(
            "draw" => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }
    public static function pengembalian($app, $req, $rsp, $args)
    {
        $id_pengembalian = $args['data'];
        // $id_user = $_SESSION['id_user'];
        
        
        $update = $app->db->update('tbl_peminjaman', [
            "ket" => 'Proses Pengembalian',
        ], [
            "id_peminjaman" => $id_pengembalian['kode'],
        ]);
        
        // die(var_dump($update));

        // return $rsp->withJson($del);
        $json_data = array(
            "draw" => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function delete_peminjaman($app, $req, $rsp, $args)
    {
        $id = $args['data'];

        $data = $app->db->select('tbl_peminjaman', 'id_book', [
            'id_peminjaman' => $id
        ]);
        $id_buku = $data[0];

        // die(var_dump($id_buku));
        $update = $app->db->update('tbl_books', [
            "status_buku" => 'Ada',
        ], [
            "id_book" => $id_buku,
        ]);

        $del = $app->db->delete('tbl_peminjaman', [
            "id_peminjaman" => $id,
        ]);

        // return $rsp->withJson($del);
        $json_data = array(
            "draw" => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }
    public static function peminjaman_detail($app, $request, $response, $args)
    {
        $id_peminjaman = $args['data'];

        $Peminjaman = $app->db->select('tbl_peminjaman', [
            '[><]tbl_books' => 'id_book',
            '[><]tbl_users' => 'id_user',
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],

        ], '*', [
            'id_peminjaman' => $id_peminjaman,
        ]);




        return $response->withJson($Peminjaman[0]);
    }

    public static function update_peminjaman($app, $request, $response, $args)
    {
        $data = $args['data'];
        $tgl = $data['tgl_pinjam'];
        $tujuh_hari = date("Y-m-d", strtotime("$tgl +7 day"));
        // $tgl_pinjam = date_format(date_create($data['tgl_pinjam']), 'Y-m-d');
        // $kembali    = date("Y-m-d", $tujuh_hari);



        if ($data['ket'] == 'Dikembalikan') {
            $update = $app->db->update('tbl_books', [
                "status_buku" => 'Ada',
            ], [
                "id_book" => $data['id_book'],
            ]);
        }

        $update = $app->db->update('tbl_peminjaman', [
            "tgl_pinjam" => $tgl,
            "tgl_kembali" => $tujuh_hari,
            "ket" => $data['ket'],
        ], [
            "id_peminjaman" => $data['id_peminjaman'],
        ]);

        // die(var_dump($update));


        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }

    
}
