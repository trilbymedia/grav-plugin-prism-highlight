# Grav Prism Highlighter Plugin

`Prism Highlighter` is a [Grav](http://github.com/getgrav/grav) plugin that adds simple and powerful code highlighting functionality utilizing the [Prism.js](http://prismjs.com/) syntax highlighter.

# Installation

Installing the Highlight plugin can be done in one of two ways. Our GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

## GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's Terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install prism-highlight

This will install the Highlight plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/prism-highlight`.

## Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `prism-highlight`. You can find these files either on [GitHub](https://github.com/getgrav/grav-plugin-prism-highlight) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/prism-highlight


# Languages included

Prism.js supports currently [176 languages](http://prismjs.com/#languages-list), at the time of this edit, but the ones included in this specific version are:

* markup
* html
* xml
* bbcode / shortcode
* svg
* mathml
* css
* css-extras
* clike
* javascript, js
* apacheconf
* bash, shell
* coffeescript, coffee
* diff
* docker, dockerfile
* git
* go
* java
* json
* json5
* less
* lua
* markdown, md
* php
* php-extras
* python, py
* regex
* ruby, rb
* sass
* scss
* sql
* twig
* yaml, yml

# Plugins Included

This build of Prism also includes the following plugins:

* Line Highlight
* Line Numbers
* Command Line
* Toolbar
* Copy to Clipboard

# Basic Usage

In your markdown, you can create a block of code, and assign the language to it. You can choose between the list above.

Example using regular markdown fenced code syntax:

```php
  ```php
  <?php

  namespace Grav\Plugin;

  use \Grav\Common\Plugin;
  use \Grav\Common\Grav;
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
          ];
      }
  }
```

# Advanced Usage

To get access to advanced options that can be set individually, you can use the included `[prism][/prism]` shortcode:

For line numbers:

```
[prism classes="language-twig line-numbers"]
{% set payload = {frontmatter: page.header, content: page.content}  %}
{{ payload|json_encode|raw }}
[/prism]
```

You can also now add the `linkable-line-numbers` class to make the line numbers directly linkable.  You need to provide an `id` on the Prism element so that there is something to link against.

For example:

```
[prism classes="language-twig line-numbers linkable-line-numbers" id="twig-example"]
{% set payload = {frontmatter: page.header, content: page.content}  %}
{{ payload|json_encode|raw }}
[/prism]
```

For a command Prompt:

If you don't provide a custom prompt, it will default to `$` for the command prompt.  Provide a custom prompt with the `cl-prompt` attribute.

```
[prism classes="language-bash command-line" cl-prompt="\[foo@localhost\] $"]
cd ~/webroot
git clone -b master https://github.com/getgrav/grav.git
[/prism]
```

You can also specify certain lines as output (won't be prefixed by prompt) using the `cl-output` attribute:

```
[prism classes="language-bash command-line" cl-prompt="[root@localhost]" cl-output="2-6"]
ls -la
total 2
drwxr-xr-x   2 chris  chris     11 Jan 10 16:48 .
drwxr--r-x  45 chris  chris     92 Feb 14 11:10 ..
-rwxr-xr-x   1 chris  chris    444 Aug 25  2013 backup
-rwxr-xr-x   1 chris  chris    642 Jan 17 14:42 deploy
[/prism]
```

Alternatively you can use the `cl-filter-putput` to provide a lines with a specific prefix to filter out.  For example:

```
[prism classes="language-bash command-line" cl-prompt="[root@localhost]" cl-filter-output=">>"]
ls -la
>>total 2
>>drwxr-xr-x   2 chris  chris     11 Jan 10 16:48 .
>>drwxr--r-x  45 chris  chris     92 Feb 14 11:10 ..
>>-rwxr-xr-x   1 chris  chris    444 Aug 25  2013 backup
>>-rwxr-xr-x   1 chris  chris    642 Jan 17 14:42 deploy
[/prism]
```

For highlighting specific lines 2 and 4:

```
[prism classes="language-yaml" highlight="2,4"]
enabled: true
theme: prism-base16-ocean.dark.css
all-pre-blocks: true
plugins:
    line-numbers: false
    command-line: false
    command-line-prompt: '$'
[/prism]
```

Find out more about these options by checking out the [Prism.js plugins page](https://prismjs.com/#plugins).


# Git File Support

If you provide a `git="<url>"` parameter in the shortcode, the plugin will try to retrieve the 'raw' version of this file.  For example:

```
[prism git="https://github.com/getgrav/grav/blob/develop/system/router.php" classes="language-php line-numbers linkable-line-numbers" id="grav-router"]
[/prism]
```

You can also provide the **raw** version directly:

```
[prism git="https://raw.githubusercontent.com/getgrav/grav/develop/system/router.php" classes="language-php line-numbers linkable-line-numbers" id="grav-router"]
[/prism]
```

You can also slice the file to only show specific lines by passing a query parameter to the URL:

* `slice=0:-2`	Show the first line up to and including the second to last line
* `slice=24:100`	Show lines 24 through 100
* `slice=0`	Show only the first line of the file

```
[prism git="https://github.com/getgrav/grav/blob/develop/system/router.php?slice=10:18" classes="language-php line-numbers linkable-line-numbers" id="grav-router"]
[/prism]
```

# Configuration

Configuration shall be set in `config/plugins/prism-highlight.yaml`.

```yaml
enabled: true
theme: prism-base16-ocean.dark.css
all-pre-blocks: true
custom:
    js_location: 'user://data/prism-highlight/prism.js'
    css_location: 'user://data/prism-highlight/prism.css'
    theme_location: 'user://data/prism-highlight/custom-theme.css'
plugins:
    line-numbers: false
    command-line: false
    command-line-prompt: '$'
```

You can also override configuration settings at the page level by prefixing options with `prism-highlight:`. For example you could set a different theme, and turning on line numbers on a particular page with:

```yaml
title: My Page
prism-highlight:
    theme: base16-duotone-dark.light.css
    plugins:
        line-numbers: true
```


### Themes

The themes available are:

```
base16-duotone-dark.dark.css
base16-duotone-dark.light.css
base16-duotone-darkdesert.dark.css
base16-duotone-darkearth.dark.css
base16-duotone-darkearth.light.css
base16-duotone-darkforest.dark.css
base16-duotone-darkforest.light.css
base16-duotone-darkpark.dark.css
base16-duotone-darkpool.dark.css
base16-duotone-darkpool.light.css
base16-duotone-darksea.dark.css
base16-duotone-darksea.light.css
base16-duotone-darkspace.dark.css
base16-duotone-darkspace.light.css
prism-a11y-dark.css
prism-atelier-cave-dark.css
prism-atelier-cave-light.css
prism-atelier-dune-dark.css
prism-atelier-dune-light.css
prism-atelier-estuary-dark.css
prism-atelier-estuary-light.css
prism-atelier-forest-dark.css
prism-atelier-forest-light.css
prism-atelier-heath-dark.css
prism-atelier-heath-light.css
prism-atelier-lakeside-dark.css
prism-atelier-lakeside-light.css
prism-atelier-plateau-dark.css
prism-atelier-plateau-light.css
prism-atelier-savanna-dark.css
prism-atelier-savanna-light.css
prism-atelier-seaside-dark.css
prism-atelier-seaside-light.css
prism-atelier-sulphurpool-dark.css
prism-atelier-sulphurpool-light.css
prism-atom-dark.css
prism-base16-3024.dark.css
prism-base16-3024.light.css
prism-base16-apathy.dark.css
prism-base16-apathy.light.css
prism-base16-ashes.dark.css
prism-base16-ashes.light.css
prism-base16-ateliercave.dark.css
prism-base16-ateliercave.light.css
prism-base16-atelierdune.dark.css
prism-base16-atelierdune.light.css
prism-base16-atelierestuary.dark.css
prism-base16-atelierestuary.light.css
prism-base16-atelierforest.dark.css
prism-base16-atelierforest.light.css
prism-base16-atelierheath.dark.css
prism-base16-atelierheath.light.css
prism-base16-atelierlakeside.dark.css
prism-base16-atelierlakeside.light.css
prism-base16-atelierplateau.dark.css
prism-base16-atelierplateau.light.css
prism-base16-ateliersavanna.dark.css
prism-base16-ateliersavanna.light.css
prism-base16-atelierseaside.dark.css
prism-base16-atelierseaside.light.css
prism-base16-ateliersulpherpool.dark.css
prism-base16-ateliersulpherpool.light.css
prism-base16-ateliersulphurpool.dark.css
prism-base16-ateliersulphurpool.light.css
prism-base16-bespin.dark.css
prism-base16-bespin.light.css
prism-base16-brewer.dark.css
prism-base16-brewer.light.css
prism-base16-bright.dark.css
prism-base16-bright.light.css
prism-base16-chalk.dark.css
prism-base16-chalk.light.css
prism-base16-codeschool.dark.css
prism-base16-codeschool.light.css
prism-base16-colors.dark.css
prism-base16-colors.light.css
prism-base16-default.dark.css
prism-base16-default.light.css
prism-base16-eighties.dark.css
prism-base16-eighties.light.css
prism-base16-embers.dark.css
prism-base16-embers.light.css
prism-base16-flat.dark.css
prism-base16-flat.light.css
prism-base16-google.dark.css
prism-base16-google.light.css
prism-base16-grayscale.dark.css
prism-base16-grayscale.light.css
prism-base16-greenscreen.dark.css
prism-base16-greenscreen.light.css
prism-base16-harmonic16.dark.css
prism-base16-harmonic16.light.css
prism-base16-hopscotch.dark.css
prism-base16-hopscotch.light.css
prism-base16-isotope.dark.css
prism-base16-isotope.light.css
prism-base16-londontube.dark.css
prism-base16-londontube.light.css
prism-base16-marrakesh.dark.css
prism-base16-marrakesh.light.css
prism-base16-mocha.dark.css
prism-base16-mocha.light.css
prism-base16-monokai.dark.css
prism-base16-monokai.light.css
prism-base16-ocean.dark.css
prism-base16-ocean.light.css
prism-base16-paraiso.dark.css
prism-base16-paraiso.light.css
prism-base16-pop.dark.css
prism-base16-pop.light.css
prism-base16-railscasts.dark.css
prism-base16-railscasts.light.css
prism-base16-shapeshifter.dark.css
prism-base16-shapeshifter.light.css
prism-base16-solarized.dark.css
prism-base16-solarized.light.css
prism-base16-summerfruit.dark.css
prism-base16-summerfruit.light.css
prism-base16-tomorrow.dark.css
prism-base16-tomorrow.light.css
prism-base16-twilight.dark.css
prism-base16-twilight.light.css
prism-base2tone-cave-dark.css
prism-base2tone-cave-light.css
prism-base2tone-desert-dark.css
prism-base2tone-desert-light.css
prism-base2tone-drawbridge-dark.css
prism-base2tone-drawbridge-light.css
prism-base2tone-earth-dark.css
prism-base2tone-earth-light.css
prism-base2tone-evening-dark.css
prism-base2tone-evening-light.css
prism-base2tone-forest-dark.css
prism-base2tone-forest-light.css
prism-base2tone-heath-dark.css
prism-base2tone-heath-light.css
prism-base2tone-lake-dark.css
prism-base2tone-lake-light.css
prism-base2tone-meadow-dark.css
prism-base2tone-meadow-light.css
prism-base2tone-morning-dark.css
prism-base2tone-morning-light.css
prism-base2tone-pool-dark.css
prism-base2tone-pool-light.css
prism-base2tone-sea-dark.css
prism-base2tone-sea-light.css
prism-base2tone-space-dark.css
prism-base2tone-space-light.css
prism-base2tone-suburb-dark.css
prism-base2tone-suburb-light.css
prism-cb.css
prism-coldark-cold.css
prism-coldark-dark.css
prism-coy-without-shadows.css
prism-coy.css
prism-darcula.css
prism-dark.css
prism-dracula.css
prism-duotone-dark.css
prism-duotone-earth.css
prism-duotone-forest.css
prism-duotone-light.css
prism-duotone-sea.css
prism-duotone-space.css
prism-funky.css
prism-ghcolors.css
prism-gruvbox-dark.css
prism-gruvbox-light.css
prism-holi-theme.css
prism-hopscotch.css
prism-laserwave.css
prism-lucario.css
prism-material-dark.css
prism-material-light.css
prism-material-oceanic.css
prism-night-owl.css
prism-nord.css
prism-okaidia.css
prism-one-dark.css
prism-one-light.css
prism-pojoaque.css
prism-shades-of-purple.css
prism-solarized-dark-atom.css
prism-solarizedlight.css
prism-synthwave84.css
prism-tomorrow.css
prism-twilight.css
prism-vs.css
prism-vsc-dark-plus.css
prism-xonokai.css
prism-z-touch.css
```

Check out a [live test](http://prismjs.com/test.html) or a [live demo](http://prismjs.com/index.html#examples).

## Customizaton of languages, plugins and built-in themes

To customize the Prism you will need to customize the `prism.js` file.  This requires cloning our Forked repository (it contains some extra languages and styling tweaks) from: https://github.com/getgrav/prism

Then run the following commands:

```shell
npm ci
npm run build
npm run start
```

The second command starts a built-in webserver.  Locate the `prism.js` file included in this plugin, and view the source, Find the build URL and paste that into your browser.  It should look something like:

```
http://127.0.0.1:8080/download.html#themes=prism&languages=markup+css+clike+javascript+apacheconf+bash+bbcode+c+csharp+cpp+coffeescript+css-extras+diff+docker+ecscript+git+go+java+json+json5+less+lua+markdown+markup-templating+php+php-extras+python+regex+ruby+sass+scss+sql+twig+yaml&plugins=line-highlight+line-numbers+command-line+toolbar+copy-to-clipboard
```

This pre-configures the languages, plugins, etc. 

Make your changes, including adding additional languages, plugins etc.  Then click **DOWNLOAD JS** and **DOWNLOAD CSS** buttons and upload your copies to a safe location, e.g. `/user/data/prims-highlight/`.

You can then edit the configuration of the `prism-highlight` plugin and point the `custom.js_location` and `custom.css_location` options to the custom file locations (default is already `user://data/prism-highlight` folder).
