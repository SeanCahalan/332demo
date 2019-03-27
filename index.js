
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

var editSchedule = function(room, startTime, endTime){
    console.log("show schedule modal");
    var $form = $('#edit_schedule_form'); // id of the div where stuff gets inserted
    $form.empty();
        $.post(`/332demo/schedule/edit_form.php`, {room: room, start_time: startTime, end_time: endTime}, function(html){
            $form.html(html).show();
        })
    $('#edit_schedule').modal('show'); //id of the modal
}

//modal id = edit_schedule


//.innerhtml = 

// put the whole `/332demo/schedule/edit_form.php`

// things in curly braces accesable by script

//look up jquery set the value of an input
// or php get post data from jquery 


// $form.html(html).show(); call div editform