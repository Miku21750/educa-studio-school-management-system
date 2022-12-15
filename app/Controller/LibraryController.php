<?php

namespace App\Controller;

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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item book_remove" data="' . $m['id_book'] . '"><button type="button" class="btn btn-light" class="modal-trigger" data-toggle="modal"
                    data-target="#confirmation-modal"><i class="fas fa-trash text-orange-red"></i>
                            Hapus
                        </button></a>
                    <a class="btn dropdown-item book_detail" data="' . $m['id_book'] . '" ><button type="button" id="show_book"  class="btn btn-light"  data-toggle="modal" data-target="detail_book"><i
                            class="fas fa-edit text-dark-pastel-green"></i>
                            Ubah
                        </button></a>
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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item book_remove" data="' . $m['id_book'] . '"><button type="button" class="btn btn-light" class="modal-trigger" data-toggle="modal"
                    data-target="#confirmation-modal"><i class="fas fa-trash text-orange-red"></i>
                            Hapus
                        </button></a>
                    <a class="btn dropdown-item book_detail" data="' . $m['id_book'] . '" ><button type="button" id="show_book"  class="btn btn-light"  data-toggle="modal" data-target="detail_book"><i
                            class="fas fa-edit text-dark-pastel-green"></i>
                            Ubah
                        </button></a>
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
}
