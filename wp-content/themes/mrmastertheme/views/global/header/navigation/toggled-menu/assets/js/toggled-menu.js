(function () {
    initializeToggledMenu(); 
})(); 

function initializeToggledMenu(){
    //if all the necessary elements exist: 
    if (document.getElementById('menu-toggle-trigger') && document.getElementById('toggled-nav') && document.getElementById('close-toggled-menu')) {

        //declare constants for the elements:
        const menu_toggle_trigger = document.getElementById('menu-toggle-trigger');
        const toggled_nav = document.querySelector('#toggled-nav'); 
        const menu_close_trigger = document.getElementById('close-toggled-menu');

        //add click functionality to the toggle-menu trigger button:
        menu_toggle_trigger.addEventListener('click', function(e) {
            var isExpanded = menu_toggle_trigger.getAttribute('aria-expanded') === 'true';

            if (!isExpanded) {
                //toggle the button & menu to it's "open" state:
                menu_toggle_trigger.setAttribute('aria-expanded', 'true');
                toggled_nav.setAttribute('aria-hidden', false);

                document.body.classList.add('modal-open');
                document.body.classList.add('toggled-menu-open');
            } else {
                //toggle the button & menu to it's "closed" state:
                menu_toggle_trigger.setAttribute('aria-expanded', 'false');
                toggled_nav.setAttribute('aria-hidden', true);

                document.body.classList.remove('modal-open');
                document.body.classList.remove('toggled-menu-open');
            }
        });

        //add click functionality to the close menu button:
        menu_close_trigger.addEventListener('click', function(e) {
            menu_toggle_trigger.setAttribute('aria-expanded', 'false');
            toggled_nav.setAttribute('aria-hidden', true);

            document.body.classList.remove('modal-open');
            document.body.classList.remove('toggled-menu-open');
        });

        //add focusout event listener. so when you leave the menu from tabbing, everything resets properly
        menu_close_trigger.addEventListener('focusout', function(e) {
            menu_toggle_trigger.setAttribute('aria-expanded', 'false');
            toggled_nav.setAttribute('aria-hidden', true);

            document.body.classList.remove('modal-open');
            document.body.classList.remove('toggled-menu-open');
        });  
    } 
}