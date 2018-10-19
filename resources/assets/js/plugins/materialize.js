$(function(){
    M.AutoInit();
    $('.dropdown-profile').dropdown({
        belowOrigin: false,
        constrainWidth: false,
        coverTrigger: false,
        alignment: 'right'
    });
    $('.dropdown-enterprise').dropdown();
})