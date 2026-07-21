$('#toggleTax').click(function () {

    $('#taxBreakdown').slideToggle(200);

    $(this).find('.tax-arrow').toggleClass('rotate');

});