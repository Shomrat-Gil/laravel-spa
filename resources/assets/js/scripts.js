
$( document ).ready(function() {
    // console.log($.fn.tooltip.Constructor.VERSION);
    $(window).scrollTop(0);  
     
    /**
    * activat bootstrap poover
    * 
    */
    $('body').popover({
        selector: '[data-toggle=popover]',
        trigger: 'click',   
    }) ; //initialize bootstrap popover
    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    /**
    * transform textarea to expandable one
    * 
    */
    $('body').on('change keyup keydown paste cut','textarea.expandable',  function () {    
        $(this).height(1).outerHeight(this.scrollHeight);   
    });
    
    /**                        
    *  google map address autocomplate prevent submit on enter
    */
    $('#address-tab').on('keyup keypress', 'form', function(e) {
        if(e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

// end ready    
});     
