<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for editing HTML block instances.
 *
 * @package   block_coursecategories
 

 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_coursecategories extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_coursecategories');
    }

    function has_config(){
        return true;

  }


 function get_content() {
    global $DB;
      
       if ($this->content  !== NULL) {
           return $this->content;
       }
   

       $content='';

        $courses = $DB-> get_records('course_categories');
       $table=new html_table();
       $table->head=array('Categories', 'Number of course count', );
    foreach ($courses as $course) {
       $name=$course->name;
         $coursecount=$course->coursecount;
         $table->data[]=array($name, $coursecount);
    }
    $content .=html_writer::table($table);

      


$this->content = new stdClass;
$this->content->text = $content;
$this->content->footer = "";


 
}
}