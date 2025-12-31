<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageController extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }
    public function index()
    {
        echo "I am index method PageController and this route is home route";
    }
    public function aboutus()
    {
        $this->load->view('aboutus');
    }

    public function blog($blog_url = "")
    {
        echo "$blog_url";
        $this->load->view("blogview");
    }
}