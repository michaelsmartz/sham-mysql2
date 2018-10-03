define("ace/snippets/javascript",["require","exports","module"],function(e,t,n){t.snippetText="snippet add\n	${1:obj}.add('${2:selector expression}')${3}\nsnippet addClass\n	${1:obj}.addClass('${2:class name}')${3}\nsnippet after\n	${1:obj}.after('${2:Some text <b>and bold!</b>}')${3}\nsnippet ajax\n	$.ajax({\n		url: '${1:mydomain.com/url}',\n		type: '${2:POST}',\n		dataType: '${3:xml/html/script/json}',\n		data: $.param( $('${4:Element or Expression}') ),\n		complete: function (jqXHR, textStatus) {\n			${5:// callback}\n		},\n		success: function (data, textStatus, jqXHR) {\n			${6:// success callback}\n		},\n		error: function (jqXHR, textStatus, errorThrown) {\n			${7:// error callback}\n		}\n	});\nsnippet ajaxcomplete\n	${1:obj}.ajaxComplete(function (${1:e}, xhr, settings) {\n		${2:// callback}\n	});\nsnippet ajaxerror\n	${1:obj}.ajaxError(function (${1:e}, xhr, settings, thrownError) {\n		${2:// error callback}\n	});\n	${3}\nsnippet ajaxget\n	$.get('${1:mydomain.com/url}',\n		${2:{ param1: value1 },}\n		function (data, textStatus, jqXHR) {\n			${3:// success callback}\n		}\n	);\nsnippet ajaxpost\n	$.post('${1:mydomain.com/url}',\n		${2:{ param1: value1 },}\n		function (data, textStatus, jqXHR) {\n			${3:// success callback}\n		}\n	);\nsnippet ajaxprefilter\n	$.ajaxPrefilter(function (${1:options}, ${2:originalOptions}, jqXHR) {\n		${3: // Modify options, control originalOptions, store jqXHR, etc}\n	});\nsnippet ajaxsend\n	${1:obj}.ajaxSend(function (${1:request, settings}) {\n		${2:// error callback}\n	});\n	${3}\nsnippet ajaxsetup\n	$.ajaxSetup({\n		url: \"${1:mydomain.com/url}\",\n		type: \"${2:POST}\",\n		dataType: \"${3:xml/html/script/json}\",\n		data: $.param( $(\"${4:Element or Expression}\") ),\n		complete: function (jqXHR, textStatus) {\n			${5:// callback}\n		},\n		success: function (data, textStatus, jqXHR) {\n			${6:// success callback}\n		},\n		error: function (jqXHR, textStatus, errorThrown) {\n			${7:// error callback}\n		}\n	});\nsnippet ajaxstart\n	$.ajaxStart(function () {\n		${1:// handler for when an AJAX call is started and no other AJAX calls are in progress};\n	});\n	${2}\nsnippet ajaxstop\n	$.ajaxStop(function () {\n		${1:// handler for when all AJAX calls have been completed};\n	});\n	${2}\nsnippet ajaxsuccess\n	$.ajaxSuccess(function (${1:e}, xhr, settings) {\n		${2:// handler for when any AJAX call is successfully completed};\n	});\n	${2}\nsnippet andself\n	${1:obj}.andSelf()${2}\nsnippet animate\n	${1:obj}.animate({${2:param1: value1, param2: value2}}, ${3:speed})${4}\nsnippet append\n	${1:obj}.append('${2:Some text <b>and bold!</b>}')${3}\nsnippet appendTo\n	${1:obj}.appendTo('${2:selector expression}')${3}\nsnippet attr\n	${1:obj}.attr('${2:attribute}', '${3:value}')${4}\nsnippet attrm\n	${1:obj}.attr({'${2:attr1}': '${3:value1}', '${4:attr2}': '${5:value2}'})${6}\nsnippet before\n	${1:obj}.before('${2:Some text <b>and bold!</b>}')${3}\nsnippet bind\n	${1:obj}.bind('${2:event name}', function (${3:e}) {\n		${4:// event handler}\n	});\nsnippet blur\n	${1:obj}.blur(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet C\n	$.Callbacks()${1}\nsnippet Cadd\n	${1:callbacks}.add(${2:callbacks})${3}\nsnippet Cdis\n	${1:callbacks}.disable()${2}\nsnippet Cempty\n	${1:callbacks}.empty()${2}\nsnippet Cfire\n	${1:callbacks}.fire(${2:args})${3}\nsnippet Cfired\n	${1:callbacks}.fired()${2}\nsnippet Cfirew\n	${1:callbacks}.fireWith(${2:this}, ${3:args})${4}\nsnippet Chas\n	${1:callbacks}.has(${2:callback})${3}\nsnippet Clock\n	${1:callbacks}.lock()${2}\nsnippet Clocked\n	${1:callbacks}.locked()${2}\nsnippet Crem\n	${1:callbacks}.remove(${2:callbacks})${3}\nsnippet change\n	${1:obj}.change(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet children\n	${1:obj}.children('${2:selector expression}')${3}\nsnippet clearq\n	${1:obj}.clearQueue(${2:'queue name'})${3}\nsnippet click\n	${1:obj}.click(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet clone\n	${1:obj}.clone()${2}\nsnippet contains\n	$.contains(${1:container}, ${2:contents});\nsnippet css\n	${1:obj}.css('${2:attribute}', '${3:value}')${4}\nsnippet csshooks\n	$.cssHooks['${1:CSS prop}'] = {\n		get: function (elem, computed, extra) {\n			${2: // handle getting the CSS property}\n		},\n		set: function (elem, value) {\n			${3: // handle setting the CSS value}\n		}\n	};\nsnippet cssm\n	${1:obj}.css({${2:attribute1}: '${3:value1}', ${4:attribute2}: '${5:value2}'})${6}\nsnippet D\n	$.Deferred()${1}\nsnippet Dalways\n	${1:deferred}.always(${2:callbacks})${3}\nsnippet Ddone\n	${1:deferred}.done(${2:callbacks})${3}\nsnippet Dfail\n	${1:deferred}.fail(${2:callbacks})${3}\nsnippet Disrej\n	${1:deferred}.isRejected()${2}\nsnippet Disres\n	${1:deferred}.isResolved()${2}\nsnippet Dnotify\n	${1:deferred}.notify(${2:args})${3}\nsnippet Dnotifyw\n	${1:deferred}.notifyWith(${2:this}, ${3:args})${4}\nsnippet Dpipe\n	${1:deferred}.then(${2:doneFilter}, ${3:failFilter}, ${4:progressFilter})${5}\nsnippet Dprog\n	${1:deferred}.progress(${2:callbacks})${3}\nsnippet Dprom\n	${1:deferred}.promise(${2:target})${3}\nsnippet Drej\n	${1:deferred}.reject(${2:args})${3}\nsnippet Drejw\n	${1:deferred}.rejectWith(${2:this}, ${3:args})${4}\nsnippet Dres\n	${1:deferred}.resolve(${2:args})${3}\nsnippet Dresw\n	${1:deferred}.resolveWith(${2:this}, ${3:args})${4}\nsnippet Dstate\n	${1:deferred}.state()${2}\nsnippet Dthen\n	${1:deferred}.then(${2:doneCallbacks}, ${3:failCallbacks}, ${4:progressCallbacks})${5}\nsnippet Dwhen\n	$.when(${1:deferreds})${2}\nsnippet data\n	${1:obj}.data(${2:obj})${3}\nsnippet dataa\n	$.data('${1:selector expression}', '${2:key}'${3:, 'value'})${4}\nsnippet dblclick\n	${1:obj}.dblclick(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet delay\n	${1:obj}.delay('${2:slow/400/fast}'${3:, 'queue name'})${4}\nsnippet dele\n	${1:obj}.delegate('${2:selector expression}', '${3:event name}', function (${4:e}) {\n		${5:// event handler}\n	});\nsnippet deq\n	${1:obj}.dequeue(${2:'queue name'})${3}\nsnippet deqq\n	$.dequeue('${1:selector expression}'${2:, 'queue name'})${3}\nsnippet detach\n	${1:obj}.detach('${2:selector expression}')${3}\nsnippet die\n	${1:obj}.die(${2:event}, ${3:handler})${4}\nsnippet each\n	${1:obj}.each(function (index) {\n		${2:this.innerHTML = this + \" is the element, \" + index + \" is the position\";}\n	});\nsnippet el\n	$('<${1}/>'${2:, {}})${3}\nsnippet eltrim\n	$.trim('${1:string}')${2}\nsnippet empty\n	${1:obj}.empty()${2}\nsnippet end\n	${1:obj}.end()${2}\nsnippet eq\n	${1:obj}.eq(${2:element index})${3}\nsnippet error\n	${1:obj}.error(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet eventsmap\n	{\n		:f${1}\n	}\nsnippet extend\n	$.extend(${1:true, }${2:target}, ${3:obj})${4}\nsnippet fadein\n	${1:obj}.fadeIn('${2:slow/400/fast}')${3}\nsnippet fadeinc\n	${1:obj}.fadeIn('slow/400/fast', function () {\n		${2:// callback};\n	});\nsnippet fadeout\n	${1:obj}.fadeOut('${2:slow/400/fast}')${3}\nsnippet fadeoutc\n	${1:obj}.fadeOut('slow/400/fast', function () {\n		${2:// callback};\n	});\nsnippet fadeto\n	${1:obj}.fadeTo('${2:slow/400/fast}', ${3:0.5})${4}\nsnippet fadetoc\n	${1:obj}.fadeTo('slow/400/fast', ${2:0.5}, function () {\n		${3:// callback};\n	});\nsnippet filter\n	${1:obj}.filter('${2:selector expression}')${3}\nsnippet filtert\n	${1:obj}.filter(function (${2:index}) {\n		${3:// test code}\n	})${4}\nsnippet find\n	${1:obj}.find('${2:selector expression}')${3}\nsnippet focus\n	${1:obj}.focus(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet focusin\n	${1:obj}.focusIn(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet focusout\n	${1:obj}.focusOut(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet get\n	${1:obj}.get(${2:element index})${3}\nsnippet getjson\n	$.getJSON('${1:mydomain.com/url}',\n		${2:{ param1: value1 },}\n		function (data, textStatus, jqXHR) {\n			${3:// success callback}\n		}\n	);\nsnippet getscript\n	$.getScript('${1:mydomain.com/url}', function (script, textStatus, jqXHR) {\n		${2:// callback}\n	});\nsnippet grep\n	$.grep(${1:array}, function (item, index) {\n		${2:// test code}\n	}${3:, true});\nsnippet hasc\n	${1:obj}.hasClass('${2:className}')${3}\nsnippet hasd\n	$.hasData('${1:selector expression}');\nsnippet height\n	${1:obj}.height(${2:integer})${3}\nsnippet hide\n	${1:obj}.hide('${2:slow/400/fast}')${3}\nsnippet hidec\n	${1:obj}.hide('${2:slow/400/fast}', function () {\n		${3:// callback}\n	});\nsnippet hover\n	${1:obj}.hover(function (${2:e}) {\n		${3:// event handler}\n	}, function ($2) {\n		${4:// event handler}\n	});${5}\nsnippet html\n	${1:obj}.html('${2:Some text <b>and bold!</b>}')${3}\nsnippet inarr\n	$.inArray(${1:value}, ${2:array});\nsnippet insa\n	${1:obj}.insertAfter('${2:selector expression}')${3}\nsnippet insb\n	${1:obj}.insertBefore('${2:selector expression}')${3}\nsnippet is\n	${1:obj}.is('${2:selector expression}')${3}\nsnippet isarr\n	$.isArray(${1:obj})${2}\nsnippet isempty\n	$.isEmptyObject(${1:obj})${2}\nsnippet isfunc\n	$.isFunction(${1:obj})${2}\nsnippet isnum\n	$.isNumeric(${1:value})${2}\nsnippet isobj\n	$.isPlainObject(${1:obj})${2}\nsnippet iswin\n	$.isWindow(${1:obj})${2}\nsnippet isxml\n	$.isXMLDoc(${1:node})${2}\nsnippet jj\n	$('${1:selector}')${2}\nsnippet kdown\n	${1:obj}.keydown(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet kpress\n	${1:obj}.keypress(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet kup\n	${1:obj}.keyup(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet last\n	${1:obj}.last('${1:selector expression}')${3}\nsnippet live\n	${1:obj}.live('${2:events}', function (${3:e}) {\n		${4:// event handler}\n	});\nsnippet load\n	${1:obj}.load(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet loadf\n	${1:obj}.load('${2:mydomain.com/url}',\n		${2:{ param1: value1 },}\n		function (responseText, textStatus, xhr) {\n			${3:// success callback}\n		}\n	});\nsnippet makearray\n	$.makeArray(${1:obj});\nsnippet map\n	${1:obj}.map(function (${2:index}, ${3:element}) {\n		${4:// callback}\n	});\nsnippet mapp\n	$.map(${1:arrayOrObject}, function (${2:value}, ${3:indexOrKey}) {\n		${4:// callback}\n	});\nsnippet merge\n	$.merge(${1:target}, ${2:original});\nsnippet mdown\n	${1:obj}.mousedown(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet menter\n	${1:obj}.mouseenter(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet mleave\n	${1:obj}.mouseleave(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet mmove\n	${1:obj}.mousemove(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet mout\n	${1:obj}.mouseout(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet mover\n	${1:obj}.mouseover(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet mup\n	${1:obj}.mouseup(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet next\n	${1:obj}.next('${2:selector expression}')${3}\nsnippet nexta\n	${1:obj}.nextAll('${2:selector expression}')${3}\nsnippet nextu\n	${1:obj}.nextUntil('${2:selector expression}'${3:, 'filter expression'})${4}\nsnippet not\n	${1:obj}.not('${2:selector expression}')${3}\nsnippet off\n	${1:obj}.off('${2:events}', '${3:selector expression}'${4:, handler})${5}\nsnippet offset\n	${1:obj}.offset()${2}\nsnippet offsetp\n	${1:obj}.offsetParent()${2}\nsnippet on\n	${1:obj}.on('${2:events}', '${3:selector expression}', function (${4:e}) {\n		${5:// event handler}\n	});\nsnippet one\n	${1:obj}.one('${2:event name}', function (${3:e}) {\n		${4:// event handler}\n	});\nsnippet outerh\n	${1:obj}.outerHeight()${2}\nsnippet outerw\n	${1:obj}.outerWidth()${2}\nsnippet param\n	$.param(${1:obj})${2}\nsnippet parent\n	${1:obj}.parent('${2:selector expression}')${3}\nsnippet parents\n	${1:obj}.parents('${2:selector expression}')${3}\nsnippet parentsu\n	${1:obj}.parentsUntil('${2:selector expression}'${3:, 'filter expression'})${4}\nsnippet parsejson\n	$.parseJSON(${1:data})${2}\nsnippet parsexml\n	$.parseXML(${1:data})${2}\nsnippet pos\n	${1:obj}.position()${2}\nsnippet prepend\n	${1:obj}.prepend('${2:Some text <b>and bold!</b>}')${3}\nsnippet prependto\n	${1:obj}.prependTo('${2:selector expression}')${3}\nsnippet prev\n	${1:obj}.prev('${2:selector expression}')${3}\nsnippet preva\n	${1:obj}.prevAll('${2:selector expression}')${3}\nsnippet prevu\n	${1:obj}.prevUntil('${2:selector expression}'${3:, 'filter expression'})${4}\nsnippet promise\n	${1:obj}.promise(${2:'fx'}, ${3:target})${4}\nsnippet prop\n	${1:obj}.prop('${2:property name}')${3}\nsnippet proxy\n	$.proxy(${1:function}, ${2:this})${3}\nsnippet pushstack\n	${1:obj}.pushStack(${2:elements})${3}\nsnippet queue\n	${1:obj}.queue(${2:name}${3:, newQueue})${4}\nsnippet queuee\n	$.queue(${1:element}${2:, name}${3:, newQueue})${4}\nsnippet ready\n	$(function () {\n		${1}\n	});\nsnippet rem\n	${1:obj}.remove()${2}\nsnippet rema\n	${1:obj}.removeAttr('${2:attribute name}')${3}\nsnippet remc\n	${1:obj}.removeClass('${2:class name}')${3}\nsnippet remd\n	${1:obj}.removeData('${2:key name}')${3}\nsnippet remdd\n	$.removeData(${1:element}${2:, 'key name}')${3}\nsnippet remp\n	${1:obj}.removeProp('${2:property name}')${3}\nsnippet repa\n	${1:obj}.replaceAll(${2:target})${3}\nsnippet repw\n	${1:obj}.replaceWith(${2:content})${3}\nsnippet reset\n	${1:obj}.reset(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet resize\n	${1:obj}.resize(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet scroll\n	${1:obj}.scroll(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet scrolll\n	${1:obj}.scrollLeft(${2:value})${3}\nsnippet scrollt\n	${1:obj}.scrollTop(${2:value})${3}\nsnippet sdown\n	${1:obj}.slideDown('${2:slow/400/fast}')${3}\nsnippet sdownc\n	${1:obj}.slideDown('${2:slow/400/fast}', function () {\n		${3:// callback};\n	});\nsnippet select\n	${1:obj}.select(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet serialize\n	${1:obj}.serialize()${2}\nsnippet serializea\n	${1:obj}.serializeArray()${2}\nsnippet show\n	${1:obj}.show('${2:slow/400/fast}')${3}\nsnippet showc\n	${1:obj}.show('${2:slow/400/fast}', function () {\n		${3:// callback}\n	});\nsnippet sib\n	${1:obj}.siblings('${2:selector expression}')${3}\nsnippet size\n	${1:obj}.size()${2}\nsnippet slice\n	${1:obj}.slice(${2:start}${3:, end})${4}\nsnippet stoggle\n	${1:obj}.slideToggle('${2:slow/400/fast}')${3}\nsnippet stop\n	${1:obj}.stop('${2:queue}', ${3:false}, ${4:false})${5}\nsnippet submit\n	${1:obj}.submit(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet sup\n	${1:obj}.slideUp('${2:slow/400/fast}')${3}\nsnippet supc\n	${1:obj}.slideUp('${2:slow/400/fast}', function () {\n		${3:// callback};\n	});\nsnippet text\n	${1:obj}.text(${2:'some text'})${3}\nsnippet this\n	$(this)${1}\nsnippet toarr\n	${1:obj}.toArray()\nsnippet tog\n	${1:obj}.toggle(function (${2:e}) {\n		${3:// event handler}\n	}, function ($2) {\n		${4:// event handler}\n	});\n	${4}\nsnippet togclass\n	${1:obj}.toggleClass('${2:class name}')${3}\nsnippet togsh\n	${1:obj}.toggle('${2:slow/400/fast}')${3}\nsnippet trig\n	${1:obj}.trigger('${2:event name}')${3}\nsnippet trigh\n	${1:obj}.triggerHandler('${2:event name}')${3}\nsnippet $trim\n	$.trim(${1:str})${2}\nsnippet $type\n	$.type(${1:obj})${2}\nsnippet unbind\n	${1:obj}.unbind('${2:event name}')${3}\nsnippet undele\n	${1:obj}.undelegate(${2:selector expression}, ${3:event}, ${4:handler})${5}\nsnippet uniq\n	$.unique(${1:array})${2}\nsnippet unload\n	${1:obj}.unload(function (${2:e}) {\n		${3:// event handler}\n	});\nsnippet unwrap\n	${1:obj}.unwrap()${2}\nsnippet val\n	${1:obj}.val('${2:text}')${3}\nsnippet width\n	${1:obj}.width(${2:integer})${3}\nsnippet wrap\n	${1:obj}.wrap('${2:&lt;div class=\"extra-wrapper\"&gt;&lt;/div&gt;}')${3}\n\n# Prototype\nsnippet proto\n	${1:class_name}.prototype.${2:method_name} = function(${3:first_argument}) {\n		${4:// body...}\n	};\n# Function\nsnippet fun\n	function ${1?:function_name}(${2:argument}) {\n		${3:// body...}\n	}\n# Anonymous Function\nregex /((=)\\s*|(:)\\s*|(\\()|\\b)/f/(\\))?/\nsnippet f\n	function${M1?: ${1:functionName}}($2) {\n		${0:$TM_SELECTED_TEXT}\n	}${M2?;}${M3?,}${M4?)}\n# Immediate function\ntrigger \\(?f\\(\nendTrigger \\)?\nsnippet f(\n	(function(${1}) {\n		${0:${TM_SELECTED_TEXT:/* code */}}\n	}(${1}));\n# if\nsnippet if\n	if (${1:true}) {\n		${0}\n	}\n# if ... else\nsnippet ife\n	if (${1:true}) {\n		${2}\n	} else {\n		${0}\n	}\n# tertiary conditional\nsnippet ter\n	${1:/* condition */} ? ${2:a} : ${3:b}\n# switch\nsnippet switch\n	switch (${1:expression}) {\n		case '${3:case}':\n			${4:// code}\n			break;\n		${5}\n		default:\n			${2:// code}\n	}\n# case\nsnippet case\n	case '${1:case}':\n		${2:// code}\n		break;\n	${3}\n\n# while (...) {...}\nsnippet wh\n	while (${1:/* condition */}) {\n		${0:/* code */}\n	}\n# try\nsnippet try\n	try {\n		${0:/* code */}\n	} catch (e) {}\n# do...while\nsnippet do\n	do {\n		${2:/* code */}\n	} while (${1:/* condition */});\n# Object Method\nsnippet :f\nregex /([,{[])|^\\s*/:f/\n	${1:method_name}: function(${2:attribute}) {\n		${0}\n	}${3:,}\n# setTimeout function\nsnippet setTimeout\nregex /\\b/st|timeout|setTimeo?u?t?/\n	setTimeout(function() {${3:$TM_SELECTED_TEXT}}, ${1:10});\n# Get Elements\nsnippet gett\n	getElementsBy${1:TagName}('${2}')${3}\n# Get Element\nsnippet get\n	getElementBy${1:Id}('${2}')${3}\n# console.log (Firebug)\nsnippet cl\n	console.log(${1});\n# return\nsnippet ret\n	return ${1:result}\n# for (property in object ) { ... }\nsnippet fori\n	for (var ${1:prop} in ${2:Things}) {\n		${0:$2[$1]}\n	}\n# hasOwnProperty\nsnippet has\n	hasOwnProperty(${1})\n# docstring\nsnippet /**\n	/**\n	 * ${1:description}\n	 *\n	 */\nsnippet @par\nregex /^\\s*\\*\\s*/@(para?m?)?/\n	@param {${1:type}} ${2:name} ${3:description}\nsnippet @ret\n	@return {${1:type}} ${2:description}\n# JSON.parse\nsnippet jsonp\n	JSON.parse(${1:jstr});\n# JSON.stringify\nsnippet jsons\n	JSON.stringify(${1:object});\n# self-defining function\nsnippet sdf\n	var ${1:function_name} = function(${2:argument}) {\n		${3:// initial code ...}\n\n		$1 = function($2) {\n			${4:// main code}\n		};\n	}\n# singleton\nsnippet sing\n	function ${1:Singleton} (${2:argument}) {\n		// the cached instance\n		var instance;\n\n		// rewrite the constructor\n		$1 = function $1($2) {\n			return instance;\n		};\n		\n		// carry over the prototype properties\n		$1.prototype = this;\n\n		// the instance\n		instance = new $1();\n\n		// reset the constructor pointer\n		instance.constructor = $1;\n\n		${3:// code ...}\n\n		return instance;\n	}\n# class\nsnippet class\nregex /^\\s*/clas{0,2}/\n	var ${1:class} = function(${20}) {\n		$40$0\n	};\n	\n	(function() {\n		${60:this.prop = \"\"}\n	}).call(${1:class}.prototype);\n	\n	exports.${1:class} = ${1:class};\n# \nsnippet for-\n	for (var ${1:i} = ${2:Things}.length; ${1:i}--; ) {\n		${0:${2:Things}[${1:i}];}\n	}\n# for (...) {...}\nsnippet for\n	for (var ${1:i} = 0; $1 < ${2:Things}.length; $1++) {\n		${3:$2[$1]}$0\n	}\n# for (...) {...} (Improved Native For-Loop)\nsnippet forr\n	for (var ${1:i} = ${2:Things}.length - 1; $1 >= 0; $1--) {\n		${3:$2[$1]}$0\n	}\n\n\n#modules\nsnippet def\n	define(function(require, exports, module) {\n	\"use strict\";\n	var ${1/.*\\///} = require(\"${1}\");\n	\n	$TM_SELECTED_TEXT\n	});\nsnippet req\nguard ^\\s*\n	var ${1/.*\\///} = require(\"${1}\");\n	$0\nsnippet requ\nguard ^\\s*\n	var ${1/.*\\/(.)/\\u$1/} = require(\"${1}\").${1/.*\\/(.)/\\u$1/};\n	$0\n",t.scope="javascript"})