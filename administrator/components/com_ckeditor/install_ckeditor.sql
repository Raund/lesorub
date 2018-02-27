
DELETE FROM #__extensions WHERE element = 'ckeditor' AND name = 'Editor - CKEditor';
          
          

   
INSERT INTO #__extensions (`extension_id`,`name`,`type`,`element`,`folder`,`client_id`,`enabled`,`access`,`protected`,`manifest_cache`,`params`,`custom_data`,`system_data`,`checked_out`,`checked_out_time`,`ordering`,`state`)
     VALUES (
      NULL,
      'Editor - CKEditor',
      'plugin',
      'ckeditor',
      'editors',
      0,
      1,
      1,
      0,
      '',
      "language=en 
       toolbar_frontEnd=Basic 
       toolbar=Full
       Basic_ToolBar=Bold, Italic, -, NumberedList, BulletedList, -, Link, Unlink 
       Advanced_ToolBar=Source, -, Save, NewPage, Preview,- ,Templates, Cut, Copy, Paste, PasteText, PasteFromWord, - ,Print, SpellChecker, Scayt, Undo, Redo, -, Find, Replace, -, SelectAll, RemoveFormat,/, Bold ,Italic, Underline, Strike, -, Subscript, Superscript, NumberedList, BulletedList, -, Outdent, Indent, Blockquote, JustifyLeft, JustifyCenter, JustifyRight, JustifyBlock, Link, Unlink, Anchor, Image, Flash, Table, HorizontalRule, Smiley, SpecialChar, PageBreak, /, Styles, Format, Font, FontSize, TextColor, BGColor, Maximize, ShowBlocks, -, About
      skin=office2003
      Color=#6B6868
      enterMode=1
      shiftEnterMode=2
      style=
      template=
      css=
      templateCss=0
      ckfinder=0
      skinfm=light
      usergroup_access=8
      ",
      '',
      '',
      0,
      '0000-00-00 12:00:00',
      0,
      0
    );

-- DELETE FROM   #__components where name='CKEditor Component' AND `option`='com_ckeditor' ;

-- INSERT INTO #__components VALUES(
  -- NULL,
 -- 'CKEditor Component',
 -- 'option=com_ckeditor',
 -- 0,
 -- 0,
 -- 'option=com_ckeditor',
 -- 'CKEditor Component',
 -- 'com_ckeditor',
 -- 0,
 -- 'components/com_ckeditor/images/ckeditor_ico16.png',
 -- 0,
 -- '',
 -- 1
-- );
