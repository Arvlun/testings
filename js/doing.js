$(document).ready( function() {

        initialize();

        $(function() {
        //console.log("stage1");
        $.ajax({
          url: "php/updatemenubar.php",
          success: function(response){
                //console.log("stage2");
                //console.log(response);
                $("#navBarTop").html(response);
                initialize();
          },
          error: function() {
            $("#navBarTop").html("WUT");
          }
        });

        $("#testButton").on("click", function() {
            //$('#maincontent').html('');
            $("#maincontent").html("TEST");
        });
   
        });

});

function initialize() {

        $("#adddata").on("click", function() {
           //$('#maincontent').html('');
            $("#maincontent").load("lcl/adddata.html");
        });

        $("#register").on("click", function() {
           //$('#maincontent').html('');
            $("#maincontent").load("lcl/register.html");
        });

        $("#login").on("click", function() {
           //$('#maincontent').html('');
            $("#maincontent").load("lcl/login.html");
        });

        $("#editacc").on("click", function() {
            $.ajax({
                url: "php/edit_account.php",
                success: function(response){
                //console.log("stage2");
                //console.log(response);
                $("#maincontent").html(response);
                //initialise();
                },
                error: function() {
                    $("#maincontent").html("WUT");
                }
            });
        });

        $("#member").on("click", function() {
            $.ajax({
                url: "php/memberlist.php",
                success: function(response){
                //console.log("stage2");
                //console.log(response);
                $("#maincontent").html(response);
                //initialise();
                },
                error: function() {
                    $("#maincontent").html("WUT");
                }
            });
        });

        $("#display").on("click", function() {
            $.ajax({
                url: "php/displaydata.php",
                success: function(response){
                //console.log("stage2");
                //console.log(response);
                $("#maincontent").html(response);
                initializeDelete();
                },
                error: function() {
                    $("#maincontent").html("WUT");
                }
            });
        });
};

function initializeDelete() {
    $(".deletedata").on("click", function() {
            var butid = $(this).attr('id');
            //console.log(id);
            $.ajax({
                type: 'POST',
                url: "php/deletedata.php",
                data: { id: butid },
                success: function(response){
                //$(this).closest('tr').remove();
                $('#row'+response).remove();
                //$("#maincontent").html(response);
                //initialiseDelete();

                },
                error: function() {
                    $("#maincontent").html("WUT");
                }
            });
        });

    $(".updatedata").on("click", function() {
            var $row = $(this).closest("tr"), 
                $tds = $row.find("td");
            var rowvalues = [];
            $.each($tds, function() {               
                rowvalues.push($(this).text());
            });
            console.log(rowvalues);
            $('#row'+rowvalues[0]).html('<td class="tidfield">'+rowvalues[0]+'</td>'+
                                        '<td class="tdatafield"><input style="width:100%;" type="text" id="namn'+rowvalues[0]+'" name="namn'+rowvalues[0]+'" value="'+rowvalues[1]+'"></td>'+
                                        '<td class="tdatafield"><input style="width:100%;" type="text" id="ingred'+rowvalues[0]+'" name="ingred'+rowvalues[0]+'" value="'+rowvalues[2]+'"></td>'+
                                        '<td class="tdatafield"><input style="width:100%;" type="number" id="pris'+rowvalues[0]+'" name="pris'+rowvalues[0]+'" value="'+rowvalues[3]+'"></td>'+
                                        '<td class="tdatafield"><input style="width:100%;" type="number" id="fampris'+rowvalues[0]+'" name="fampris'+rowvalues[0]+'" value="'+rowvalues[4]+'"></td>'+
                                        '<td class="tdatafield"><Button type="button" class="upddatasave" id="sub'+rowvalues[0]+'">Submit</button></td>');
            intializeUpdatebutton();
        });
}

function intializeUpdatebutton() {

        $(".upddatasave").on("click", function() {
            var butid = $(this).attr('id');
            var dataid = parseInt(butid.slice(3));
            $.ajax({
                type: 'POST',
                url: "php/updatedata.php",
                data: { id: dataid,
                        namn: $('#namn'+dataid).val(),
                        ingred: $('#ingred'+dataid).val(),
                        pris: parseInt($('#pris'+dataid).val()),
                        fampris: parseInt($('#fampris'+dataid).val())},
                success: function(response){
                $('#row'+dataid).html(response);
                initializeDelete();
                },
                error: function() {
                    $("#maincontent").html("WUT");
                }
            });
        });
}

