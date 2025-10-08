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
 * Moodle frontpage.
 *
 * @package    core
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!file_exists('./config.php')) {
    header('Location: install.php');
    die;
}

require_once('config.php');
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->libdir .'/filelib.php');

redirect_if_major_upgrade_required();

// Redirect logged-in users to homepage if required.
$redirect = optional_param('redirect', 1, PARAM_BOOL);

$urlparams = array();
if (!empty($CFG->defaulthomepage) &&
        ($CFG->defaulthomepage == HOMEPAGE_MY || $CFG->defaulthomepage == HOMEPAGE_MYCOURSES) &&
        $redirect === 0
) {
    $urlparams['redirect'] = 0;
}
$PAGE->set_url('/', $urlparams);
$PAGE->set_pagelayout('frontpage');
$PAGE->add_body_class('limitedwidth');
$PAGE->set_other_editing_capability('moodle/course:update');
$PAGE->set_other_editing_capability('moodle/course:manageactivities');
$PAGE->set_other_editing_capability('moodle/course:activityvisibility');

// Prevent caching of this page to stop confusion when changing page after making AJAX changes.
$PAGE->set_cacheable(false);

require_course_login($SITE);

$hasmaintenanceaccess = has_capability('moodle/site:maintenanceaccess', context_system::instance());

// If the site is currently under maintenance, then print a message.
if (!empty($CFG->maintenance_enabled) and !$hasmaintenanceaccess) {
    print_maintenance_message();
}

$hassiteconfig = has_capability('moodle/site:config', context_system::instance());

if ($hassiteconfig && moodle_needs_upgrading()) {
    redirect($CFG->wwwroot .'/'. $CFG->admin .'/index.php');
}

// If site registration needs updating, redirect.
\core\hub\registration::registration_reminder('/index.php');

$homepage = get_home_page();
if ($homepage != HOMEPAGE_SITE) {
    if (optional_param('setdefaulthome', false, PARAM_BOOL)) {
        set_user_preference('user_home_page_preference', HOMEPAGE_SITE);
    } else if (!empty($CFG->defaulthomepage) && ($CFG->defaulthomepage == HOMEPAGE_MY) && $redirect === 1) {
        // At this point, dashboard is enabled so we don't need to check for it (otherwise, get_home_page() won't return it).
        redirect($CFG->wwwroot .'/my/');
    } else if (!empty($CFG->defaulthomepage) && ($CFG->defaulthomepage == HOMEPAGE_MYCOURSES) && $redirect === 1) {
        redirect($CFG->wwwroot .'/my/courses.php');
    } else if ($homepage == HOMEPAGE_URL) {
        redirect(get_default_home_page_url());
    } else if (!empty($CFG->defaulthomepage) && ($CFG->defaulthomepage == HOMEPAGE_USER)) {
        $frontpagenode = $PAGE->settingsnav->find('frontpage', null);
        if ($frontpagenode) {
            $frontpagenode->add(
                get_string('makethismyhome'),
                new moodle_url('/', array('setdefaulthome' => true)),
                navigation_node::TYPE_SETTING);
        } else {
            $frontpagenode = $PAGE->settingsnav->add(get_string('frontpagesettings'), null, navigation_node::TYPE_SETTING, null);
            $frontpagenode->force_open();
            $frontpagenode->add(get_string('makethismyhome'),
                new moodle_url('/', array('setdefaulthome' => true)),
                navigation_node::TYPE_SETTING);
        }
    }
}

// Trigger event.
course_view(context_course::instance(SITEID));

$PAGE->set_pagetype('site-index');
$PAGE->set_docs_path('');
$editing = $PAGE->user_is_editing();
$PAGE->set_title(get_string('home'));
// Hide site name for non-logged users (public view)
if (isloggedin() && !isguestuser()) {
    $PAGE->set_heading($SITE->fullname);
} else {
    $PAGE->set_heading('');
}
$PAGE->set_secondary_active_tab('coursehome');

$siteformatoptions = course_get_format($SITE)->get_format_options();
$modinfo = get_fast_modinfo($SITE);
$modnamesused = $modinfo->get_used_module_names();

// The home page can have acitvities in the block aside. We should
// initialize the course editor before the page structure is rendered.
include_course_ajax($SITE, $modnamesused);

$courserenderer = $PAGE->get_renderer('core', 'course');

if ($hassiteconfig) {
    $editurl = new moodle_url('/course/view.php', ['id' => SITEID, 'sesskey' => sesskey()]);
    $editbutton = $OUTPUT->edit_button($editurl);
    $PAGE->set_button($editbutton);
}

echo $OUTPUT->header();

// Print Section or custom info.
if (!empty($CFG->customfrontpageinclude)) {
    // Pre-fill some variables that custom front page might use.
    $modnames = get_module_types_names();
    $modnamesplural = get_module_types_names(true);
    $mods = $modinfo->get_cms();

    include($CFG->customfrontpageinclude);

} else if ($siteformatoptions['numsections'] > 0) {
    echo $courserenderer->frontpage_section1();
}

echo $courserenderer->frontpage();

if ($editing && has_capability('moodle/course:create', context_system::instance())) {
    echo $courserenderer->add_new_course_button();
}
// Add custom JavaScript for enhanced category functionality
echo '<script>
document.addEventListener("DOMContentLoaded", function() {
    document.addEventListener("click", function(e) {
        var categoryName = e.target.closest(".categoryname");
        if (categoryName) {
            var category = categoryName.closest(".category");
            var link = categoryName.querySelector("a");
            
            if (category && category.classList.contains("with_children")) {
                e.preventDefault();
                
                var content = null;
                var children = category.children;
                for (var i = 0; i < children.length; i++) {
                    if (children[i].classList.contains("content")) {
                        content = children[i];
                        break;
                    }
                }
                
                if (category.classList.contains("collapsed")) {
                    category.classList.remove("collapsed");
                    if (content) {
                        content.style.display = "block";
                        content.style.animation = "slideDown 0.3s ease";
                    }
                } else {
                    category.classList.add("collapsed");
                    if (content) {
                        content.style.display = "none";
                    }
                }
            } else if (link) {
                window.location.href = link.href;
            }
        }
    });
    
    document.addEventListener("click", function(e) {
        if (e.target.matches("[data-action=\\"toggle-all-categories\\"], .collapseexpand")) {
            e.preventDefault();
            var link = e.target;
            var tree = link.closest(".course_category_tree");
            var categories = tree.querySelectorAll(".category.with_children");
            
            if (link.classList.contains("collapse-all") || link.textContent.includes("Collapse")) {
                categories.forEach(function(cat) {
                    cat.classList.add("collapsed");
                    var children = cat.children;
                    for (var i = 0; i < children.length; i++) {
                        if (children[i].classList.contains("content")) {
                            children[i].style.display = "none";
                            break;
                        }
                    }
                });
                link.classList.remove("collapse-all");
                link.textContent = "Expand all";
            } else {
                categories.forEach(function(cat) {
                    cat.classList.remove("collapsed");
                    var children = cat.children;
                    for (var i = 0; i < children.length; i++) {
                        if (children[i].classList.contains("content")) {
                            children[i].style.display = "block";
                            break;
                        }
                    }
                });
                link.classList.add("collapse-all");
                link.textContent = "Collapse all";
            }
        }
    });
    
    var style = document.createElement("style");
    style.textContent = "\\
        @keyframes slideDown {\\
            from { opacity: 0; transform: translateY(-10px); }\\
            to { opacity: 1; transform: translateY(0); }\\
        }\\
        .course_category_tree .category > .content {\\
            transition: all 0.3s ease;\\
        }\\
        .categoryname:hover {\\
            cursor: pointer;\\
        }\\
        .categoryname a {\\
            text-decoration: none;\\
            color: inherit;\\
        }\\
        .categoryname a:hover {\\
            text-decoration: underline;\\
        }\\
        .category:not(.with_children) .categoryname:hover {\\
            background-color: #f0f0f0;\\
            border-radius: 3px;\\
        }\\
        body:not(.userloggedin) #page-header h1,\\
        body:not(.userloggedin) .page-header-headings h1 {\\
            display: none !important;\\
        }\\
        #frontpage-category-names h2,\\
        .frontpage-category-names h2 {\\
            margin-bottom: 10px;\\
        }\\
        .course_category_tree {\\
            background: transparent !important;\\
            border: none !important;\\
            box-shadow: none !important;\\
        }\\
    ";
    document.head.appendChild(style);
});
</script>';

echo $OUTPUT->footer();
