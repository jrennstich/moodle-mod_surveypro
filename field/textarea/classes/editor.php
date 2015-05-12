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
 * @package    mod_surveypro
 * @copyright  2013 onwards kordan <kordan@mclink.it>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->libdir.'/form/editor.php');

class mod_surveypro_mform_editor extends MoodleQuickForm_editor {

    /**
     * All types must have this constructor implemented.
     */
    public function mod_surveypro_mform_editor($elementName=null, $elementLabel=null, $attributes=null, $options=null) {
        parent::MoodleQuickForm_editor($elementName, $elementLabel, $attributes, $options);
    }

    /**
     * Returns type of editor element
     *
     * @return string
     */
    public function getElementTemplateType() {
        return 'default';
    }

    /**
     * What to display when element is frozen.
     *
     * @return empty string
     */
    public function getFrozenHtml() {
        $value = $this->_values['text'];
        $return = strlen($value) ? $value : '&nbsp;';

        return $return.$this->_getPersistantData();
    }
}