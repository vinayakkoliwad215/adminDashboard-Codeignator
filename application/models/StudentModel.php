<?php
class StudentModel extends CI_Model
{
    public function student_data()
    {
        $stud_class = $this->student_class();
        return $stud_name = "vinayak. And his class ".$stud_class;
    }

    private function student_class()
    {
        return $stud_class = "BCA";
    }

    public function student_show($id)
    {
        if($id == '1')
        {
            return $result = "User 1 Vinayak";
        }
        elseif($id == '2')
        {
            return $result = "User 2 Amar";
        }
    }
}
?>