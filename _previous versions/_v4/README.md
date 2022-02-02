# core-gen2
New 2021 version of the core content management system

## Core extension guide

* folder                  (named after component/module // use enumeration to determine order of extension)
  * _self/                (folder containing everything that concerns this component/module)
    * ext_content/        (folder for custom php files that "do" stuff, ext.headincludes.php & ext.bodyincludes.php are automatically loaded for right-panel content pages)
    * includes/           (contains custom php files to include before the extension element is included)
    * txt/                (contains a "two-digit language code".json file for all captions used in the extension)
  * ext.config.json       (a json file with basic settings, such as access options)
  * ext.pre.php           (extension code to be executed before its children are called)
  * ext.post.php          (extension code to be executed after its children are called)
  * ext.scripts.js        (extension javascript content included in document head)
  * ext.styles.css        (extension style sheet to include styles for this element and/or its children)
