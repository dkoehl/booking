// collapsed lists


var Collapseelems = document.querySelectorAll('.collapsible');
var instances = M.Collapsible.init(Collapseelems, {
    accordion: 'true',
    onOpenStart: true,
    onOpenEnd: true,
    onCloseStart: false,
    onCloseEnd: false
});