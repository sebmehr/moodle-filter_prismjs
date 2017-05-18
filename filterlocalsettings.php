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
 * Local administration pages.
 *
 * @package     filter_prismjs
 * @category    admin
 * @copyright   2017 Sébastien Mehr, University of French Polynesia <sebastien.mehr@upf.pf>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/filter/prismjs/languages.php');

class prismjs_filter_local_settings_form extends filter_local_settings_form {

    protected function definition_inner($mform) {
        global $languages;
        $mform->addElement('select',
                           'language',
                           get_string('language', 'filter_prismjs'),
                           $languages
                          );
    }
}
