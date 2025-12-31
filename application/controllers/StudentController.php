<?php 
class StudentController extends CI_Controller
{
    public function index()
    {
        $this->load->model('StudentModel','stud');
        //$student = $this->StudentModel->student_data();
        // $student = new StudentModel;
        // $student = $student->student_data();
        $student = $this->stud->student_data();
        
        echo "Student Name is for the " .$student;
    }

    public function show($id)
    {
        //echo $id;
        $this->load->model('StudentModel','stud');
        $select_stud = $this->stud->student_show($id);
        echo $select_stud;

    }
}

?>