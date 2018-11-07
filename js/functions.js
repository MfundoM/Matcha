// $(document).ready(function() {
//     $(".mr-auto .nav-item").bind("click", function(event) {
//         event.preventDefault();
//         var clickedItem = $(this);
//         $(".mr-auto .nav-item").each(function() {
//             $(this).removeClass("active");
//         });
//         clickedItem.addClass("active");
//     });
// });

function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

// $(function () {
//     $(".date").datepicker({
//         autoclose: true,
//         todayHighlight: true
//     });
// });

function toggleDiv(divid)
{
    varon = divid + 'on';
    varoff = divid + 'off';

    if(document.getElementById(varon).style.display == 'block')
    {
        document.getElementById(varon).style.display = 'none';
        document.getElementById(varoff).style.display = 'block';
    }
    else
    {
        document.getElementById(varoff).style.display = 'none';
        document.getElementById(varon).style.display = 'block'
    }
}