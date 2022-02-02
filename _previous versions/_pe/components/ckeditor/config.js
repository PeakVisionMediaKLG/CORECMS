/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/**/

CKEDITOR.editorConfig = function( config ) {
	
	config.filebrowserBrowseUrl = './core/kcfinder/browse.php?opener=ckeditor&type=files';
    config.filebrowserImageBrowseUrl = './core/kcfinder/browse.php?opener=ckeditor&type=images';
    config.filebrowserFlashBrowseUrl = './core/kcfinder/browse.php?opener=ckeditor&type=flash';
    config.filebrowserUploadUrl = './core/kcfinder/upload.php?opener=ckeditor&type=files';
    config.filebrowserImageUploadUrl = './core/kcfinder/upload.php?opener=ckeditor&type=images';
    config.filebrowserFlashUploadUrl = './core/kcfinder/upload.php?opener=ckeditor&type=flash';
	
	config.extraPlugins = 'lineutils';
	config.extraPlugins = 'widget';
	config.extraPlugins = 'btbutton';
    
    config.protectedSource.push( /<i class[\s\S]*?\>/g ); //allows beginning <i> tag
    config.protectedSource.push( /<\/i>/g ); //allows ending </i> tag
};
