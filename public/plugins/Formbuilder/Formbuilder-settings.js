/**
 * Created by TaroonG on 2016-11-15.
 */
var assessmentFieldTypes = {};
var surveyFieldTypes = {};

var commonFieldTypes1 = [
    {
        key: 'textarea',
        label: 'Textarea',
        template: 'textarea',
        //Points: 0,
        schema: {
            name: false,
            fbid: false,
            dbId: false,
            label: '',
            Points: 0,
            required: false
        }
    },
    {
        key: 'radio',
        label: 'Radio',
        template: 'radgroup_choices',
        //Points: 0,
        schema: {
            name: false,
            fbid: false,
            dbId: false,
            label: '',
            Points: 0,
            required: false,
            choices: []
        },
        choiceSchema: {
            selected: false,
            label: '',
            Points: 0,
            dbId: false
        }
    },
    {
        key: 'checkbox',
        label: 'Checkbox',
        template: 'chkgroup_choices',
        Points: 0,
        schema: {
            name: false,
            fbid: false,
            dbId: false,
            Points: 0,
            label: '',
            required: false,
            choices: []
        },
        choiceSchema: {
            selected: false,
            label: '',
            Points: 0,
            dbId: false
        }
    }
];

var commonFieldTypes2 = [
    {
        key: 'text',
        label: 'Text',
        schema: {
            name: false,
            fbid: false,
            dbId: false,
            label: '',
            required: false
        }
    },
    {
        key: 'select',
        label: 'Select',
        template: 'choices',
        schema: {
            name: false,
            fbid: false,
            dbId: false,
            label: '',
            required: false,
            choices: []
        },
        choiceSchema: {
            selected: false,
            label: '',
            Points: 0,
            dbId: false
        }
    },
];

assessmentFieldTypes = commonFieldTypes1;
// indexes in order as defined above: textarea, radio, checkbox
assessmentFieldTypes[0].label = 'Open-ended';
assessmentFieldTypes[1].label = 'Single choice';
assessmentFieldTypes[2].label = 'Multiple choice';

surveyFieldTypes = commonFieldTypes1.concat(commonFieldTypes2);