var Y = YUI().use('aui-form-builder', function(Y) {


    //Custom Attributes

    //Score
    var scoreAttrDef = {
        attributeName: 'scoreAttr',
            name: 'Score'
    };

    //Answer
    var rightAnswerAttrDef = {
        attributeName: 'rightAnswerAttr',
        name: 'Right answer'
    };

    //AnswersScore - Associative string csv eg: answer1=10,answer2=0
    var answersScoreAttrDef = {
        attributeName: 'answerScoreAttr',
        name: 'Answers Score'
    };


    var STR_BLANK = '';


    var TPL_PARAGRAPH = '<p></p>';

    var TPL_SEPARATOR = '<div class="separator"></div>';

    var TPL_IMAGE = '<div class="lfr-wcm-image"></div>';

    var camelize = function (str) {
        return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(letter, index) {
            return index == 0 ? letter.toLowerCase() : letter.toUpperCase();
        }).replace(/\s+/g, '');
    }
    var applyStyles = function(node, styleContent) {
        var styles = styleContent.replace(/\n/g, STR_BLANK).split(';');

        node.setStyle(STR_BLANK);

        Y.Array.each(
            styles,
            function(item, index, collection) {
                var rule = item.split(':');

                if (rule.length == 2) {
                    var key = camelize(rule[0]);
                    var value = trim(rule[1]);

                    node.setStyle(key, value);
                }
            }
        );
    };

    //Custom Text Field
    Y.form_text = Y.Component.create({ NAME: 'form-node',

        ATTRS: {
            type: {
                value: 'form_text'
            },
            scoreAttr: {
                validator: Y.Lang.isString,
                value: '0'
            }
        },

        EXTENDS: Y.FormBuilderTextField,

        prototype: {

            getPropertyModel: function () {
                var instance = this;

                var model = Y.FormBuilderTextField.superclass.getPropertyModel.apply(instance, arguments);

                model.push(scoreAttrDef);

                return model;
            }
        }
    });

    Y.FormBuilderField.types['form_text'] = Y.form_text;

    //Custom Textarea
    Y.form_textarea = Y.Component.create({ NAME: 'form-node',

        ATTRS: {
            type: {
                value: 'form_textarea'
            },
            scoreAttr: {
                validator: Y.Lang.isString,
                value: '0'
            }
        },

        EXTENDS: Y.FormBuilderTextAreaField,

        prototype: {

            getPropertyModel: function () {
                var instance = this;

                var model = Y.FormBuilderTextAreaField.superclass.getPropertyModel.apply(instance, arguments);

                model.push(scoreAttrDef);

                return model;
            }
        }
    });

    Y.FormBuilderField.types['form_textarea'] = Y.form_textarea;

    //Custom Checkbox
    Y.form_checkbox = Y.Component.create({ NAME: 'form-node',

        ATTRS: {
            type: {
                value: 'form_checkbox'
            },
            scoreAttr: {
                validator: Y.Lang.isString,
                value: '0'
            },
            rightAnswerAttr: {
                validator: Y.Lang.isBoolean,
                value: false
            }
        },

        EXTENDS: Y.FormBuilderCheckBoxField,

        prototype: {

            getPropertyModel: function () {
                var instance = this;

                var model = Y.FormBuilderCheckBoxField.superclass.getPropertyModel.apply(instance, arguments);

                model.push(scoreAttrDef,rightAnswerAttrDef);

                return model;
            }
        }
    });

    Y.FormBuilderField.types['form_checkbox'] = Y.form_checkbox;

    //Custom Select
    Y.form_select = Y.Component.create({ NAME: 'form-node',

        ATTRS: {
            type: {
                value: 'form_select'
            },
            scoreAttr: {
                validator: Y.Lang.isString,
                value: '0'
            },
            rightAnswerAttr: {
                validator: Y.Lang.isBoolean,
                value: false
            }
        },

        EXTENDS: Y.FormBuilderSelectField,

        prototype: {

            getPropertyModel: function () {
                var instance = this;

                var model = Y.FormBuilderSelectField.superclass.getPropertyModel.apply(instance, arguments);

                model.push(scoreAttrDef,rightAnswerAttrDef);

                return model;
            }
        }
    });

    Y.FormBuilderField.types['form_select'] = Y.form_select;

    //Custom Multiple Choice field
    Y.form_multiplechoice = Y.Component.create({ NAME: 'form-node',

        ATTRS: {
            type: {
                value: 'form_multiplechoice'
            },
            scoreAttr: {
                validator: Y.Lang.isString,
                value: '0'
            },
            answersScoreAttr: {
                validator: Y.Lang.isString,
                value: ''
            }
        },

        EXTENDS: Y.FormBuilderRadioField,

        prototype: {

            getPropertyModel: function () {
                var instance = this;

                var model = Y.FormBuilderRadioField.superclass.getPropertyModel.apply(instance, arguments);

                model.push(scoreAttrDef,answersScoreAttrDef);

                return model;
            }
        }
    });

    Y.FormBuilderField.types['form_multiplechoice'] = Y.form_multiplechoice;

    //Custom Radio Button
    Y.form_radio = Y.Component.create({ NAME: 'form-node',

        ATTRS: {
            type: {
                value: 'form_radio'
            },
            scoreAttr: {
                validator: Y.Lang.isString,
                value: '0'
            },
            rightAnswerAttr: {
                validator: Y.Lang.isBoolean,
                value: false
            }
        },

        EXTENDS: Y.FormBuilderRadioField,

        prototype: {

            getPropertyModel: function () {
                var instance = this;

                var model = Y.FormBuilderRadioField.superclass.getPropertyModel.apply(instance, arguments);

                model.push(scoreAttrDef,rightAnswerAttrDef);

                return model;
            }
        }
    });

    Y.FormBuilderField.types['form_radio'] = Y.form_radio;

    //Custom File Upload
    /*
    Y.form_fileupload = Y.Component.create({ NAME: 'form-node',

        ATTRS: {
            type: {
                value: 'form_fileupload'
            }
        },

        EXTENDS: Y.FormBuilderFileUploadField,

        prototype: {

            getPropertyModel: function () {
                var instance = this;

                var model = Y.FormBuilderFileUploadField.superclass.getPropertyModel.apply(instance, arguments);

                //model.push();

                return model;
            }
        }
    });

    Y.FormBuilderField.types['form_fileupload'] = Y.form_fileupload;
    */

    //Custom Fieldset
    Y.form_fieldset = Y.Component.create({ NAME: 'form-node',

        ATTRS: {
            type: {
                value: 'form_fieldset'
            }
        },

        EXTENDS: Y.FormBuilderFieldsetField,

        prototype: {

            getPropertyModel: function () {
                var instance = this;

                var model = Y.FormBuilderFieldsetField.superclass.getPropertyModel.apply(instance, arguments);

                //model.push();

                return model;
            }
        }
    });

    Y.FormBuilderField.types['form_fieldset'] = Y.form_fieldset;

    //Custom Paragraph
    Y.form_paragraph = Y.Component.create(
        {
            NAME: 'form_paragraph',
            ATTRS: {
                dataType: {
                    value: undefined
                },

                showLabel: {
                    readOnly: true,
                    value: true
                },

                style: {
                    value: STR_BLANK
                }
            },

            EXTENDS: Y.FormBuilderField,


            prototype: {
                getHTML: function() {
                    return TPL_PARAGRAPH;
                },

                getPropertyModel: function() {
                    var instance = this;

                    return [
                        {
                            attributeName: 'type',
                            editor: false,
                            name: 'Type'
                        },
                        {
                            attributeName: 'label',
                            editor: new Y.TextAreaCellEditor(),
                            name: 'Label'
                        }
                    ];
                },

                _uiSetLabel: function(val) {
                    var instance = this;

                    instance.get('templateNode').setContent(val);
                },

                _uiSetStyle: function(val) {
                    var instance = this;

                    var templateNode = instance.get('templateNode');

                    applyStyles(templateNode, val);
                }
            }
        }
    );

    Y.FormBuilderField.types['form_paragraph'] = Y.form_paragraph;

    //Custom separator
    Y.form_separator = Y.Component.create(
        {
            ATTRS: {
                dataType: {
                    value: undefined
                },

                showLabel: {
                    readOnly: true,
                    value: false
                },

                style: {
                    value: STR_BLANK
                }
            },

            EXTENDS: Y.FormBuilderField,

            NAME: 'form_separator',

            prototype: {
                getHTML: function() {
                    return TPL_SEPARATOR;
                },

                getPropertyModel: function() {
                    return [
                        {
                            attributeName: 'type',
                            editor: false,
                            name: 'Type'
                        }
                    ];
                },

                _uiSetStyle: function(val) {
                    var instance = this;

                    var templateNode = instance.get('templateNode');

                    applyStyles(templateNode, val);
                }
            }
        }
    );
    Y.FormBuilderField.types['form_separator'] = Y.form_separator;

    //Custom Image
    /*
    Y.form_image = Y.Component.create(
        {
            ATTRS: {
                dataType: {
                    value: 'form_image'
                }
            },

            EXTENDS: Y.FormBuilderField,

            NAME: 'form_image',

            prototype: {
                getHTML: function() {
                    return TPL_IMAGE;
                }
            }
        }
    );
    Y.FormBuilderField.types['form_image'] = Y.form_image;
    */

    window.formBuilder = new Y.FormBuilder(
        {
            boundingBox: '#formBuilder',

            availableFields:
                [
                    {
                        iconClass: 'form-builder-field-icon form-builder-field-icon-text',
                        label: 'Form Text',
                        type: 'form_text',
                        readOnlyAttributes: ['name'],
                        width: 100
                    },
                    {
                        iconClass: 'form-builder-field-icon form-builder-field-icon-textarea',
                        label: 'Textarea',
                        type: 'form_textarea'
                    },

                    {
                        iconClass: 'form-builder-field-icon form-builder-field-icon-checkbox',
                        label: 'Checkbox',
                        type: 'form_checkbox'
                    },

                    {
                        iconClass: 'form-builder-field-icon form-builder-field-icon-select',
                        label: 'Select',
                        type: 'form_select'
                    },

                    {
                        iconClass: 'form-builder-field-icon form-builder-field-icon-radio',
                        label: 'Radio Buttons',
                        type: 'form_radio'
                    },
                    {
                        iconClass: 'form-builder-field-icon form-builder-field-icon-radio',
                        label: 'Multiple Choice',
                        type: 'form_multiplechoice'
                    },
                    /*{
                        iconClass: 'form-builder-field-icon form-builder-field-icon-fileupload',
                        label: 'File Upload',
                        type: 'form_fileupload'
                    },*/

                    {
                        iconClass: 'form-builder-field-icon form-builder-field-icon-fieldset',
                        label: 'Section',
                        type: 'form_fieldset'
                    },

                    {
                        iconClass: 'form-builder-field-icon form-builder-field-icon-paragraph',
                        label: 'Paragraph',
                        type: 'form_paragraph'
                    },

                    {
                        iconClass: 'form-builder-field-icon form-builder-field-icon-separator',
                        label: 'Separator',
                        type: 'form_separator'
                    }/*,

                    {
                        iconClass: 'form-builder-field-icon form-builder-field-icon-document',
                        label: 'Image',
                        type: 'form_image'
                    }*/

                ]

        }
    ).render().disable();



    function selectField(name)
    {
        var retval = null;
        window.formBuilder.get('fields').each(
            function(item, index, collection) {
                    if (name == item.get('name')) {
                        retval = item;
                    }
            });
        return retval;
    }

    if ($('#FormData').val()!='')
    {
        var jsonData = JSON.parse( $('#FormData').val() );

        jsonData.forEach(function myFunction(item,index,arr) {

            window.formBuilder.addField(item,index);
            if (item.children!=null) {
                item.children.forEach(function myFunction(subitem, subindex, subarr) {
                    itemInstance = selectField(item.name);
                    if (itemInstance!=null) itemInstance.addField(subitem, subindex);
                });
            }
        });
    }

    $('form').submit(function() {

        var formDefinition = [];

        var parser = function(fields, container){
            fields.each(function(item, index) {
                var surveyElement = {};
                var properties = item.getProperties();

                properties.forEach(function(property) {
                    var attr = property.attributeName;
                    surveyElement[attr] =  item.get(attr);
                })
                surveyElement.name = item.get('name');

                var children = item.getAttrs()['fields']
                if(children && children.size() > 0){
                    surveyElement.children = [];
                    parser(children, surveyElement.children);
                }

                container.push(surveyElement);
            });
        }

        parser(window.formBuilder.get('fields'), formDefinition);
        //var json = JSON.stringify(formDefinition)

        $('#FormData').val(JSON.stringify(formDefinition));
    });

});