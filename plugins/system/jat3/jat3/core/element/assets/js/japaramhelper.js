/*
# ------------------------------------------------------------------------
# JA T3v2 Plugin - Template framework for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - GNU/GPL V2, http://www.gnu.org/licenses/gpl2.html. For details 
# on licensing, Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

JAFormController = new Class( { 	
	initialize : function( control, options ){
		this.options =  $extend({ val	: '', els_str: '', 'hideRow':true, 'group': 'params' }, options||{ } );		
		
		var group = $(document.adminForm)[this.options.group+'['+control+']'];
		
		els_str = this.options.els_str.split(',');
		this.items = [];
		els_str.each(function (el_name){
			el = $(document.adminForm)[this.options.group+'['+el_name.trim()+']'];
			if(!el){
				el = $(document.adminForm)[this.options.group+'['+el_name.trim()+'][]'];
			}
			if(el){
				this.items.push(el);
			}
		}, this);
		
		this.group = group;
		
		if(group){
			var type = $type(group);
			if(type == 'collection' || type == 'array'){
				for(var i=0; i<group.length; i++){
					var subgroup = $(group[i]);
					
					if (subgroup.type == 'select-one' || subgroup.type == 'select-multiple'){
						subgroup.addEvent('change', function(){
													this.update(this.options.val);
									}.bind(this));
					}
					else{
						subgroup.addEvent('click', function(){
													this.update(this.options.val);
									}.bind(this));
					}
				}				
			}
			else{
				var group = $(group)
				if (group.type == 'select-one' || group.type == 'select-multiple'){
					group.addEvent('change', function(){
												this.update(this.options.val);
								}.bind(this));
				}
				else{
					group.addEvent('click', function(){
												this.update(this.options.val);
								}.bind(this));
				}
			}
		}
		return;		
	},

	
	update: function(_default){
		if (!this.items || !this.items.length) return;
		this.items.each( function( item ) {
			type = $type(item);
			var disabled = true;
			var display = '';
			if( $type(this.group) == 'label' ) return;
			
			if($type(this.group) == 'collection' || $type(this.group) == 'array'){
				for(var i=0; i<this.group.length; i++){
					var subgroup = this.group[i];
					if(!_default || ((subgroup.getStyle ('display') != 'none' && !subgroup.disabled) && (subgroup.id && subgroup.value.trim()==_default && ( (subgroup.type=='radio' && subgroup.checked) || (subgroup.type!='radio')  )) )){
						display = '';
						disabled = false;
						break;
					}
					else{
						display = 'none';
						disabled = true;
					}
				}				
			}
			else{		
				if (!_default || ( (this.group.getStyle ('display') != 'none' && !this.group.disabled) && (this.group.value.trim()==_default))){
					display = '';
					disabled = false;
				}else{
					display = 'none';
					disabled = true;
				}				
			}
			
			if(type == 'collection' || type == 'array'){
				for(var i=0; i<item.length; i++){
					subitem = $(item[i]);
					if( this.options.hideRow == 'true' ) { 
						var parent = this.getParentByTagName(subitem, "tr" );
						if( $defined(parent) ){
							parent.setStyles( {"display":display} );
							if(disabled){
								parent.rel = "jarel";
							}
						}
					}else {
						subitem.disabled = disabled;
						$(subitem).fireEvent ('change');
						$(subitem).fireEvent ('click');
					}
				}
			}
			else{
				if( this.options.hideRow == 'true' ) { 
					var parent = this.getParentByTagName(item, "tr" );
					if( $defined(parent) ){
						parent.setStyles( {"display":display} );
						if(disabled){
							parent.rel = "jarel";
						}
					}
				}else {
					item.disabled = disabled;
					$(item).fireEvent ('change');
					$(item).fireEvent ('click');
				}
			}
		}.bind(this) );
		
		this.updateHeight (this.group);
	},
	
	
	updateHeight: function () {
		_dparent = this.getParentByTagName(this.group, 'div');
		_tparent = this.getParentByTagName(this.group, 'table');
		if (_tparent && _dparent && _dparent.hasClass('content') && _dparent.offsetHeight) _dparent.setStyle('height', _tparent.offsetHeight);
		window.fireEvent('resize');
	},
	
	getParentByTagName: function (el, tag) {
		if($(el)){
			var parent = $(el).getParent();
				if(parent){
				while (!parent || parent.tagName.toLowerCase() != tag.toLowerCase()) {
					parent = parent.getParent();
				}
				return parent;
			}
		}
		return null;
	}
});


var japaramhelpergroups = new Array();

function initjapramhelpergroup(control, options) {
	japaramhelpergroups.push (new JAFormController (control, options));
}

window.addEvent('load', function() {
	document.adminForm.onsubmit = function(){
		japaramhelpergroups.each (function(group){
			if (group.options.hideRow=='false')	group.update();
		})
	};
	setTimeout(function() {
		japaramhelpergroups.each (function(group){	
			if (group.options.hideRow=='true')	group.updateHeight();
		});
	},400);
});

function addClassToTR(){
	var tablesObject 	= $(document.body).getElements("table.paramlist");
	for(var j=0; j<tablesObject.length; j++){
		trObject		= $(tablesObject[j]).rows;
		
		var level = "";
		var newLevel = false;
		
		for(i=0; i < trObject.length; i++){
			html = trObject[i].innerHTML.toUpperCase();
			
			if( html.indexOf("<H4") >= 0){
				level = $(trObject[i]).getElement("h4").getProperty("rel");
				newLevel = false;
			}else{
				if( html.indexOf("PARAMLIST_KEY") >= 0  ){
					if(level != "" &&  !newLevel  ){
						level = parseInt(level) + 1;
						newLevel = true;
					}
				}
			}
			if( level != "" )
				$(trObject[i]).addClass("level"+level);
		};
		
	}
	
}

// Control show/hide Region:
function showRegion(regionID, level){
	var tr = $(regionID).getParent().getParent();
	level = level.toUpperCase().clean();
	
	while( tr.getNext()!=null && tr.getNext().className.toUpperCase().clean().indexOf(level)==-1){
		var h4 = $E('h4.block-head', tr.getNext().getFirst());
		if($type(h4)){
			 h4.removeClass("open");
			 h4.removeClass("close");
			 h4.addClass("open");
		}
		tr.getNext().removeClass('disable-row');
		tr.getNext().addClass('enable-row');
		tr = tr.getNext();
	}	
    $(regionID).removeClass("open");
    $(regionID).removeClass("close");
    $(regionID).addClass("open");
	if($type(jatabs)){
		jatabs.resize();
	}
}

function hideRegion(regionID, level){
	var tr = $(regionID).getParent().getParent();
	level = level.toUpperCase().clean();
	while( tr.getNext()!=null && tr.getNext().className.toUpperCase().clean().indexOf(level)==-1){
		var h4 = $E('h4.block-head', tr.getNext().getFirst());
		if($type(h4)){
			 tr.getNext().removeClass('disable-row');
			 tr.getNext().addClass('enable-row');			
			 h4.removeClass("open");
			 h4.removeClass("close");
			 h4.addClass("close");
		}
		else{
			tr.getNext().removeClass('enable-row');
			tr.getNext().addClass('disable-row');			
		}
		
		tr = tr.getNext();
	}	
    
    $(regionID).removeClass("open");
    $(regionID).removeClass("close");
    $(regionID).addClass("close");
	if($type(jatabs)){
		jatabs.resize();
	}
}
function showHideRegion(regionID, level){
	if($(regionID).className.indexOf('close')>-1){
		showRegion(regionID, level);
	}
	else if($(regionID).className.indexOf('open')>-1){
		hideRegion(regionID, level);
	}	  
}

function updateFormMenu(obj, changeHeight){
	if(!obj) return;
	switch(obj.value.trim()){
		case '0':
			$('paramsmega_subcontent_mod_modules').getParent().getParent().setStyle('display', 'none');
			$('paramsmega_subcontent_pos_positions').getParent().getParent().setStyle('display', 'none');
			break;
		case 'mod':
			$('paramsmega_subcontent_mod_modules').getParent().getParent().setStyle('display', 'table-row');
			$('paramsmega_subcontent_pos_positions').getParent().getParent().setStyle('display', 'none');
			break;
		case 'pos':
			$('paramsmega_subcontent_mod_modules').getParent().getParent().setStyle('display', 'none');
			$('paramsmega_subcontent_pos_positions').getParent().getParent().setStyle('display', 'table-row');
			break;
	}
	
	if(changeHeight){
		$('mega-params-options').getNext().setStyle('height', $('mega-params-options').getNext().getElement('table.paramlist').offsetHeight)		
		window.fireEvent('resize');
	}
}