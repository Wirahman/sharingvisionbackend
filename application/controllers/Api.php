<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->model('Model_posts');
    }

    public function article_post()
    {
        header('Content-type: application/json');
        $request_json = file_get_contents('php://input');

        $title = json_decode($request_json)->title;
        $content = json_decode($request_json)->content;
        $category = json_decode($request_json)->category;
        $status = json_decode($request_json)->status;

        if(strlen($title) > 20){
            if(strlen($content) > 200){
                if(strlen($category) > 3){
                    if($status == 'publish' || $status == 'draft' || $status == 'trash'){
                        $data['title'] = $title;
                        $data['content'] = $content;
                        $data['category'] = $category;
                        $data['status'] = $status;

                        $resp = $this->Model_posts->create($data);
                        if($resp){
                            $status_api = TRUE;
                            $pesan_api = "Artikel baru sudah dibuat";
                            $kode_api = 200;
                        }else{
                            $status_api = TRUE;
                            $pesan_api = "Terjadi kesalahan server";
                            $kode_api = 400;
                        }
                    }else{
                        $status_api = TRUE;
                        $pesan_api = "Status tulisan harus bernilai publish, draft atau trash ";
                        $kode_api = 400;
                    }
                }else{
                    $status_api = TRUE;
                    $pesan_api = "Kategori tulisan harus memiliki setidaknya 3 karakter ";
                    $kode_api = 400;
                }
            }else{
                $status_api = TRUE;
                $pesan_api = "Konten tulisan harus memiliki setidaknya 200 karakter ";
                $kode_api = 400;
            }
        }else{
            $status_api = TRUE;
            $pesan_api = "Title tulisan harus memiliki setidaknya 20 karakter ";
            $kode_api = 400;
        }

        return $this->response(array('status' => $status_api, "pesan_api" => $pesan_api), $kode_api);

    }

    public function article_get()
    {
        $limit = $this->get('limit');
        $offset = $this->get('offset');
        $database = $this->Model_posts->get_all_desc_limit($offset, $limit);
        $articlePost = $database;
        
        $status_api = TRUE;
        $pesan_api = "Daftar Artikel";
        $kode_api = 200;
        return $this->response(array('status' => $status_api, "pesan_api" => $pesan_api, "article" => $articlePost), $kode_api);
    }

    public function article1_get()
    {
        $id = $this->get('id');
        $database = $this->Model_posts->getById($id);
        $articlePost = $database;
        
        $status_api = TRUE;
        $pesan_api = "Artikel menggunakan id";
        $kode_api = 200;
        return $this->response(array('status' => $status_api, "pesan_api" => $pesan_api, "article" => $articlePost), $kode_api);
    }

    public function ubahArticle_post()
    {
        header('Content-type: application/json');
        $request_json = file_get_contents('php://input');
        
        $id = json_decode($request_json)->id;
        $title = json_decode($request_json)->title;
        $content = json_decode($request_json)->content;
        $category = json_decode($request_json)->category;
        $status = json_decode($request_json)->status;

        if(strlen($title) > 20){
            if(strlen($content) > 200){
                if(strlen($category) > 3){
                    if($status == 'publish' || $status == 'draft' || $status == 'trash'){
                        $data['title'] = $title;
                        $data['content'] = $content;
                        $data['category'] = $category;
                        $data['status'] = $status;

                        $resp = $this->Model_posts->update($id, $data);
                        if($resp){
                            $status_api = TRUE;
                            $pesan_api = "Artikel baru sudah dibuat";
                            $kode_api = 200;
                        }else{
                            $status_api = TRUE;
                            $pesan_api = "Terjadi kesalahan server";
                            $kode_api = 400;
                        }
                    }else{
                        $status_api = TRUE;
                        $pesan_api = "Status tulisan harus bernilai publish, draft atau trash ";
                        $kode_api = 400;
                    }
                }else{
                    $status_api = TRUE;
                    $pesan_api = "Kategori tulisan harus memiliki setidaknya 3 karakter ";
                    $kode_api = 400;
                }
            }else{
                $status_api = TRUE;
                $pesan_api = "Konten tulisan harus memiliki setidaknya 200 karakter ";
                $kode_api = 400;
            }
        }else{
            $status_api = TRUE;
            $pesan_api = "Title tulisan harus memiliki setidaknya 20 karakter ";
            $kode_api = 400;
        }

        return $this->response(array('status' => $status_api, "pesan_api" => $pesan_api), $kode_api);

    }

    public function hapusArticle_post()
    {
        header('Content-type: application/json');
        $request_json = file_get_contents('php://input');
        
        $id = json_decode($request_json)->id;

        $resp = $this->Model_posts->delete($id);
        if($resp){
            $status_api = TRUE;
            $pesan_api = "Artikel baru sudah dihapus";
            $kode_api = 200;
        }else{
            $status_api = TRUE;
            $pesan_api = "Terjadi kesalahan server";
            $kode_api = 400;
        }
        return $this->response(array('status' => $status_api, "pesan_api" => $pesan_api), $kode_api);

    }
    

}