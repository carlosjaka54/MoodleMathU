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

namespace theme_boost\output;

use core_course_category;
use coursecat_helper;
use html_writer;
use moodle_url;

defined('MOODLE_INTERNAL') || die;

/**
 * Custom course renderer for MoodleMathU with enhanced category display
 *
 * @package    theme_boost
 * @copyright  2024 MoodleMathU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_course_renderer extends \core_course_renderer {

    /**
     * Renders HTML to display particular course category - enhanced version with better icons
     *
     * @param coursecat_helper $chelper various display options
     * @param core_course_category $coursecat
     * @param int $depth depth of this category in the current tree
     * @return string
     */
    protected function coursecat_category(coursecat_helper $chelper, $coursecat, $depth) {
        // Open category tag
        $classes = array('category');
        if (empty($coursecat->visible)) {
            $classes[] = 'dimmed_category';
        }
        if ($chelper->get_subcat_depth() > 0 && $depth >= $chelper->get_subcat_depth()) {
            // Do not load content
            $categorycontent = '';
            $classes[] = 'notloaded';
            if ($coursecat->get_children_count() ||
                    ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_COLLAPSED && $coursecat->get_courses_count())) {
                $classes[] = 'with_children';
                $classes[] = 'collapsed';
            }
        } else {
            // Load category content
            $categorycontent = $this->coursecat_category_content($chelper, $coursecat, $depth);
            $classes[] = 'loaded';
            if (!empty($categorycontent)) {
                $classes[] = 'with_children';
                // Category content loaded with children.
                $this->categoryexpandedonload = true;
            }
        }

        // Make sure JS file to expand category content is included.
        $this->coursecat_include_js();

        $content = html_writer::start_tag('div', array(
            'class' => join(' ', $classes),
            'data-categoryid' => $coursecat->id,
            'data-depth' => $depth,
            'data-showcourses' => $chelper->get_show_courses(),
            'data-type' => self::COURSECAT_TYPE_CATEGORY,
        ));

        // Category name with enhanced styling
        $categoryname = $coursecat->get_formatted_name();
        $categoryname = html_writer::link(new moodle_url('/course/index.php',
                array('categoryid' => $coursecat->id)),
                $categoryname);
        
        if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_COUNT
                && ($coursescount = $coursecat->get_courses_count())) {
            $categoryname .= html_writer::tag('span', ' ('. $coursescount.')',
                    array('title' => get_string('numberofcourses'), 'class' => 'numberofcourse'));
        }

        // Add expand/collapse icon for categories with children
        $expandicon = '';
        if ($coursecat->get_children_count() > 0 || 
            ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_COLLAPSED && $coursecat->get_courses_count())) {
            
            $iconclass = 'category-toggle-icon';
            if (in_array('collapsed', $classes)) {
                $iconclass .= ' collapsed';
                $expandicon = html_writer::tag('span', '', array(
                    'class' => $iconclass,
                    'data-toggle' => 'expand',
                    'title' => get_string('expand', 'moodle')
                ));
            } else {
                $expandicon = html_writer::tag('span', '', array(
                    'class' => $iconclass,
                    'data-toggle' => 'collapse', 
                    'title' => get_string('collapse', 'moodle')
                ));
            }
        }

        $content .= html_writer::start_tag('div', array('class' => 'info'));
        $content .= html_writer::tag(($depth > 1) ? 'h4' : 'h3', 
            $expandicon . $categoryname, 
            array('class' => 'categoryname aabtn'));
        $content .= html_writer::end_tag('div'); // .info

        // Add category content to the output
        $content .= html_writer::tag('div', $categorycontent, array('class' => 'content'));

        $content .= html_writer::end_tag('div'); // .category

        // Return the course category tree HTML
        return $content;
    }

    /**
     * Returns HTML to display a tree of subcategories and courses in the given category
     * Enhanced version with better styling and structure
     *
     * @param coursecat_helper $chelper various display options
     * @param core_course_category $coursecat top category
     * @return string
     */
    protected function coursecat_tree(coursecat_helper $chelper, $coursecat) {
        // Reset the category expanded flag for this course category tree first.
        $this->categoryexpandedonload = false;
        $categorycontent = $this->coursecat_category_content($chelper, $coursecat, 0);
        if (empty($categorycontent)) {
            return '';
        }
    
        // Start content generation
        $content = '';
    
        // Check if the category content contains subcategories with children's content loaded.
        if ($coursecat->get_children_count()) {
            $classes = array(
                'collapseexpand', 'aabtn'
            );
    
            // Check if we need to expand or collapse all categories
            if ($this->categoryexpandedonload) {
                $classes[] = 'collapse-all';
                $linkname = get_string('collapseall');
            } else {
                $linkname = get_string('expandall');
            }
    
            // Only show the collapse/expand if there are children to expand.
            $content .= html_writer::start_tag('div', array('class' => 'collapsible-actions'));
            $content .= html_writer::link('#', $linkname, array(
                'class' => implode(' ', $classes),
                'data-action' => 'toggle-all-categories'
            ));
            $content .= html_writer::end_tag('div'); // .collapsible-actions
            $this->page->requires->strings_for_js(array('collapseall', 'expandall'), 'moodle');
        }
    
        // Only output the category content (without the parent div).
        $content .= html_writer::tag('div', $categorycontent, array('class' => 'content'));
    
        return $content;
    }

    /**
     * Include the relevant javascript and language strings for the course category tree
     * Enhanced version with additional functionality
     */
    protected function coursecat_include_js() {
        global $CFG;
        
        // Include the original JS
        parent::coursecat_include_js();
        
        // Add our custom JavaScript for enhanced category functionality
        $this->page->requires->js_call_amd('theme_boost/category_tree', 'init');
        
        // Add required language strings
        $this->page->requires->strings_for_js(array(
            'expand',
            'collapse',
            'loading'
        ), 'moodle');
    }

    /**
     * Renders the list of categories for front page - enhanced version
     *
     * @return string
     */
    public function frontpage_categories_list() {
        global $CFG;
        
        $tree = core_course_category::top();
        if (!$tree->get_children_count()) {
            return '';
        }
        
        $chelper = new coursecat_helper();
        $chelper->set_subcat_depth($CFG->maxcategorydepth)->
                set_show_courses(self::COURSECAT_SHOW_COURSES_COUNT)->
                set_categories_display_options(array(
                    'limit' => $CFG->coursesperpage,
                    'viewmoreurl' => new moodle_url('/course/index.php',
                            array('browse' => 'categories', 'page' => 1))
                ))->
                set_attributes(array('class' => 'frontpage-category-names enhanced-categories'));
        
        return $this->coursecat_tree($chelper, $tree);
    }
}
