/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
This script is part of CKEditor's  link Browser extension for Joomla.
This plugin uses parts of JCE extension by Ryan Demmer
*/

//var linkBrowser = new Plugin('linkBrowser', {params: {'key': 'value'}});

var linkBrowser = new Class ({
	Extends: Plugin,
	moreOptions : function(){
		return {};
	},

	initialize : function(options){
	//	throw new Error("my error message");
		this.setOptions(this.moreOptions(), options);
		this.initTree();
		//return this;

	},

	initTree : function(){
			this.tree = new Tree('link-options', {
			collapseTree: true,
			charLength: 50,
			onInit : function(fn){
				fn.apply();
			},
			// When a node is clicked
			onNodeClick : function(e, node){
				e = new Event(e);
				var v, el = e.target;
				if(!el.getParent().hasClass('nolink')){
					v = el.getProperty('href');
					if(v == 'javascript:;') v = node.id;
					//v = el.href == 'javascript:;' ? node.id : el.href;
					v = (document.location.protocol+'//'+document.location.hostname+document.location.pathname).replace('administrator/index.php','')+v;
					window.parent.CKEDITOR.tools.callFunction(window.parent.FuncDialogNr, v);
				}
				if(el.getParent().hasClass('folder')){
					this.tree.toggleNode(e, node);
				}
			}.bind(this),
			// When a node is toggled and loaded
			onNodeLoad : function(node){
				this.tree.toggleLoader(node);
				var query = string.query(string.unescape(node.id));
				var plugin = new Plugin();
				plugin.xhr('getLinks', query, function(o){
					if(o){
						if(!o.error){
							var ul = $(node.id+' ul');
							if(ul){
								//ul.remove();
								ul.dispose();
							}
							this.tree.createNode(o.folders, node);
							this.tree.toggleNodeState(node, true);
						}else{
							alert(o.error);
						}
					}
					this.tree.toggleLoader(node);
				}.bind(this));
			}.bind(this)
		});
	}
});
//linkBrowser.implement(new Options, new Events);
linkBrowser.implement(new Events);
linkBrowser.implement(new Options);
