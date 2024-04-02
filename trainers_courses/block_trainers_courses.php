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
 * @package   block_trainers_courses
 

 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_trainers_courses extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_trainers_courses');
    }

    function has_config(){
        return true;

  }


  public function get_content() {
    if ($this->content !== null) {
        return $this->content;
    }

    global $DB, $USER;

    $this->content = new stdClass();

    // Fetch trainers and their courses
    $sql = "SELECT DISTINCT c.id, c.fullname
            FROM {role_assignments} ra
            JOIN {context} cx ON cx.id = ra.contextid
            JOIN {course} c ON c.id = cx.instanceid
            JOIN {user} u ON u.id = ra.userid
            WHERE ra.roleid = ?
            AND cx.contextlevel = ?
            AND ra.userid = ?";

    $params = array(3, 50, $USER->id); // Assuming roleid = 3 for trainers and contextlevel = 50 for courses

    $trainers_courses = $DB->get_records_sql($sql, $params);

    $content = '<style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
                th, td {
                    padding: 8px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                }
                th {
                    background-color: #f2f2f2;
                }
                td:first-child {
                    padding-right: 20px; /* Add space to the right of the first column */
                }
                </style>';
    $content .= '<table>';
    $content .= '<tr><th>Course Name</th><th>Reporting Dashboard</th></tr>';

    foreach ($trainers_courses as $course) {
        $course_url = new moodle_url('/course/view.php', array('id' => $course->id));
        $reporting_url = new moodle_url('/report.php', array('id' => $course->id)); // Assuming the reporting dashboard URL structure
        $content .= '<tr><td><a href="' . $course_url . '">' . $course->fullname . '</a></td><td><a href="' . $reporting_url . '">Reporting</a></td></tr>';
    }

    $content .= '</table>';

    $this->content->text = $content;
    $this->content->footer = '';

    return $this->content;
}
}
