<html>
<head>
<title>Untitled Document</title>

<script language="javascript" src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript">

send_data = function(name) {

        $.ajax({
      url: "/test/index.php",
            dataType: "json",
            data: {'name' : name},
            type: "POST",
            cache: false

    }).done(function(data, status, xml) {

         var obj = jQuery.parseJSON(data);
         alert(obj.success);

        }).fail(function(jqXHR, textStatus, errorThrown) {


        }).always(function() {


        });

}


$(document).ready(function() {

    $("#myform").submit(function() {

        var cb = $("input#firstname");

        if (cb.is(":checked")) {
            send_data(cb.val());
        } else {
            alert("not sending data - box is not checked");
        }
        return false; 
    });

});
</script>

</head>
<body>

<form id="myform" action="">
Check this box if your first name is Fred: 
<input type="checkbox" id="firstname" name="firstname" value="Fred" />
<input type="submit" value="Submit" />

</form>
</body>
</html>