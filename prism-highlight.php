<?php

namespace Grav\Plugin;

use Grav\Common\Inflector;
use \Grav\Common\Plugin;
use \Grav\Common\Page\Page;

class PrismHighlightPlugin extends Plugin
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPageInitialized' => ['onPageInitialized', 0],
            'onShortcodeHandlers' => ['onShortcodeHandlers', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'registerNextGenEditorPlugin' => ['registerNextGenEditorPluginShortcodes', 0],
        ];
    }

    /**
     * Initialize configuration
     */
    public function onPageInitialized()
    {
        if ($this->isAdmin()) {
            return;
        }

        $defaults = (array)$this->config->get('plugins.prism-highlight');

        /** @var Page $page */
        $page = $this->grav['page'];
        // wrong way - kept for compatibility
        if (isset($page->header()->prism)) {
            $this->config->set('plugins.prism-highlight', array_merge($defaults, $page->header()->prism));
        }
        // correct way as documented
        if (isset($page->header()->{'prism-highlight'})) {
            $this->config->set('plugins.prism-highlight', array_merge($defaults, $page->header()->{'prism-highlight'}));
        }
        if ($this->config->get('plugins.prism-highlight.enabled')) {
            $this->enable([
                'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
            ]);
        }

    }

    /**
     * Initialize configuration
     */
    public function onShortcodeHandlers()
    {
        $this->grav['shortcode']->registerAllShortcodes(__DIR__.'/shortcodes');
    }

    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    /**
     * if enabled on this page, load the JS + CSS theme.
     */
    public function onTwigSiteVariables()
    {
        $selected_theme = $this->config->get('plugins.prism-highlight.theme') ?: 'prism-default.css';
        $css = $this->config->get('plugins.prism-highlight.custom.css_location');
        $theme = $this->config->get('plugins.prism-highlight.custom.theme_location');
        $js = $this->config->get('plugins.prism-highlight.custom.js_location');

        if (!file_exists($css)) {
            $css = 'plugin://prism-highlight/css/prism.css';
        }
        if (!file_exists($theme)) {
            $theme = 'plugin://prism-highlight/css/themes/' . $selected_theme;
        }
        if (!file_exists($js)) {
            $js = 'plugin://prism-highlight/js/prism.js';
        }


        $this->grav['assets']->addCss($css);
        $this->grav['assets']->addCss($theme);
        $this->grav['assets']->addJs($js, null, true, null, 'bottom');

        $all_pre_blocks = $this->config->get('plugins.prism-highlight.all-pre-blocks');
        $line_numbers = $this->config->get('plugins.prism-highlight.plugins.line-numbers');
        $command_line = $this->config->get('plugins.prism-highlight.plugins.command-line');

        $inline = "";

        if ($all_pre_blocks || $line_numbers || $command_line) {
            $inline .= "var __prism_nodes = null;\n";
        }

        // Always add at least plain text language
        if ($all_pre_blocks) {
            $inline .= "__prism_nodes = document.querySelectorAll('pre:not([class*=\"language-\"])');\n";
            $inline .= $this->_addJsClass('language-txt');
        }

        // Line Numbers management || Command Line management
        if ($line_numbers || $command_line) {
            $inline .= "__prism_nodes = document.querySelectorAll('pre');\n";

            if ($line_numbers) {
                $inline .= $this->_addJsClass('line-numbers');
            }

            if ($command_line) {
                $inline .= $this->_addJsClass('command-line');
            }
        }

        if ($inline) {
            $this->grav['assets']->addInlineJs($inline, null, 'bottom');
        }

    }

    public function registerNextGenEditorPluginShortcodes($event) {
        $plugins = $event['plugins'];
        $plugins['js'][] = 'plugin://prism-highlight/nextgen-editor/shortcodes/prism/prism.js';
        $plugins['css'][] = 'plugin://prism-highlight/nextgen-editor/shortcodes/prism/prism.css';

        $event['plugins']  = $plugins;
        return $event;
    }

    public static function themeOptions()
    {
        $options = [];

        $theme_files = glob(__dir__ . '/css/themes/*.css');
        foreach ($theme_files as $theme_file) {
            $theme = basename($theme_file);
            $options[$theme] = Inflector::titleize(basename($theme, '.css'));
        }

        return $options;
    }

    private function _addJsClass($class = '') {
        return "__prism_nodes.forEach(function(node) { node.classList.add('" . $class . "'); });\n";
    }
}
