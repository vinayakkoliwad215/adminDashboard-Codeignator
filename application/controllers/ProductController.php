<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

   public function __construct() {
      parent::__construct(); 
      $this->load->model('Product_model', 'product');
      $this->load->database();
      $this->load->helper('url');
      if (!$this->session->userdata('user_logged')) {
            return redirect('login');
      }
   }

   public function index()
   {
      $data['title'] = "Product Manager";
      // $this->load->view('products', $data);
      $this->load->view('layouts/header', $data);
      $this->load->view('layouts/sidebar', $data);
      $this->load->view('products/index', $data);
      $this->load->view('layouts/footer', ['custom_js' => 'assets/js/product.js']);
   }

   public function show_all()
   {
      $products = $this->product->get_all();
      echo json_encode($products);
   }

   public function show($id)
   {
      $product = $this->product->get($id);
      // header('Content-Type: application/json');
      echo json_encode($product);
   }

   public function store()
   {
      $this->product->store();
      echo json_encode(['status' => "success"]);
   }

   public function edit($id)
   {
      $product = $this->product->get($id);
      echo json_encode($product);
   }

   public function update($id)
   {
      $this->product->update($id);
      echo json_encode(['status' => "success"]);
   }

   public function delete($id)
   {
      $this->product->delete($id);
      echo json_encode(['status' => "success"]);
   }
}
