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
 * The searchmanager class
 *
 * @package   mod_surveypro
 * @copyright 2013 onwards kordan <kordan@mclink.it>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * The class managing the search form for users
 *
 * @package   mod_surveypro
 * @copyright 2013 onwards kordan <kordan@mclink.it>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_surveypro_searchmanager {

    /**
     * @var object Course module object
     */
    protected $cm;

    /**
     * @var object Context object
     */
    protected $context;

    /**
     * @var object Surveypro object
     */
    protected $surveypro;

    /**
     * @var object Form content as submitted by the user
     */
    public $formdata = null;

    /**
     * Class constructor.
     *
     * @param object $cm
     * @param object $context
     * @param object $surveypro
     */
    public function __construct($cm, $context, $surveypro) {
        $this->cm = $cm;
        $this->context = $context;
        $this->surveypro = $surveypro;
    }

    /**
     * Get the searchparamurl.
     *
     * At the submission time of the seach form, define the $searchparamurl to send to view.php
     *
     * @return mixed $searchquery if a search was requested, void otherwise
     */
    public function get_searchparamurl() {
        // Replaced on May 13, 2016
        // $regexp = '~('.SURVEYPRO_ITEMPREFIX.'|'.SURVEYPRO_DONTSAVEMEPREFIX.')_('.SURVEYPRO_TYPEFIELD.'|'.SURVEYPRO_TYPEFORMAT.')_([a-z]+)_([0-9]+)_?([a-z0-9]+)?~';
        $regexp = '~';
        $regexp .= SURVEYPRO_ITEMPREFIX.'_';
        $regexp .= '(?P<type>'.SURVEYPRO_TYPEFIELD.'|'.SURVEYPRO_TYPEFORMAT.')';
        $regexp .= '_';
        $regexp .= '(?P<plugin>[^_]+)';
        $regexp .= '_';
        $regexp .= '(?P<itemid>\d+)';
        $regexp .= '_?';
        $regexp .= '(?P<optional>[\d\w]+)?';
        $regexp .= '~';

        $itemhelperinfo = array();
        foreach ($this->formdata as $elementname => $content) {
            if (preg_match($regexp, $elementname, $matches)) {
                $itemid = $matches['itemid']; // Itemid of the search_form element (or of the search_form family element).
                if (!isset($itemhelperinfo[$itemid])) {
                    $itemhelperinfo[$itemid] = new stdClass();
                    $itemhelperinfo[$itemid]->type = $matches['type'];
                    $itemhelperinfo[$itemid]->plugin = $matches['plugin'];
                    $itemhelperinfo[$itemid]->itemid = $itemid;
                }
                if (!isset($matches['optional'])) {
                    $itemhelperinfo[$itemid]->contentperelement['mainelement'] = $content;
                } else {
                    $itemhelperinfo[$itemid]->contentperelement[$matches['optional']] = $content;
                }
            }
        }

        $searchfields = array();
        foreach ($itemhelperinfo as $iteminfo) {
            if (isset($iteminfo->contentperelement['ignoreme'])) {
                if ($iteminfo->contentperelement['ignoreme']) {
                    // Do not waste your time.
                    continue;
                }
            }
            if (isset($iteminfo->contentperelement['mainelement'])) {
                if ($iteminfo->contentperelement['mainelement'] == SURVEYPRO_IGNOREMEVALUE) {
                    // Do not waste your time.
                    continue;
                }
            }
            $item = surveypro_get_item($this->cm, $this->surveypro, $iteminfo->itemid, $iteminfo->type, $iteminfo->plugin);

            $userdata = new stdClass();
            $item->userform_save_preprocessing($iteminfo->contentperelement, $userdata, true);

            if (!is_null($userdata->content)) {
                $searchfields[$iteminfo->itemid] = $userdata->content;
            }
        }

        if ($searchfields) {
            return serialize($searchfields);
        } else {
            return;
        }
    }
}
