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
 * @package   block_total_enrolled_users
 

 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_total_enrolled_users extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_total_enrolled_users');
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

      
    
$enrolled = $DB->get_records_sql("

SELECT c.id, u.id

FROM {course} c
JOIN {context} ct ON c.id = ct.instanceid
JOIN {role_assignments} ra ON ra.contextid = ct.id
JOIN {user} u ON u.id = ra.userid
JOIN {role} r ON r.id = ra.roleid

where c.id = 3");

$content = count($enrolled);



$this->content = new stdClass;
$this->content->text = "There are $content users in course 3";
$this->content->footer = "";


    }

}