require('parsleyjs');

+function ($) {
    window.Parsley.addValidator('requiredIf', {
        validateString: function (value, requirement) {
            if (jQuery(requirement).val()) {
                return !!value;
            }
            return true;
        }, priority: 33
    });
    window.Parsley.addValidator('fileextension', function (value, requirement) {
        var fileExtension = value.split('.').pop();
        return fileExtension === requirement;
    }, 32)
    .addMessage('en', 'fileextension', 'The extension doesn\'t match the required');

    window.Parsley.addValidator('filemaxmegabytes', {
        requirementType: 'string',
        validateString: function (value, requirement, parsleyInstance) {
            if (!app.utils.formDataSuppoerted) {
                return true;
            }
            var file = parsleyInstance.$element[0].files;
            var maxBytes = requirement * 1048576;

            if (file.length == 0) {
                return true;
            }
            return file.length === 1 && file[0].size <= maxBytes;

        },
        messages: {
            en: 'File is too big'
        }
    })
    .addValidator('filemimetypes', {
        requirementType: 'string',
        validateString: function (value, requirement, parsleyInstance) {
            if (!app.utils.formDataSuppoerted) {
                return true;
            }
            var file = parsleyInstance.$element[0].files;

            if (file.length == 0) {
                return true;
            }
            var allowedMimeTypes = requirement.replace(/\s/g, "").split(',');
            return allowedMimeTypes.indexOf(file[0].type) !== -1;
        },
        messages: {
            en: 'File mime type not allowed'
        }
    });

    window.Parsley.addAsyncValidator('checkId',
        function(xhr) {
            return xhr.responseText !== 'false';
        }, './check-id'
    );
    window.Parsley.addAsyncValidator('checkName',
        function(xhr) {
            return xhr.responseText !== 'false';
        }, './check-name'
    );
    window.Parsley.addAsyncValidator('checkPassport',
        function(xhr) {
            return xhr.responseText !== 'false';
        }, './check-passport'
    );
    window.Parsley.addAsyncValidator('checkEmployeeNo',
        function(xhr) {
            return xhr.responseText !== 'false';
        }, './check-employeeno'
    );
    window.Parsley.on('field:ajaxoptions', function(p1,ajaxOptions) {
        var FirstName = $("[name=first_name]").val(),
            Surname = $("[name=surname]").val(),
            IdNumber = $("[name=id_number]").val(),
            PassportCountryId = $("[name=passport_country_id]").val(),
            PassportNo = $("[name=passport_no]").val(),
            EmployeeNo = $("[name=employee_no]").val();

        var namedDataMap = {
          'id_number': { 'idNumber':IdNumber,'firstName':FirstName,'surname':Surname},
          'employee_no': { 'employeeNo':EmployeeNo},
          'passport_no': { 'passportCountryId':PassportCountryId,'passportNo':PassportNo,'firstName':FirstName,'surname':Surname},
        };

        ajaxOptions.global = false;
        ajaxOptions.data = namedDataMap[$(this.$element[0]).attr('name')];
    });
}(jQuery);