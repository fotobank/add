
// גûחמג out
/*window.outDebug = function (msg, title, group){
 window.hackerConsole = window.hackerConsole || window.Debug_HackerConsole_Js && new window.Debug_HackerConsole_Js();
 if (window.hackerConsole) setTimeout(function() { with (window.hackerConsole) {
 out(msg, title, group);
 }}, 200);
 };*/

(function( $ ) {
    $.fn.outDebug = function (msg, title, group){
        return this.each(function() {
            window.hackerConsole = window.hackerConsole || window.Debug_HackerConsole_Js && new window.Debug_HackerConsole_Js();
            if (window.hackerConsole) setTimeout(function() { with (window.hackerConsole) {
                out(msg, title, group);
            }}, 200);
        });
    };
})(jQuery);