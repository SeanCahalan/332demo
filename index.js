
const pages = {
    "#tabs-1": "info",
    "#tabs-2": "committee",
    "#tabs-3": "attendee",
    "#tabs-4": "sponsor",
    "#tabs-5": "schedule"
}

$("a[href*='#tabs']").click(function(e){
    const href = $(this).attr('href');
    console.log('get ', pages[href], href);
    e.preventDefault();
    var $tab = $(href);
    $.post(`/332demo/${pages[href]}/${[pages[href]]}.php`, {id: $tab.attr('id')},function(html){
        $tab.html(html).show();
    })
})
