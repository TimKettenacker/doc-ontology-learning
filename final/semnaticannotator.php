<!DOCTYPE html>
<html>

<head>
    <title>Table with database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>

<body>
<div class="header">
  <img src="logo.png" alt="logo" />
  <h1>Semantic Annotation Interface</h1>
</div>
    <!-- <h1 align="center">Semantic Annotations Interface</h1><br> -->
    <table id=newsSample>
        <tr>
            <th>Event ID </th>
            <th>Event Summary</th>
            <!-- <th>Relation Phrase</th> -->
        </tr>

        <?php
        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        // echo $pageno;
        $no_of_records_per_page = 100;
        $offset = ($pageno-1) * $no_of_records_per_page;
        // echo $offset;
        $conn = mysqli_connect("localhost", "root", "", "news event extraction");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $total_pages_sql = "SELECT COUNT(*) FROM events";
        $result = mysqli_query($conn, $total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);
        //$sql = "SELECT event_id, event_summary, parsetree FROM events";
        //    $sql = "SELECT event_summary FROM events";
        $sql = "SELECT  * FROM events LIMIT $offset,
     $no_of_records_per_page";

        //     $sql ="SELECT * FROM events UNION ALL SELECT events.event_pos event_args ON  events.event_id=event_args.event_id"; 
        //    $sql.="SELECT IF (event)";

        $result = $conn->query($sql);
        //    echo $result;
        if (!$result) {
            trigger_error('Invalid query: ' . $conn->error);
        }
        if ($result->num_rows > 0) {
            // output data of each row
            $last_event_id = -1;
            $page_text = '';
            while ($row = $result->fetch_assoc()) {
                if ($last_event_id == -1) {
                    $last_event_id = $row['event_id'];

                    $page_text = '<tr><td>' . $last_event_id . '</td><td>' . $row['event_summary'] . '</td>';
                } else if ($last_event_id != $row['event_id']) {
                    $page_text = $page_text . '</td></tr>';
                    //        echo $page_text;

                    $page_text = $page_text . '<tr><td>' . $row['event_id'] . '</td><td>' . $row['event_summary'] . '</td><td>';

                    $last_event_id = $row['event_id'];
                }
            }
            $page_text = $page_text . '</td></tr>';
            echo $page_text;
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
        <ul class="pagination">
            <li><a href="?pageno=1">First</a></li>
            <li class="<?php if ($pageno <= 1) {
                            echo 'disabled';
                        } ?>">
                <a href="<?php if ($pageno <= 1) {
                                echo '#';
                            } else {
                                echo "?pageno=" . ($pageno - 1);
                            } ?>">Prev</a>
            </li>
            <li class="<?php if ($pageno >= $total_pages) {
                            echo 'disabled';
                        } ?>">
                <a href="<?php if ($pageno >= $total_pages) {
                                echo '#';
                            } else {
                                echo "?pageno=" . ($pageno + 1);
                            } ?>">Next</a>
            </li>
            <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
        </ul>
    </table>

    <script>
        im = -1
        $('#newsSample tr').each(function() {
            $(this).find('td:eq(1) span').each(function() {

                im = im + 1
                $(this).append($("<span id=" + im + " ><form id=myForm><input id=input1 type='radio' name='importance' value='important' checked>Important<br><input id=input2 type='radio' name='importance' value='not_important'>Not important  </form></span>").css("display", "none"));

                $(this).find('span').append($("<form id=textform><input id=input3 type=text  name='text' value=''/><input id=button text value=&#10003  type='button'/></form>").css("display", "none"));

                $(this).hover(
                    function() {

                        $(this).find("span").css("display", "block");

                        $(this).find("#myForm input:radio").click(function() {
                            if ($(this).is(':checked') && $(this).val() == "important") {
                                var check = $(this).val();
                                //                                  var text=$(this).closest('span').text();
                                //                                 var col = $(this).parent().children().index($(this));
                                var id = $(this).closest('span').attr('id');
                                //                                  console.log(text)
                                console.log(id)
                                $(this).closest('td').find('#' + id).css({
                                    'background-color': 'red'
                                });
                                //                                  var text=$(this).closest('span').text();
                                //                                  console.log(text);



                                $.ajax({
                                    url: 'save.php',
                                    type: 'POST',
                                    data: {
                                        check: check,
                                        id: id
                                    },
                                    success: function(data) {
                                        console.log(data);
                                    }
                                });
                                $(this).closest('span').find('#textform').css("display", "block");
                                //                                  
                                $(this).closest('span').find('#textform #button').on('click', function() {
                                    var text = $(this).closest('span').find('#input3').val();
                                    var id = $(this).closest('span').attr('id');

                                    console.log("ich bin hier");
                                    console.log(id);
                                    $.ajax({
                                        url: 'text.php',
                                        type: 'POST',
                                        data: {
                                            text: text,
                                            id: id
                                        },
                                        success: function(data) {
                                            console.log(data);
                                        }
                                    });
                                });
                                //                             var x=$(this).closest('span').css({'pointer-events': 'none'});     
                                //                              $(this).closest('td').find('#'+id).css({'pointer-events': 'none'});

                                //                              $(this).css({'pointer-events': 'none'});

                            } else if ($(this).is(':checked') && $(this).val() == "not_important") {
                                var check = $(this).val();
                                //                                 var col = $(this).parent().children().index($(this));
                                var id = $(this).closest('span').attr('id');
                                //                                  console.log(col)
                                console.log(id)

                                $.ajax({
                                    url: 'save.php',
                                    type: 'POST',
                                    data: {
                                        check: check,
                                        id: id
                                    },
                                    success: function(data) {
                                        console.log(data);
                                    }
                                });
                                //                                 alert('notimportant'); 
                                //                                  $('#employee_table tr').find("td:nth-child("+j+")").eq(i).append("<span style='background-color : orange; padding:2px 5px; margin: 0 5px; border-radius: 10px'>Not Important</span>");
                            }

                        });









                    },
                    function() {
                        $(this).find("span").css("display", "none");


                    }
                );
            });






        });
        $('<th>' + "Relation Phrase" + '</th>').insertAfter($('tr').first().find('th:last'));
        // $(this).find('#newsSample tr').each(function() {

        $('<td></td>').insertAfter($('td').eq(1));

        $('#newsSample tr').find(' td:eq(2)').append('<button  id=save type="button" class=myButton value="Save">Save</button>')

        //         $('td').eq(2).append("<div id=mydiv2 style='background-color:rgba(248, 150, 230, 1);'>" + val2 + '</div><a href="#" class="close-icon"></a>');
        //
        // });
        var j = -1;
        var list1 = []
        $('#newsSample tr').find('td:eq(1) .mydiv').on('click', function() {
            $(this).closest('tr').find('td:eq(2) .myButton').css("display", "block");
            var val2 = $(this).val();
            var id = $(this).attr('id');
            console.log(id);
            // j=j+1;
            console.log(list1);
            // $var=$(this).closest('tr').find('td').eq(2).text();
            if (!$(this).closest('tr').find('td').eq(2).is(':contains(' + val2 + ')')) {
                $(this).closest('tr').find('td').eq(2).append("<div id=" + id + " class=span1 style='background-color:rgba(248, 150, 230, 1);'>" + val2 +" "+ '<input type=button id=' + id + ' href="#" class="close-icon"/></div>');
                // $(this).closest('tr').find('td').eq(2).append("<div> </div?");
            }

            $(this).closest('tr').find(' td:eq(2)  #' + id).on('click', function() {
                // var id2=$(this).closest('tr').find(' td:eq(2) #'+id).attr('id');
                // console.log(id2);
                $(this).closest('tr').find(' td:eq(2)  #' + id).remove();


            });

        });

        $('#newsSample tr').find('td:eq(2) #save').on('click', function() {

            var relphrase = $(this).closest('tr').find(' td:eq(2) div').text();
            var eventid=$(this).closest('tr').find(' td:eq(0)').text();
            // var annotatorid=<?php ?>
            

            console.log(relphrase);
            console.log(eventid);
            $(this).closest('tr').find(' td:eq(1) ').css({
                'pointer-events': 'none'
            });
            // $.ajax({
            //     url: 'relphrase.php',
            //     type: 'POST',
            //     data: {
            //         relphrase: relphrase,
            //         eventid: eventid
            //     },
            //     success: function(data) {
            //         console.log(data);
            //     }
            // });

        });

        //        
    </script>

</body>

</html>