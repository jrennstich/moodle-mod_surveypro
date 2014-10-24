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
 * @package    surveyprotemplate
 * @subpackage attls
 * @copyright  2013 onwards kordan <kordan@mclink.it>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/mod/surveypro/template/collesactualpreferred/lib.php');

$options = array(
    SURVEYPROTEMPLATE_COLLESACTUALPREFERREDUSERADIO => get_string('useradio', 'surveyprotemplate_collesactualpreferred'),
    SURVEYPROTEMPLATE_COLLESACTUALPREFERREDUSESELECT => get_string('useselect', 'surveyprotemplate_collesactualpreferred'),
);

$name = new lang_string('itemstyle', 'surveyprotemplate_collesactualpreferred');
$description = new lang_string('itemstyle_desc', 'surveyprotemplate_collesactualpreferred');
$settings->add(new admin_setting_configselect('surveyprotemplate_collesactualpreferred/itemstyle', $name, $description, 0, $options));
