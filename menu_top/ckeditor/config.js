/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'br';
	// config.uiColor = '#AADC6E';

        config.toolbar = 'Full';

    config.toolbar_Full =
    [
        ['Source','-','Save','NewPage'],
        ['Cut','Copy','Paste'],
        ['Undo','Redo','-','Find','Replace'],
        '/',
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        ['NumberedList','BulletedList','-','Outdent','Indent'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['BidiLtr', 'BidiRtl'],
        ['Link','Unlink','Anchor'],
        ['Image','Flash','Table','Smiley'],
        '/',
        ['Styles','Format','Font','FontSize'],
        ['TextColor','BGColor'],
        ['Maximize', 'ShowBlocks']
    ];
};
