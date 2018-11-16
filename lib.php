<?php
// This file is part of local/coursedeletion
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
 * @package local/coursedeletion
 * @copyright 2014-2018 Liip AG <https://www.liip.ch/>
 * @author Brian King <brian.king@liip.ch>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * This hook is called to add a node to the course administration sideblock menu.
 *
 * @param $settingsnav
 * @param $context
 */
function local_coursedeletion_extend_navigation_course  (navigation_node $parentnode, stdClass $course, context_course $context) {
    global $PAGE;

    // Only add navigation item on non-site course pages.
    if (!$PAGE->course or $PAGE->course->id == 1) {
        return;
    }

    if (!has_capability('local/coursedeletion:course_autodelete_settings', context_course::instance($PAGE->course->id))) {
        return;
    }

    $label = get_string('coursedeletionsettings', 'local_coursedeletion');
    $url = new moodle_url('/local/coursedeletion/coursesettings.php', array('id' => $PAGE->course->id));
    $newnode = navigation_node::create(
        $label,
        $url,
        navigation_node::NODETYPE_LEAF,
        'duplicatecourse',
        'duplicatecourse',
        new pix_icon('i/calendar', $label)
    );
    if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
        $newnode->make_active();
    }
    $parentnode->add_node($newnode);

}