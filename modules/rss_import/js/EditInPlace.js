/*
 * Edit In Place
 * http://josephscott.org/code/js/eip/
 *
 * Version: 0.2.2
 * License: http://josephscott.org/code/js/eip/license.txt
 */
EditInPlace = function() { };
EditInPlace.settings = function(set) {
	var settings = {
		id:				false,
		save_url:		false,
		css_class:		'eip_editable',
		savebutton:		'eip_savebutton',
		cancelbutton:	'eip_cancelbutton',
		saving:			'eip_saving',
		empty:			'eip_empty',
		type:			'text',
		is_empty:		false,
		empty_text:		'Click To Edit',
		orig_text:		false,
		options:		{ },
		option_name:	false
	};

	for(var i in set) { settings[i] = set[i]; }

	return($H(settings));
};

EditInPlace.formField = function(set) {
	var field = '';

	if(set['is_empty'] == true) {
		$(set['id']).innerHTML = '';
	}
	set['orig_text'] = $(set['id']).innerHTML;

	if(set['type'] == 'text') {
		var size = set['orig_text'].length + 10;
		if(size >= 100) { size = 100; }
		if(set['size']) { size = set['size']; }

		field = '<span id="' + set['id'] + '_editor"><input id="'
			+ set['id'] + '_edit" class="' + set['css_class'] + '" name="'
			+ set['id'] + '_edit" type="text" size="' + size
			+ '" value="' + set['orig_text'] + '" /><br />';
	}
	else if(set['type'] == 'textarea') {
		var cols = 50;
		if(set['cols']) { cols = set['cols']; }
		var rows = (set['orig_text'].length / cols) + 3;
		if(set['rows']) { rows = set['rows']; }

		field = '<span id="' + set['id'] + '_editor"><textarea id="'
			+ set['id'] + '_edit" class="' + set['css_class'] + '" name="'
			+ set['id'] + '_edit" rows="' + rows + '" cols="'
			+ cols + '">' + set['orig_text'] + '</textarea><br />';
	}
	else if(set['type'] == 'select') {
		field = '<span id="' + set['id'] + '_editor"><select id="'
			+ set['id'] + '_edit" class="' + set['css_class'] + '" name="'
			+ set['id'] + '_edit">';

		for(var i in set['options']) {
			field += '<option id="' + set['id'] + '_option_' + i 
				+ '" name="' + set['id'] + '_option_' + i
				+ '" value="' + i + '"';
			if(set['options'][i] == $(set['id']).innerHTML) {
				field += ' selected="selected"';
			}
			field += '>' + set['options'][i] + '</option>';
		}

		field += '</select>&nbsp;';
	}

	return(field);
};

EditInPlace.formButtons = function(set) {
	return(
		'<span><input id="' + set['id'] + '_save" class="'
		+ set['savebutton'] + '" type="button" value="SAVE" />'
		+ '<input id="' + set['id'] + '_cancel" class="' 
		+ set['cancelbutton'] + '" type="button" value="CANCEL" />'
		+ '</span></span>'
	);
};

EditInPlace.setEvents = function(set) {
	Event.observe(
		set['id'],
		'mouseover',
		function() { Element.addClassName(set['id'], set['css_class']); },
		false
	);
	Event.observe(
		set['id'],
		'mouseout',
		function() { Element.removeClassName(set['id'], set['css_class']); },
		false
	);
	Event.observe(
		set['id'],
		'click',
		function() {
			Element.hide(set['id']);

			var field = EditInPlace.formField(set);
			var button = EditInPlace.formButtons(set);

			new Insertion.After(set['id'], field + button);
			Field.focus(set['id'] + '_edit');

			Event.observe(
				set['id'] + '_save',
				'click',
				function() { EditInPlace.saveChanges(set); },
				false
			);
			Event.observe(
				set['id'] + '_cancel',
				'click',
				function() { EditInPlace.cancelChanges(set); },
				false
			);
		},
		false
	);
};

EditInPlace.saveComplete = function(t, set) {
	if(t.responseText == '') {
		set['is_empty'] = true;
		$(set['id']).innerHTML = '<span class="' + set['empty']
			+ '">' + set['empty_text'] + '</span>';
	}
	else {
		set['is_empty'] = false;
		$(set['id']).innerHTML = t.responseText;
	}

	Element.removeClassName(set['id'], set['css_class']);
};

EditInPlace.saveFailed = function(t, set) {
	$(set['id']).innerHTML = set['orig_text'];
	Element.removeClassName(set['id'], set['css_class']);
	alert('Failed to save changes.');
};

EditInPlace.saveChanges = function(set) {
	var new_text = encodeURIComponent($F(set['id'] + '_edit'));
	$(set['id']).innerHTML = 
		'<span class="' + set['saving'] + '">Saving ...</span>';

	var params = 'var_id=' + set['id'] + '&var_value=' + new_text + '&action=' + set['action'] + '&keyval=' + set['keyval'] + '&pagename=' + set['pagename'];
	if(set['type'] == 'select') {
		params += '&option_name=' 
			+ $(set['id'] + '_option_' + new_text).innerHTML;
	}

	Element.remove(set['id'] + '_editor');
	Element.show(set['id']);

	var ajax_req = new Ajax.Request(
		set['save_url'],
		{
			method: 'post',
			postBody: params,
			onSuccess: function(t) { EditInPlace.saveComplete(t, set); },
			onFailure: function(t) { EditInPlace.saveFailed(t, set); }
		}
	);
};

EditInPlace.cancelChanges = function(set) {
	Element.remove(set['id'] + '_editor');
	Element.removeClassName(set['id'], set['css_class']);

	if($(set['id']).innerHTML == '') {
		set['is_empty'] = true;
		$(set['id']).innerHTML = '<span class="' + set['empty']
			+ '">' + set['empty_text'] + '</span>';
	}

	Element.show(set['id']);
}

EditInPlace.makeEditable = function(args) {
	var set = EditInPlace.settings(args);

	if($(set['id']).innerHTML == '') {
		set['is_empty'] = true;
		$(set['id']).innerHTML = '<span class="' + set['empty']
			+ '">' + set['empty_text'] + '</span>';
	}

	EditInPlace.setEvents(set);
}
