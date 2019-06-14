/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.'){0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$("#btnAdd").click(function(){
    var selectedOpt = $("#noRole option:selected");

    selectedOpt.addClass('moved');

    if(selectedOpt.length === 0) return;

    $("#contract").append($(selectedOpt).clone());
    $(selectedOpt).remove();
});

$("#btnRemove").click(function(){
    var selectedOpt = $("#contract option:selected");

    selectedOpt.addClass('moved');

    if(selectedOpt.length === 0) return;

    $("#noRole").append($(selectedOpt).clone());
    $(selectedOpt).remove();
});

$("#roleSave").click(function(e){
    $("#contract option.moved").prop('selected', true);
    $("#noRole option.moved").prop('selected', true);
});

function appendLeadingZero(n)
{
    if(n <= 9)
    {
        return "0" + n;
    }
    return n;
}

function getDate(datestamp){
    var date = new Date(datestamp);
    var d = appendLeadingZero(date.getDate());
    var m = appendLeadingZero(date.getMonth() + 1);
    var y = date.getFullYear();

    return y + "-" + m + "-" + d;
}

if($("#startDate").val())
{
    var date = $("#startDate").val();

    var newDate = new Date(date);
    var minDate = getDate(newDate.setDate(newDate.getDate() + 1));
    var maxDate = getDate(newDate.setDate(newDate.getDate() + 367));

    $("#endDate").attr({
        'disabled': false,
        'min': minDate,
        'max': maxDate,
    });
}

$("#startDate").change(function(){
    var date = $("#startDate").val();

    if(date)
    {
        var newDate = new Date(date);
        var minDate = getDate(newDate.setDate(newDate.getDate() + 1));
        var maxDate = getDate(newDate.setDate(newDate.getDate() + 367));

        $("#endDate").attr({
            'disabled': false,
            'min': minDate,
            'max': maxDate,
        });
    }
    else
    {
        $("#endDate").attr({
            'disabled': true,
            'min': '',
            'max': '',
        }).val('');
    }
});

$("#localAccount").val() === '1' ? $("#localAccount").prop('checked', true) : $("#localAccount").val(0);
$("#isEdu").val() === '1' ? $("#isEdu").prop('checked', true) : $("#isEdu").val(0);

$(":checkbox").change(function(){
    $(this).is(':checked') ? $(this).val(1) : $(this).val(0);
});
