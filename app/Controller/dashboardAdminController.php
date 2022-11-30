<?php
    namespace App\Controller;
    use Medoo\Medoo;

    class dashboardAdminController {
        public static function index($app, $req, $rsp, $args) {
            $app->get('renderer')->render($rsp, 'index.html', $args);
        }

        public function getStudent($app, $req, $res, $args)
        {
            $siswa = $app->db->select("tbl_users", "*", [
                "id_user_type" => "1"
            ]);

            $count = $app->db->count('tbl_users', [
                "id_user_type" => "1"
            ]);

            return $count;
        }

        // public function showSiswa($app, $req,  $res, array $args)
        // {   
        //     // var_dump($args);
        //     $siswa = $app->db->get('tbl_siswa (siswa)',["[><]tbl_nilai (nilai)" => ["siswa.id_siswa" => "id_siswa"]], '*', ['siswa.id_siswa' => $args['id']]);
        //     // if (count($siswa) < 1) {
        //     // $data["msg"] = "data tidak tersedia";
        //     // return $res->withJson($data, 404);
        //     // }
        //     return $res->withJson($siswa);
        // }

        // public function tambahSiswa($app,$req, $res, array $args)
        // {

        //     $data = $req->getParsedBody();

        //     // $result = $app->db->query("
        //     // INSERT INTO tbl_siswa( id_siswa, nama_siswa, gender_siswa)
        //     // SELECT siswa.id_siswa, siswa.nama_siswa, siswa.gender_siswa, nilai.nilai
        //     // FROM tbl_siswa siswa
        //     // INNER JOIN tbl_nilai nilai ON nilai.id_siswa = siswa.id_siswa");
            
        //     $result = $app->db->insert('tbl_siswa', [
        //         'nama_siswa' => $data['nama'],
        //         'gender_siswa' => $data['gender']
        //       ]);
        //     // die(var_dump($app->db->id('id_siswa')));
        //     // if($result){
        //         $app->db->insert('tbl_nilai', [
        //             'id_siswa' => $app->db->id('id_siswa'),
        //             'nilai_siswa' => $data['nilai']
        //         ]);
        //     // }
              
        // }

        // public function hapusData($app,$req, $res, array $args)
        // {
        //     $id = $args['id'];
        //     $result = $app->db->delete('tbl_siswa', ['id_siswa' => $id]);
        //     $app->db->delete('tbl_nilai', ['id_siswa' => $id]);
        //     if (!$result) {
        //     return $res->withJson([
        //         'msg' => 'gagal menghapus data'
        //     ]);
        //     }
        //     return $res->withJson([
        //     'msg' => 'berhasil menghapus siswa dengan id ' .  $id
        //     ]);
        // }

        // public function editData($app,$req, $res, array $args)
        // {
        //     $siswa = $app->db->get('tbl_siswa', ['id_siswa'], ['id_siswa' => (int)$args['id']]);
        //     if (!$siswa) {
        //     die('data tidak ada');
        //     }
        //     // die(var_dump($req->getParsedBody()));
        //     $result = $app->db->update('tbl_siswa', ['nama_siswa'=>$req->getParsedBody()['nama']], ['id_siswa' => $args['id']]);
        //     $app->db->update('tbl_nilai', $req->getParsedBody(), ['id_siswa' => $args['id']]);
            
        //     if (!$result) {
        //     die('gagal');
        //     }
        //     return $res->withJson(array('msg' => 'succes ubah data'));
        // }
    }
?>