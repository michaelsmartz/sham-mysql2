/**
 * Created by TaroonG on 2017-02-23.
 */

var lastDeletedTask = '';
var todoMainContainer = '#todo-main-container';

function addNewTodoItem() {

    var taskText = $('#newTaskDescription').val();
    taskText = taskText.trim();
    //console.log('Add item: ', taskText, taskText.length);

    // add new item
    if (taskText.length > 0 && taskText.trim().toUpperCase() !=  "+ ADD NEW ITEM") {

        setButtonBusy(todoMainContainer, true);
        var tasksN = $('.task').length + 1;

        var request = sendAddNewTodoRequest({
            'forSelf':true, 'Description': $('#newTaskDescription').val()
        }, null, notifyTodoAddFail, null);

        request.done(function(msg) {
            // add to list
            /*
            var Id;
            if (typeof(msg) !== 'undefined') {
                Id = msg.Id;
            }
            var newTask = '<label for="task--' + Id + '" class="task task--new"><input class="task__check" type="checkbox" id="task--' + tasksN + '" /> <div class="task__field task--row">' + taskText + '<button class="task__important"><i class="fa fa-check" aria-hidden="true"></i></button></div></label>'
            $('.task__list').append(newTask);
            //clear add zone
            $('.task__add').val('');
            */
            notifyTodoAddSuccess(reloadTodoList());
        });

        request.always(function() {
            alwaysDefaultTodoHandler(todoMainContainer);
        });

    }
}

function toggleItem(id, checkElement, taskItem) {
    var taskCompleted = checkElement.is(':checked');

    setButtonBusy(todoMainContainer, true);

    var request = sendToggleItemRequest({
        'Id':id, 'itemStatus': taskCompleted
    }, null, notifyTodoToggleFail, null);

    request.done(function(msg) {
        /*taskItem.toggleClass('task-checked');;*/
        notifyTodoToggleSuccess(reloadTodoList());
    });
    request.always(function() {
        alwaysDefaultTodoHandler(todoMainContainer);
    });

}

function sendToggleItemRequest(datastring, doneCallback, failCallback, alwaysCallback) {
    // set callback parameters to null if omitted
    if (typeof(doneCallback) === 'undefined') doneCallback = null;
    if (typeof(failCallback) === 'undefined') failCallback = null;
    if (typeof(alwaysCallback) === 'undefined') alwaysCallback = null;

    if (typeof(bufferProgress) !== 'undefined') bufferProgress.start();

    var request = $.ajax({
        url: window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/my-todolist/toggle',
        type: "POST",
        global: false,
        data: datastring
    });

    (doneCallback) && request.done(doneCallback);
    (failCallback) && request.fail(failCallback);
    (alwaysCallback) && request.always(alwaysCallback);

    return request;
}

function sendAddNewTodoRequest(datastring, doneCallback, failCallback, alwaysCallback) {
    // set callback parameters to null if omitted
    if (typeof(doneCallback) === 'undefined') doneCallback = null;
    if (typeof(failCallback) === 'undefined') failCallback = null;
    if (typeof(alwaysCallback) === 'undefined') alwaysCallback = null;

    if (typeof(bufferProgress) !== 'undefined') bufferProgress.start();

    var request = $.ajax({
        url: window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/my-todolist/add',
        type: "POST",
        global: false,
        data: datastring
    });

    (doneCallback) && request.done(doneCallback);
    (failCallback) && request.fail(failCallback);
    (alwaysCallback) && request.always(alwaysCallback);

    return request;
}

function notifyTodoAddSuccess(reload) {
    var reloadCallback;
    if (typeof(reload) === 'undefined') {
        reloadCallback = function() {};
    } else {
        reloadCallback = reload;
    }

    $.amaran({
        /*'theme'     :'awesome ok',*/
        'content'   :{
            title: 'My todo list',
            message: 'New item added successfully',
            info: '',
            icon: 'fa fa-check'
        },
        'delay': 10500, // 10.5 seconds
        'closeButton': true,
        'position': 'top right',
        'afterEnd': reloadCallback
    });
}

function notifyTodoAddFail() {
    $.amaran({
        'theme'     :'awesome error',
        'content'   :{
            title: 'My todo list',
            message: 'An error has occurred while trying to add the new item. Please retry!',
            info: '',
            icon: 'fa fa-check'
        },
        'delay': 5500, // 5.5 seconds
        'closeButton': true,
        'position': 'top right'
    });
}

function notifyTodoToggleSuccess(reload) {
    var reloadCallback;
    if (typeof(reload) === 'undefined') {
        reloadCallback = function() {};
    } else {
        reloadCallback = reload;
    }

    $.amaran({
        'theme'     :'awesome ok',
        'content'   :{
            title: 'My todo list',
            message: 'Item updated successfully',
            info: '',
            icon: 'fa fa-check'
        },
        'delay': 10500, // 10.5 seconds
        'closeButton': true,
        'position': 'top right',
        'afterEnd': reloadCallback
    });
}

function notifyTodoToggleFail() {
    $.amaran({
        'theme'     :'awesome error',
        'content'   :{
            title: 'My todo list',
            message: 'An error has occurred while trying to update the item. Please retry!',
            info: '',
            icon: 'fa fa-check'
        },
        'delay': 5500, // 5.5 seconds
        'closeButton': true,
        'position': 'top right'
    });
}

function reloadPage() {
    location.reload();
}

function reloadTodoList() {
    setTimeout(function(){
        $('#newTaskDescription').val('');
        $(todoMainContainer + ' a[data-click="panel-reload"]').trigger('click');
    }, 50);
}

function alwaysDefaultTodoHandler(selector) {
    // set callback parameter to default selectors list if omitted
    if (typeof(selector) === 'undefined') {
        selector = todoMainContainer;
    }
    setButtonBusy(selector, false);

    if (typeof(bufferProgress) !== 'undefined') bufferProgress.end();
}

function checkList() {

    $('.task').each(function(){

        var $field = $(this).find('.task__field');
        var mousedown = false;

        $field.on('mousedown', function(){
            /*mousedown = true;
             $field.addClass('shaking');
             setTimeout(deleteTask,1000)*/
        });

        $field.on('mouseup', function(){
            /*mousedown = false;
             $field.removeClass('shaking');*/
        });

        function deleteTask(){
            if(mousedown) {
                $field.addClass('delete');
                lastDeletedTask = $field.text();
                //console.log(lastDeletedTask);

                setTimeout(function(){
                    $field.remove();
                }, 200);
            } else {
                return;
            }
        }

    });
}


var MyTodoListApp = function(containerSelector) {
    "use strict";

    if (typeof(containerSelector) === 'undefined') containerSelector = '#todo-main-container';

    this.$container = $(containerSelector);
    this.containerSelector = containerSelector;

    this.init();
};

MyTodoListApp.prototype = {

    //main function
    init: function () {
        this.generateCheckToggleHandler();
        this.generateFormSubmitHandler();
    },

    generateCheckToggleHandler: function() {

        $(document).on('click','li > .checkbox > .check > input[type="checkbox"]', function(e) {
            e.preventDefault();
            var $this = $(this), taskItem = $this.closest('li');
            toggleItem(taskItem.attr('id'), $this, taskItem);
        });
        return this;
    },

    generateFormSubmitHandler: function() {
        $('.todo-form').on('submit', function(event) {
            event.preventDefault();

            console.log('task form submit triggered');
            addNewTodoItem();

            // don't submit form
            return false;
        });
    }


};