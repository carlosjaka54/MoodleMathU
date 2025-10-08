/**
 * Enhanced category tree functionality for MoodleMathU
 *
 * @module     theme_boost/category_tree
 * @copyright  2024 MoodleMathU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/str'], function($, str) {
    'use strict';

    /**
     * Initialize the enhanced category tree functionality
     */
    var init = function() {
        
        // Handle individual category toggle
        $(document).on('click', '.categoryname', function(e) {
            e.preventDefault();
            var $category = $(this).closest('.category');
            var $content = $category.find('> .content');
            var $icon = $(this).find('.category-toggle-icon');
            
            if ($category.hasClass('with_children')) {
                if ($category.hasClass('collapsed')) {
                    // Expand category
                    $category.removeClass('collapsed');
                    $content.slideDown(300);
                    $icon.removeClass('collapsed');
                    $icon.attr('data-toggle', 'collapse');
                    str.get_string('collapse', 'moodle').done(function(s) {
                        $icon.attr('title', s);
                    });
                } else {
                    // Collapse category
                    $category.addClass('collapsed');
                    $content.slideUp(300);
                    $icon.addClass('collapsed');
                    $icon.attr('data-toggle', 'expand');
                    str.get_string('expand', 'moodle').done(function(s) {
                        $icon.attr('title', s);
                    });
                }
            }
        });

        // Handle expand/collapse all functionality
        $(document).on('click', '[data-action="toggle-all-categories"]', function(e) {
            e.preventDefault();
            var $link = $(this);
            var $tree = $link.closest('.course_category_tree');
            var $categories = $tree.find('.category.with_children');
            
            if ($link.hasClass('collapse-all')) {
                // Collapse all categories
                $categories.addClass('collapsed');
                $categories.find('> .content').slideUp(300);
                $categories.find('.category-toggle-icon').addClass('collapsed');
                
                $link.removeClass('collapse-all');
                str.get_string('expandall', 'moodle').done(function(s) {
                    $link.text(s);
                });
            } else {
                // Expand all categories
                $categories.removeClass('collapsed');
                $categories.find('> .content').slideDown(300);
                $categories.find('.category-toggle-icon').removeClass('collapsed');
                
                $link.addClass('collapse-all');
                str.get_string('collapseall', 'moodle').done(function(s) {
                    $link.text(s);
                });
            }
        });

        // Add keyboard navigation support
        $(document).on('keydown', '.categoryname', function(e) {
            if (e.which === 13 || e.which === 32) { // Enter or Space
                e.preventDefault();
                $(this).click();
            }
        });

        // Add ARIA attributes for accessibility
        $('.category.with_children > .info > .categoryname').each(function() {
            var $this = $(this);
            var $category = $this.closest('.category');
            var categoryId = $category.data('categoryid');
            var contentId = 'category-content-' + categoryId;
            
            $this.attr({
                'role': 'button',
                'aria-expanded': !$category.hasClass('collapsed'),
                'aria-controls': contentId,
                'tabindex': '0'
            });
            
            $category.find('> .content').attr('id', contentId);
        });

        // Update ARIA attributes when categories are toggled
        $(document).on('click', '.categoryname', function() {
            var $this = $(this);
            var $category = $this.closest('.category');
            
            if ($category.hasClass('with_children')) {
                setTimeout(function() {
                    $this.attr('aria-expanded', !$category.hasClass('collapsed'));
                }, 50);
            }
        });

        // Add loading state for AJAX-loaded categories
        $(document).on('click', '.category.notloaded > .info > .categoryname', function() {
            var $category = $(this).closest('.category');
            var $content = $category.find('> .content');
            
            if ($content.is(':empty')) {
                str.get_string('loading', 'moodle').done(function(s) {
                    $content.html('<div class="loading-indicator">' + s + '...</div>');
                });
            }
        });

        // Smooth animations
        $('.category > .content').css({
            'transition': 'all 0.3s ease',
            'overflow': 'hidden'
        });

        // Initialize collapsed state properly
        $('.category.collapsed > .content').hide();
        
        // Add hover effects
        $('.categoryname').hover(
            function() {
                $(this).closest('.info').addClass('hover');
            },
            function() {
                $(this).closest('.info').removeClass('hover');
            }
        );
    };

    return {
        init: init
    };
});
