$("#nav-options").on("click", () => { $(".nav-dropdown").toggle(); })

$("#nav-reponsive").on("click", () => { if ($("#nav-crinmo").hasClass('nav-on')) { $("#nav-crinmo").removeClass('nav-on') } else { $("#nav-crinmo").addClass('nav-on'); } })

$(document).on('mouseup', function (e) {

    const container = $("#nav-options");
    if (!container.is(e.target) && $(".nav-dropdown").is(':visible') && $("#nav-reponsive").is(':hidden')) {
        $(".nav-dropdown").toggle();
    }
});