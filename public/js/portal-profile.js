/**
 * Created by TaroonG on 9/6/2017.
 */
$(document).ready(function () {
    var oUvm;
    var GetUser = function() {

        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'my-details/getProfile',
            success: function (data) {
                var timeline = data.timeline.sort(compareFormattedDate);

                oUvm = new UserDetailViewModel(data.data);

                oUvm.TimeLineData(
                    timeline.map(function (item, index) {
                        return new UserTimeLineViewModel(item, index);
                    })
                );

                // oUvm.FilesData(
                //     data.files.map(function (item, index) {
                //         return new UserFileViewModel(item, index);
                //     })
                // );
                ko.applyBindings(oUvm, $("#sec-userProfile")[0]);
            }
        });
    };

    function compareFormattedDate(a,b) {
        if (a.formattedDate < b.formattedDate)
            return -1;
        if (a.formattedDate > b.formattedDate)
            return 1;
        return 0;
    }

    function UserDetailViewModel(data){
        var self = this;

        self.TimeLineData = ko.observableArray();
        self.FilesData = ko.observableArray();

        self.FirstName = ko.observable(data.first_name);
        self.Surname = ko.observable(data.surname);
        self.KnownAs = ko.observable(data.known_as);

        if (data.picture == '') {
            self.Pic = ko.observable("/img/avatar.png");
        } else {
            self.Pic = ko.observable(data.picture);
        }

        self.fullName = ko.observable(data.full_name);

        self.Job = ko.computed(function(){
            return data.job + ', joined on: ' + data.formatted_date_joined;
        });

        self.Team = ko.observable(data.team.description);
        self.Department = ko.observable(data.department.description);
        self.Branch = ko.observable(data.branch.description);
        self.Division = ko.observable(data.division.description);

        self.marital_status_id = ko.observable(data.marital_status_id);
        self.spouse_full_name = ko.observable(data.spouse_full_name);

        // staticXxx is read-only attribute for display only
        self.address_type_id = ko.computed(function() {
            return data.address_type_id;
        });
        self.staticHomeAddressUnitNo = ko.computed(function() {
            return data.HomeAddressUnitNo;
        });
        self.staticHomeAddressComplex = ko.computed(function() {
            return data.HomeAddressComplex;
        });
        self.staticHomeAddressLine1 = ko.computed(function() {
            return data.HomeAddressLine1;
        });
        self.staticHomeAddressLine2 = ko.computed(function() {
            return data.HomeAddressLine2;
        });
        self.staticHomeAddressLine3 = ko.computed(function() {
            return data.HomeAddressLine3;
        });
        self.staticHomeAddressLine4 = ko.computed(function() {
            return data.HomeAddressLine4;
        });
        self.staticHomeAddressCity = ko.computed(function() {
            return data.HomeAddressCity;
        });
        self.staticHomeAddressProvince = ko.computed(function() {
            return data.HomeAddressProvince;
        });
        self.staticHomeAddressZipCode = ko.computed(function() {
            return data.HomeAddressZipCode;
        });

        self.staticPostalAddressUnitNo = ko.computed(function() {
            return data.PostalAddressUnitNo;
        });
        self.staticPostalAddressComplex = ko.computed(function() {
            return data.PostalAddressComplex;
        });
        self.staticPostalAddressLine1 = ko.computed(function() {
            return data.PostalAddressLine1;
        });
        self.staticPostalAddressLine2 = ko.computed(function() {
            return data.PostalAddressLine2;
        });
        self.staticPostalAddressLine3 = ko.computed(function() {
            return data.PostalAddressLine3;
        });
        self.staticPostalAddressLine4 = ko.computed(function() {
            return data.PostalAddressLine4;
        });
        self.staticPostalAddressCity = ko.computed(function() {
            return data.PostalAddressCity;
        });
        self.staticPostalAddressProvince = ko.computed(function() {
            return data.PostalAddressProvince;
        });
        self.staticPostalAddressZipCode = ko.computed(function() {
            return data.PostalAddressZipCode;
        });

        self.HomeAddressUnitNo = ko.observable(data.HomeAddressUnitNo);
        self.HomeAddressComplex = ko.observable(data.HomeAddressComplex);
        self.HomeAddressLine1 = ko.observable(data.HomeAddressLine1);
        self.HomeAddressLine2 = ko.observable(data.HomeAddressLine2);
        self.HomeAddressLine3 = ko.observable(data.HomeAddressLine3);
        self.HomeAddressLine4 = ko.observable(data.HomeAddressLine4);
        self.HomeAddressCity = ko.observable(data.HomeAddressCity);
        self.HomeAddressProvince = ko.observable(data.HomeAddressProvince);
        self.HomeAddressZipCode = ko.observable(data.HomeAddressZipCode);

        self.PostalAddressUnitNo = ko.observable(data.PostalAddressUnitNo);
        self.PostalAddressComplex = ko.observable(data.PostalAddressComplex);
        self.PostalAddressLine1 = ko.observable(data.PostalAddressLine1);
        self.PostalAddressLine2 = ko.observable(data.PostalAddressLine2);
        self.PostalAddressLine3 = ko.observable(data.PostalAddressLine3);
        self.PostalAddressLine4 = ko.observable(data.PostalAddressLine4);
        self.PostalAddressCity = ko.observable(data.PostalAddressCity);
        self.PostalAddressProvince = ko.observable(data.PostalAddressProvince);
        self.PostalAddressZipCode = ko.observable(data.PostalAddressZipCode);

        self.HomeTel = ko.observable(data.HomeTel);
        self.Mobile = ko.observable(data.Mobile);
        self.HomeEmailAddress = ko.observable(data.HomeEmailAddress);
        self.WorkTel = ko.observable(data.WorkTel);

    }

    function UserTimeLineViewModel(data, index) {
        var self = this;
        var coloursArray = ['bg-blue','bg-green','bg-purple','bg-terques'];

        self.ColorClass = 'second';
        self.DynamicClass = coloursArray[index % coloursArray.length];
        self.Date = data.formattedDate;
        self.Description = data.Description;

        return self;

    }

    function UserFileViewModel(data, index) {
        var self = this;

        var fileClasses = {
          'mp3':  'fa fa-5x fa-file-audio-o text-default',
          'wav':  'fa fa-5x fa-file-audio-o text-default',
          'ogg': 'fa fa-5x fa-file-audio-o text-default',
          'mp4': 'fa fa-5x fa-file-movie-o text-default',

          'jpg': 'fa fa-5x fa-file-image-o text-warning',
          'png': 'fa fa-5x fa-file-image-o text-warning',
          'bmp': 'fa fa-5x fa-file-image-o text-warning',
          'gif': 'fa fa-5x fa-file-image-o text-warning',

          'pdf': 'fa fa-5x fa-file-pdf-o text-danger',
          'doc': 'fa fa-5x fa-file-word-o text-primary',
          'docx': 'fa fa-5x fa-file-word-o text-primary',
          'xls': 'fa fa-5x fa-file-excel-o text-success',
          'xlsx': 'fa fa-5x fa-file-excel-o text-success',
          'ppt': 'fa fa-5x fa-file-powerpoint-o text-danger',
          'pptx': 'fa fa-5x fa-file-powerpoint-o text-danger'
        };

        self.FileName = data.OriginalFileName;
        self.FileSize = data.HumanReadableSize;
        self.FileClass = fileClasses[data.FileExtension];
        self.Filter = data.ExtendedMime.group;
        self.DownloadLink = "/employee-attachment/" + data.Id + "/download";
        self.PreviewLink = "/employee-attachment/" + data.Id + "/embed";

        self.canPreview = (self.Filter == 'Document');

        return self;
    }

    function UserViewModel() {
        var self = this;
        self.User = ko.observable();
    }

    GetUser();
});

function saveHandler(event) {
    event.preventDefault();

    var l = Ladda.create( document.getElementById('btnSave') );
    l.start();

    var _token = $("input[name='_token']").val();
    var data = $('#frmEditProfile').serializeJSON();
    var id = $('#employeeId').val();

    var fd = new FormData($('#frmEditProfile')[0]);
    fd.append('id', id);
    fd.append('data', data);

    var request = $.ajax({
        url: $('#frmEditProfile').attr('action'),
        dataType : 'json',
        data: fd,
        type: "POST",
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': _token
        },
    });

    request.done(function(response) {
        if(response.status ===  200) {
            $.amaran({
                'content': {
                    title: 'Profile',
                    message: 'Profile details updated',
                    info: '',
                    icon: 'fa fa-check'
                },
                'delay': 5500, // 5.5 seconds
                'closeButton': true,
                'position': 'top right'
            });
        }
    });
    request.fail(function(jqXHR, textStatus) {
        $.amaran({
            'content'   :{
                title: 'Profile',
                message: 'Please retry!',
                info: '',
                icon: 'fa fa-close',
                bgcolor: '000',
                color: 'red'
            },
            'delay': 5500, // 5.5 seconds
            'closeButton': true,
            'position': 'top right'
        });
    });

    request.always(function() {
        l.stop();
    });

    return false;
}