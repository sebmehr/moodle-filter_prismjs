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
 * Filter "prismjs"
 *
 * @package    filter_prismjs
 * @copyright  2017 Sébastien Mehr, University of French Polynesia <sebastien.mehr@upf.pf>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class filter_prismjs extends moodle_text_filter {

    public function filter($text, array $options = array()) {
        global $CFG, $COURSE, $PAGE, $languages;

        require_once($CFG->dirroot . '/filter/prismjs/languages.php');

        if (!is_string($text) or empty($text)) {
            // Non-string data can not be filtered anyway.
            return $text;
        }

        // Getting all languages code in a string seperated with |.
        $regextags = implode("|", array_keys($languages));
        $regexperformance = '/\[{2}(code|'.$regextags.')\]{2}/';

        // Performance shortcut - if there is no [[language]] or [[code]] tag, nothing can match.
        if (!preg_match($regexperformance, $text, $matches)) {
            return $text;
        }

        $regexcolor = '/(\[{2}(code|'.$regextags.')\]{2})([\s\S]+?)(\[{2}\/\2\]{2})/';

        if (preg_match_all($regexcolor, $text, $matches, PREG_SET_ORDER)) {

            $courseid       = (isset($COURSE->id)) ? $COURSE->id : null;
            $coursecontext  = context_course::instance($courseid);
            $courseconfig   = get_active_filters($coursecontext->id);

            $colortext = '';

            foreach ($matches as $match) {
                // Handling multiple and/or different [[language]] tags in the same context, for example in a Page.
                for ($i = 0; $i < count($matches); $i++) {
                    // If a [[language]] or [[code]] tag has already been replaced in $text, let's take $colortext.
                    if ($i > 0) {
                        $text = $colortext;
                    }
                    // Getting all informations we need for replacement.
                    $opentag = $matches[$i][1];
                    $code = $matches[$i][2];
                    $script = $matches[$i][3];
                    $closetag = $matches[$i][4];

                    // Setting up language corresponding to the [[language]] tags or filter local settings or general settings.
                    if (array_key_exists($code, $languages)) {
                        $config['language'] = $code;
                    } else if (isset($this->localconfig['language'])) {
                        $config['language'] = $this->localconfig['language'];
                    } else if (isset($courseconfig['language'])) {
                        $config['language'] = $courseconfig['language'];
                    } else {
                        $config['language'] = 'php';
                    }

                    $openreplace = '<pre class="line-numbers language-'.$config['language'].'">';
                    $openreplace .= '<code class="language-'.$config['language'].'">';
                    $closereplace = '</code></pre>';
                    // Replacing [[language]] or [code]] tags with <pre> and <code> tags containing the language-xxxx class.



                    if ($config['language'] == 'markup') {
                        // Avoiding copy/paste markup script in Atto displaying without indentation.
                        $markup = str_replace("<br>", "\n", $script);
                        $colortext = str_replace(array($opentag, $closetag, $script), array($openreplace, $closereplace, $markup), $text);
                    } else {
                        $colortext = str_replace(array($opentag, $closetag,), array($openreplace, $closereplace), $text);
                    }

                }
                // Finally add prism.js script to the page.
                $PAGE->requires->js(new moodle_url($CFG->httpswwwroot . '/filter/prismjs/js/prism.js'));

                return $colortext;
            }
        }
    }
}

/**
 * https://docs.moodle.org/dev/Filter_enable/disable_by_context#Getting_filter_configuration
 *
 * Get the list of active filters, in the order that they should be used
 * for a particular context.
 *
 * @param object $context a context
 * @return array an array where the keys are the filter names and the values are any local
 *      configuration for that filter, as an array of name => value pairs
 *      from the filter_config table. In a lot of cases, this will be an
 *      empty array.
 */
function get_active_filters($contextid) {
    global $DB;

    $sql = "SELECT fc.id, active.FILTER, fc.name, fc.VALUE
            FROM (SELECT f.FILTER
              FROM {filter_active} f
              JOIN {context} ctx ON f.contextid = ctx.id
              WHERE ctx.id IN ($contextid) AND f.FILTER LIKE 'prismjs'
              GROUP BY FILTER
              HAVING MAX(f.active * ctx.depth) > -MIN(f.active * ctx.depth)
              ORDER BY MAX(f.sortorder)) active
            LEFT JOIN {filter_config} fc ON fc.FILTER = active.FILTER AND fc.contextid = $contextid";

    $courseconfig = array();

    if ($results = $DB->get_records_sql($sql, null)) {
        foreach ($results as $res) {
            if ($res->name == "language") {
                $courseconfig['language'] = $res->value;
            }
        }
    }

    return $courseconfig;
}
