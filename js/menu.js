document.addEventListener('DOMContentLoaded', function() {
    var submenus = document.querySelectorAll('submenu > a');
    submenus.forEach(function(submenu) {
        submenu.addEventListener('click', function(event) {
            event.preventDefault();
            var ul = this.nextElementSibling;
            ul.style.display = ul.style.display === 'block' ? 'none' : 'block';
        });
    });

});