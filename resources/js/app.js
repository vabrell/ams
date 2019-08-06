/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(function(){

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
        var maxDate = getDate(newDate.setDate(newDate.getDate() + 33));

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
            var maxDate = getDate(newDate.setDate(newDate.getDate() + 33));

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

});
