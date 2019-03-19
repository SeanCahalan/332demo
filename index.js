
const pages = {
    "#tabs-1": "info",
    "#tabs-2": "committee",
    "#tabs-3": "attendee",
    "#tabs-4": "sponsor",
    "#tabs-5": "schedule"
}

$(document).ready(() => {
    let hash = window.location.hash;
    if(pages[hash]){
        console.log('get ', pages[hash], hash);
        var $tab = $(hash);
        $.post(`/332demo/${pages[hash]}/${[pages[hash]]}.php`, {}, function(html){
            $tab.html(html).show();
        })
    }
})

$("a[href*='#tabs']").click(function(e){
    const href = $(this).attr('href');
    console.log('get ', pages[href], href);
    var $tab = $(href);
    $.post(`/332demo/${pages[href]}/${[pages[href]]}.php`, {id: $tab.attr('id')},function(html){
        $tab.html(html).show();
    })
})


var addAttendee = function(attendee_type){
    console.log("show attendee modal");
    var $form = $('#additional_attendee_form');
    $form.empty();
    if(attendee_type === 'student'){
        $.post(`/332demo/attendee/student_form.php`, {}, function(html){
            $form.html(html).show();
        })
    } else if (attendee_type === 'sponsor'){
        $.post(`/332demo/attendee/sponsor_form.php`, {}, function(html){
            $form.html(html).show();
        })
    }
    $('#add_attendee').modal('show');
}
