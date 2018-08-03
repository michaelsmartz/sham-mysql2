@extends('portal-index')

@section('title','Employee Configurations')
@section('subtitle', 'All the values used in employee dropdown lists at one place')

@section('content')
  <section class="table-main-section" id="company">
    <br/>
    {{ Widget::run('titles') }}
    {{ Widget::run('genders') }}
    {{ Widget::run('marital_statuses') }}
    {{ Widget::run('languages') }}
  </section>
@endsection

@section('scripts')
    <link rel="stylesheet" href="/css/vendors/search_tools/search_tools.css">
    <link rel="stylesheet" href="{{url('/')}}/js/jquery-tag-editor/jquery.tag-editor.css">
    <style>
        .noselect {
            -webkit-touch-callout: none; /* iOS Safari */
            -webkit-user-select: none;   /* Chrome/Safari/Opera */
            -khtml-user-select: none;    /* Konqueror */
            -moz-user-select: none;      /* Firefox */
            -ms-user-select: none;       /* Internet Explorer/Edge */
            user-select: none;           /* Non-prefixed version, currently
                                        not supported by any browser */
        }

        .json-tag-editor-spacer::selection {
            background: none; /* WebKit/Blink Browsers */
        }
        .json-tag-editor-spacer::-moz-selection {
            background: none; /* Gecko Browsers */
        }

        .json-tag-editor::focus {
            border: 1px solid #999999;
        }

        /* surrounding tag container */
        .json-tag-editor {
            list-style-type: none; 
            padding: 0 0 0 0; margin: 0 0 6px 0; min-height: 40px;
            overflow: hidden; border: 1px solid #ccc; cursor: text;
            font: normal 1.2em inherit; color: #555; background: none; 
            /*line-height: 20px;*/
            border-bottom: solid 0.2 em #bfbfbf;
        }

        /* core styles usually need no change */
        .json-tag-editor li { display: block; float: left; overflow: hidden; margin: 3px 0 3px 0; 
            transition: all 0.25s ease-in-out;
        }

        .json-tag-editor li:hover .json-tag-editor-tag, .json-tag-editor li:hover .json-tag-editor-delete {
            background-color: #f0f0f0;
            border: solid 0.1em #bfbfbf;
        }
        .json-tag-editor div { float: left; padding: 0 4px; }
        .json-tag-editor .placeholder { padding: 0 8px; color: #000; }
        .json-tag-editor li:hover .json-tag-editor-spacer {
            background: none;
        }
        .json-tag-editor .json-tag-editor-spacer { padding: 0; overflow: hidden; color: transparent; background: none; }
        .json-tag-editor-tag.active > input {
            vertical-align: inherit; border: none !important; outline: none; padding: 0; margin: 0; cursor: text;
            font-family: inherit; font-weight: inherit; font-size: inherit; font-style: inherit;
            box-shadow: none; background: whitesmoke; color: #444; /*border-radius: 0 !important;*/
        }
        /* hide original input field or textarea visually to allow tab navigation */
        .json-tag-editor-hidden-src { position: absolute !important; left: -99999px; }

        /* tag style */
        .json-tag-editor .json-tag-editor-tag {
            padding-left: 10px;
            white-space: nowrap;
            overflow: hidden; cursor: pointer; border-radius: 1em 0 0 1em;
            transition: all 0.25s ease-in-out;
            border: solid 0.1em #e1e1e1;
            border-right-width: 0 !important;
            background: #fafafa;
            border-right-color: transparent !important;
        }

        .json-tag-editor .json-tag-editor-tag:hover {
            border-right-width: 0;
        }

        .json-tag-editor .json-tag-editor-tag.active {
            border: none !important;
            border-radius: 0 !important;
        }

        /* delete icon */
        .json-tag-editor .json-tag-editor-delete { background: inherit; cursor: pointer; border-radius: 0 1em 1em 0; 
        border: solid 0.1em #e1e1e1; 
        padding-left: 3px; padding-right: 4px; border-left-width: 0;
        transition: all 0.25s ease-in-out; border-left-color: transparent !important;
        
        }
        .json-tag-editor .json-tag-editor-delete i { line-height: 16px; display: inline-block; font-size: 18px;position: relative; top: 2px; }
        .json-tag-editor .json-tag-editor-delete i:before { font-size: 18px; color: #afafaf; 
        content: "×"; font-style: normal; font-weight:900; }
        .json-tag-editor .json-tag-editor-delete:hover i:before { color: #EF5350; }
        .json-tag-editor .json-tag-editor-tag.active+.json-tag-editor-delete, .json-tag-editor .json-tag-editor-tag.active+.json-tag-editor-delete i { visibility: hidden; cursor: text; }

        .json-tag-editor .json-tag-editor-tag.active { background: none !important; }

        /* jQuery UI autocomplete - code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css */
        .ui-autocomplete { position: absolute; top: 0; left: 0; cursor: default; font-size: 14px; }
        .ui-front { z-index: 9999; }
        .ui-menu { list-style: none; padding: 1px; margin: 0; display: block; outline: none; }
        .ui-menu .ui-menu-item a { text-decoration: none; display: block; padding: 2px .4em; line-height: 1.4; min-height: 0; /* support: IE7 */ }
        .ui-widget-content { border: 1px solid #bbb; background: #fff; color: #555; }
        .ui-widget-content a { color: #46799b; }
        .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { background: #e0eaf1; }
        .ui-helper-hidden-accessible { display: none; }
    </style>
    <script src="/js/jquery-tag-editor/jquery.caret.min.js"></script>
    <script>
"use strict";
(function($) {
 $.fn.jsonTagEditor = function(options, val, blur) {
  function escape(tag) {
   return tag.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#39;")
  }

  function validateTagArray(json) {
   try {
    return JSON.parse(json).map(function(tagArrayElement) {
     return validate(JSON.stringify(tagArrayElement))
    }).filter(function(element) {
     return element
    })
   } catch (e) {
    return json.split(o.dregex).map(function(tagArrayElement) {
     return tagArrayElement.trim().length > 0 ? {
      value: tagArrayElement.trim()
     } : false
    }).filter(function(element) {
     return element
    })
   }
  }

  function validateParsedTag(tagObject) {
   return tagObject.hasOwnProperty("value") && typeof tagObject.value === "string" && tagObject.value.trim().length > 0
  }

  function validate(tag) {
   try {
    var parsedTag = JSON.parse(tag);
    if (validateParsedTag(parsedTag)) {
     return parsedTag
    }
   } catch (e) {}
   return String(tag).trim().length > 0 ? {
    value: String(tag).trim()
   } : false
  }

  function ellipsify(str, maxLength) {
   return maxLength > -1 && str.length > maxLength ? str.substring(0, maxLength - 1) + "…" : str
  }

  function deepEquals(arr1, arr2) {
   return $(arr1).not(arr2).length === 0 && $(arr2).not(arr1).length === 0
  }
  var blurResult, o = $.extend({}, $.fn.jsonTagEditor.defaults, options),
   selector = this;
  o.delimiter = "\t\n";
  o.dregex = new RegExp("[" + o.delimiter + "]", "g");
  if (typeof options === "string") {
   var response = [];
   selector.each(function() {
    var el = $(this),
     o = el.data("options"),
     ed = el.next(".json-tag-editor");
    switch (options) {
     case "getTags":
      response.push({
       field: el[0],
       editor: ed,
       tags: ed.data("tags")
      });
      break;
     case "addTag":
      if (o.maxTags && ed.data("tags").length >= o.maxTags) {
       return false
      }
      $("<li></li>").append('<div class="json-tag-editor-spacer">&nbsp;' + o.delimiter[0] + "</div>").append('<div class="json-tag-editor-tag"></div>').append('<div class="json-tag-editor-delete"><i></i></div>').appendTo(ed).find(".json-tag-editor-tag").append('<input type="text" maxlength="' + o.maxLength + '">').addClass("active").find("input").val(val).blur();
      if (!blur) {
       ed.click()
      } else {
       $(".placeholder", ed).remove()
      }
      break;
     case "removeTag":
      $(".json-tag-editor-tag", ed).filter(function() {
       return $(this).get(0).dataset.value === val
      }).closest("li").find(".json-tag-editor-delete").click();
      if (!blur) {
       ed.click()
      }
      break;
     case "destroy":
      el.removeClass("json-tag-editor-hidden-src").removeData("options").off("focus.json-tag-editor").next(".json-tag-editor").remove();
      break;
     default:
      return this
    }
   });
   return options === "getTags" ? response : this
  }
  if (window.getSelection) {
   $(document).off("keydown.json-tag-editor").on("keydown.json-tag-editor", function(e) {
    if (e.which === 8 || e.which === 46) {
     try {
      var sel = getSelection(),
       el = document.activeElement.tagName === "BODY" ? $(sel.getRangeAt(0).startContainer.parentNode).closest(".json-tag-editor") : 0
     } catch (e) {
      el = 0
     }
     if (sel.rangeCount > 0 && el && el.length) {
      $(".json-tag-editor-tag", el).each(function() {
       if (sel.containsNode($(this).get(0))) {
        $(this).closest("li").find(".json-tag-editor-delete").click()
       }
      });
      return false
     }
    }
   })
  }
  return selector.each(function() {
   var el = $(this),
    tagList = [];
   var ed = $("<ul " + (o.clickDelete ? 'oncontextmenu="return false;" ' : "") + 'class="json-tag-editor' + (options.noSelect ? ' noselect"' : '"') + "></ul>").insertAfter(el);
   el.addClass("json-tag-editor-hidden-src").data("options", o).on("focus.json-tag-editor", function() {
    ed.click()
   });
   ed.append('<li style="width:1px">&nbsp;</li>');
   var newTag = "<li>" + '<div class="json-tag-editor-spacer">&nbsp;' + o.delimiter[0] + "</div>" + '<div class="json-tag-editor-tag"></div>' + '<div class="json-tag-editor-delete"><i></i></div>' + "</li>";

   function setPlaceholder() {
    if (o.placeholder && !tagList.length && !$(".deleted, .placeholder, input", ed).length) {
     ed.append('<li class="placeholder"><div>' + o.placeholder + "</div></li>")
    }
   }

   function updateGlobals(init) {
    var oldTags = tagList;
    tagList = $(".json-tag-editor-tag:not(.deleted)", ed).map(function(i, e) {
     var tag = {};
     if ($(this).hasClass("active")) {
      Object.assign(tag, $(this).find("input").get(0).dataset);
      tag.value = $(this).find("input").val()
     } else {
      Object.assign(tag, $(e).get(0).dataset, {
       value: $(e).get(0).dataset.value
      })
     }
     if (tag.value) {
      return tag
     }
    }).get();
    ed.data("tags", tagList);
    el.val(tagList.reduce(function(previous, current) {
     return previous + o.delimiter[0] + current.value
    }, ""));
    if (!init) {
     if (!deepEquals(oldTags, tagList)) {
      o.onChange(el, ed, tagList)
     }
    }
    setPlaceholder()
   }
   ed.click(function(e, closestTag) {
    var d, dist = 99999,
     loc;
    if (window.getSelection && getSelection().toString() !== "") {
     return
    }
    if (o.maxTags && ed.data("tags").length >= o.maxTags) {
     ed.find("input").blur();
     return false
    }
    blurResult = true;
    $("input:focus", ed).blur();
    if (!blurResult) {
     return false
    }
    blurResult = true;
    $(".placeholder", ed).remove();
    if (closestTag && closestTag.length) {
     loc = "before"
    } else {
     $(".json-tag-editor-tag", ed).each(function() {
      var tag = $(this),
       to = tag.offset(),
       tagX = to.left,
       tagY = to.top;
      if (e.pageY >= tagY && e.pageY <= tagY + tag.height()) {
       if (e.pageX < tagX) {
        loc = "before";
        d = tagX - e.pageX
       } else {
        loc = "after";
        d = e.pageX - tagX - tag.width()
       }
       if (d < dist) dist = d;
       closestTag = tag
      }
     })
    }
    if (loc === "before") {
     $(newTag).insertBefore(closestTag.closest("li")).find(".json-tag-editor-tag").click()
    } else if (loc === "after") {
     $(newTag).insertAfter(closestTag.closest("li")).find(".json-tag-editor-tag").click()
    } else {
     $(newTag).appendTo(ed).find(".json-tag-editor-tag").click()
    }
    return false
   });
   ed.on("click", ".json-tag-editor-delete", function(e) {
    if ($(this).prev().hasClass("active")) {
     $(this).closest("li").find("input").caret(-1);
     return false
    }
    var li = $(this).closest("li"),
     tag = li.find(".json-tag-editor-tag"),
	 tmp = o.beforeTagDelete(el, ed, tagList, tag.text());
	 console.log(tmp);
	 tmp.then(function(v){
		console.log(tmp);
		if(v == true) {
			tag.addClass("deleted").animate({
			 width: 0
			}, o.animateDelete, function() {
			 li.remove();
			 setPlaceholder();
			});
			updateGlobals();
			return false;
		} else {
			return false;
		}
		
	 });
    /*
	if (o.beforeTagDelete(el, ed, tagList, tag.text()) === false) {
     return false
    }
    tag.addClass("deleted").animate({
     width: 0
    }, o.animateDelete, function() {
     li.remove();
     setPlaceholder()
    });
    updateGlobals();
    return false
	*/
   });
   if (o.clickDelete) {
    ed.on("mousedown", ".json-tag-editor-tag", function(e) {
     if (e.ctrlKey || e.which > 1) {
      var li = $(this).closest("li"),
       tag = li.find(".json-tag-editor-tag");
      if (o.beforeTagDelete(el, ed, tagList, tag.text()) === false) {
       return false
      }
      tag.addClass("deleted").animate({
       width: 0
      }, o.animateDelete, function() {
       li.remove();
       setPlaceholder()
      });
      updateGlobals();
      return false
     }
    })
   }
   ed.on("click", ".json-tag-editor-tag", function(e) {
    if (o.clickDelete && (e.ctrlKey || e.which > 1)) {
     return false
    }
    if (!$(this).hasClass("active")) {
     var value = $(this).get(0).dataset.value ? $(this).get(0).dataset.value : $(this).text(),
      tagDisplay = $(this).text();
     var leftPercent = Math.abs(($(this).offset().left - e.pageX) / $(this).width()),
      caretPos = parseInt(tagDisplay.length * leftPercent),
      input = $(this).html('<input type="text" maxlength="' + o.maxLength + '" value="' + escape(value) + '">').addClass("active").find("input");
     input.data("old_tag", value).focus().caret(caretPos);
     if (o.autocomplete) {
      var aco = $.extend({}, o.autocomplete);
      var acSelect = "select" in aco ? o.autocomplete.select : "";
      aco.select = function(e, ui) {
       if (acSelect) {
        acSelect(e, ui)
       }
       setTimeout(function() {
        ed.trigger("click", [$(".active", ed).find("input").closest("li").next("li").find(".json-tag-editor-tag")])
       }, 20)
      };
      if (aco.plugin) {
       input[aco.plugin](aco)
      } else {
       input.autocomplete(aco)
      }
      if (aco._renderItem) {
       input.autocomplete("instance")._renderItem = aco._renderItem
      }
     }
    }
    return false
   });

   function splitCleanup(input, text) {
    var li = input.closest("li"),
     subTags = text ? text.replace(/ +/, " ").split(o.dregex) : input.val().replace(/ +/, " ").split(o.dregex),
     oldTag = input.data("old_tag"),
     oldTags = tagList.slice(0),
     exceeded = false,
     cbVal;
    for (var i = 0; i < subTags.length; i++) {
     var tag = $.trim(subTags[i]).slice(0, o.maxLength);
     if (o.forceLowercase) {
      tag = tag.toLowerCase()
     }
     cbVal = o.beforeTagSave(el, ed, oldTags, oldTag, tag);
     tag = cbVal || tag;
     if (cbVal === false || !tag) {
      continue
     }
     var tagObject = validate(tag);
     if (tagObject) {
      var $tagEditorTag = $('<div class="json-tag-editor-tag"' + (tag.length > o.maxTagLength ? ' title="' + escape(tagObject.value) + '"' : "") + ">" + escape(ellipsify(tagObject.value, o.maxTagLength)) + "</div>");
      var tagProperties = Object.keys(tagObject);
      for (var j = 0; j < tagProperties.length; j++) {
       $tagEditorTag.get(0).dataset[tagProperties[j]] = tagObject[tagProperties[j]]
      }
      oldTags.push(tagObject);
      li.before($("<li></li>").append('<div class="json-tag-editor-spacer">&nbsp;' + o.delimiter[0] + "</div>").append($tagEditorTag).append('<div class="json-tag-editor-delete"><i></i></div>'));
      if (o.maxTags && oldTags.length >= o.maxTags) {
       exceeded = true;
       break
      }
     }
    }
    input.closest("li").remove();
    updateGlobals()
   }
   ed.on("blur", "input", function(e) {
    e.stopPropagation();
    var input = $(this),
     oldTag = input.data("old_tag"),
     tag = $.trim(input.val().replace(/ +/, " ").replace(o.dregex, o.delimiter[0]));
    if (!tag) {
     if (oldTag && o.beforeTagDelete(el, ed, tagList, oldTag) === false) {
      input.val(oldTag).focus();
      blurResult = false;
      updateGlobals();
      return
     }
     try {
      input.closest("li").remove()
     } catch (e) {}
     if (oldTag) {
      updateGlobals()
     }
    } else if (tag.indexOf(o.delimiter[0]) >= 0) {
     splitCleanup(input);
     return
    } else if (tag != oldTag) {
     if (o.forceLowercase) {
      tag = tag.toLowerCase()
     }
     var cbVal = o.beforeTagSave(el, ed, tagList, oldTag, tag);
     tag = cbVal || tag;
     if (cbVal === false) {
      if (oldTag) {
       input.val(oldTag).focus();
       blurResult = false;
       updateGlobals();
       return
      }
      try {
       input.closest("li").remove()
      } catch (e) {}
      if (oldTag) {
       updateGlobals()
      }
     }
    }
    var $tagEditorTag = input.parent(),
     tagObject = validate(tag);
    if (tagObject) {
     var tagProperties = Object.keys(tagObject);
     for (var i = 0; i < tagProperties.length; i++) {
      $tagEditorTag.get(0).dataset[tagProperties[i]] = tagObject[tagProperties[i]]
     }
     if (tagObject.value.length > o.maxTagLength) {
      $tagEditorTag.attr("title", escape(tagObject.value))
     } else {
      $tagEditorTag.removeAttr("title")
     }
     $tagEditorTag.html(escape(ellipsify(tagObject.value, o.maxTagLength))).removeClass("active")
    }
    if (tag != oldTag) {
     updateGlobals()
    }
    setPlaceholder()
   });
   ed.on("paste", "input", function(e) {
    var pastedContent, inputContent;
    $(this).removeAttr("maxlength");
    pastedContent = (e.originalEvent || e).clipboardData.getData("text/plain");
    inputContent = $(this);
    setTimeout(function() {
     splitCleanup(inputContent, pastedContent)
    }, 30)
   });
   ed.on("keypress", "input", function(e) {
    if (o.delimiter.indexOf(String.fromCharCode(e.which)) >= 0) {
     var inp = $(this);
     setTimeout(function() {
      splitCleanup(inp)
     }, 20)
    }
   });
   ed.on("keydown", "input", function(e) {
    var $this = $(this),
     previousTag, nextTag;
    if ((e.which === 37 || !o.autocomplete && e.which === 38) && !$this.caret() || e.which === 8 && !$this.val()) {
     previousTag = $this.closest("li").prev("li").find(".json-tag-editor-tag");
     if (previousTag.length) {
      previousTag.click().find("input").caret(-1)
     } else if ($this.val() && !(o.maxTags && ed.data("tags").length >= o.maxTags)) {
      $(newTag).insertBefore($this.closest("li")).find(".json-tag-editor-tag").click()
     }
     return false
    } else if ((e.which === 39 || !o.autocomplete && e.which === 40) && $this.caret() === $this.val().length) {
     nextTag = $this.closest("li").next("li").find(".json-tag-editor-tag");
     if (nextTag.length) {
      nextTag.click().find("input").caret(0)
     } else if ($this.val()) {
      ed.click()
     }
     return false
    } else if (e.which === 9) {
     if (e.shiftKey) {
      previousTag = $this.closest("li").prev("li").find(".json-tag-editor-tag");
      if (previousTag.length) {
       previousTag.click().find("input").caret(0)
      } else if ($this.val() && !(o.maxTags && ed.data("tags").length >= o.maxTags)) {
       $(newTag).insertBefore($this.closest("li")).find(".json-tag-editor-tag").click()
      } else {
       el.attr("disabled", "disabled");
       setTimeout(function() {
        el.removeAttr("disabled")
       }, 30);
       return
      }
      return false
     } else {
      nextTag = $this.closest("li").next("li").find(".json-tag-editor-tag");
      if (nextTag.length) {
       nextTag.click().find("input").caret(0)
      } else if ($this.val()) {
       ed.click()
      } else {
       return
      }
      return false
     }
    } else if (e.which === 46 && (!$.trim($this.val()) || $this.caret() === $this.val().length)) {
     nextTag = $this.closest("li").next("li").find(".json-tag-editor-tag");
     if (nextTag.length) {
      nextTag.click().find("input").caret(0)
     } else if ($this.val()) {
      ed.click()
     }
     return false
    } else if (e.which === 13) {
     ed.trigger("click", [$this.closest("li").next("li").find(".json-tag-editor-tag")]);
     if (o.maxTags && ed.data("tags").length >= o.maxTags) {
      ed.find("input").blur()
     }
     return false
    } else if (e.which === 36 && !$this.caret()) {
     ed.find(".json-tag-editor-tag").first().click()
    } else if (e.which === 35 && $this.caret() === $this.val().length) {
     ed.find(".json-tag-editor-tag").last().click()
    } else if (e.which === 27) {
     $this.val($this.data("old_tag") ? $this.data("old_tag") : "").blur();
     return false
    }
   });
   var tags = o.initialTags.length ? o.initialTags.map(function(element) {
    return validateParsedTag(element) ? element : validate(element)
   }) : validateTagArray(el.val());
   for (var i = 0; i < tags.length; i++) {
    if (o.maxTags && i >= o.maxTags) {
     break
    }
    var tagObject = tags[i];
    if (tagObject) {
     if (o.forceLowercase) {
      tagObject.value = tagObject.value.toLowerCase()
     }
     tagList.push(tagObject);
     var $tagEditorTag = $('<div class="json-tag-editor-tag"' + (tagObject.length > o.maxTagLength ? ' title="' + escape(tagObject.value) + '"' : "") + ">" + escape(ellipsify(tagObject.value, o.maxTagLength)) + "</div>");
     var tagProperties = Object.keys(tagObject);
     for (var j = 0; j < tagProperties.length; j++) {
      $tagEditorTag.get(0).dataset[tagProperties[j]] = tagObject[tagProperties[j]]
     }
     ed.append($("<li></li>").append('<div class="json-tag-editor-spacer">&nbsp;' + o.delimiter[0] + "</div>").append($tagEditorTag).append('<div class="json-tag-editor-delete"><i></i></div>'))
    }
   }
   updateGlobals(true);
   if (o.sortable && $.fn.sortable) {
    ed.sortable({
     distance: 5,
     cancel: ".json-tag-editor-spacer, input",
     helper: "clone",
     update: function() {
      updateGlobals()
     }
    })
   }
  })
 };
 $.fn.jsonTagEditor.defaults = {
  initialTags: [],
  maxTags: 0,
  maxLength: 50,
  maxTagLength: -1,
  placeholder: "",
  forceLowercase: false,
  clickDelete: false,
  animateDelete: 175,
  noSelect: false,
  sortable: true,
  autocomplete: null,
  onChange: function() {},
  beforeTagSave: function() {},
  beforeTagDelete: function() {}
 }
})(jQuery);
    </script>
    <script>
        ready('.data-tag-editor', function(el) {
            prepareTagEditor(el);
        });

        function prepareTagEditor(el){
            $(el).jsonTagEditor({
                initialTags: $(el).data('value'),
                placeholder: 'Type here ...',
                clickDelete: false,
                onChange:function(field, editor, tags){
                    //console.log( 'onChange: ',$(el).jsonTagEditor('getTags') );
                },
                beforeTagSave: function(field, editor, tags, tag, val){
                    //console.log('beforeTagSave: ','field:',field, ' tag:',tag,' val:', val);
                    //console.log('beforeTagSave: ','tags:',tags);
                },
                beforeTagDelete: function(field, editor, tags, val){
                    var p = new Promise(function(resolve, reject) {
                        showConfirmation(el).then(function(a){
                            resolve(a);
                        });
                    });
                    return p;
                }
            });
        }
        async function showConfirmation(el) {
            var p = await new Promise(function(resolve, reject) {
                $(el).confirmation({
                    btnOkLabel:"Yes", btnOkClass:"text-danger",
                    btnCancelLabel:"No!", btnCancelClass:"text-muted",
                    content:"Is it ok to delete this?",
                    onConfirm: function(){ resolve(true) },
                    onCancel: function(){ resolve(false) }
                }).confirmation('show');
            });
            return p;
        }

        /*
        $(function(){
            $(document).on('confirmed.bs.confirmation', function(e){
                console.log('conf');
            });
            $(document).on('canceled.bs.confirmation', function(e){
                console.log('cancel');
            });
        });
        */
    </script>
@endsection