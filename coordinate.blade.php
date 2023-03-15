<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->

    <style>
        body {
            background-color: lightblue;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>

    <script>
        $(document).on('mousedown', 'select option', function(e) {
            var self = $(this);
            var selectedValue = self.val();
            //alert(selectedValue)
            if ($('#' + selectedValue).length) { // check if element with the same ID exists
                return; // exit the function
            }
            var draggableDiv = $('<div/>').prop('id', selectedValue).css({
                position: 'absolute',
                left: e.pageX,
                top: e.pageY,
                width: 100,
                height: self.height(),
                cursor: 'default',
                background: '#ff0',
                opacity: 1
            }).text(self.val());
            $('form').append(draggableDiv);

            draggableDiv.draggable({
                revert: false,
            });
        });

        //
        $(function() {
            debugger

            var positions = [];
            $("form-control").draggable();
            $("canvas").droppable({

                drop: function(event, ui) {
                    debugger
                    var id = ui.draggable.attr("id");
                    var offset = $(this).offset();
                    var xPos = ui.offset.left - offset.left;
                    var yPos = ui.offset.top - offset.top;
                    //var Input=selectedValue;
                    positions[id] = {
                        x: xPos,
                        y: yPos
                    };
                    //alert(xPos, yPos);
                    $("#Input").text(id);
                    //$("#coordinates").text("X: " + xPos + ", Y: " + yPos);
                    $("#coordinates").text(xPos);
                    $("#ycoordinates").text(yPos);

                }
            });
        });
    </script>
    <style>
        canvas {
            border: 1px solid black;
        }
    </style>
</head>

<body>
 <title>Image Coordinates</title>
    <div class="container-fluid">
        <form id="myForm" method="post" action='run'>
            @csrf
            <input type="hidden" id="custId" name="cusId" value={{ $document->id }}>
            <div class="col-md-4 " style="margin-left:605px">
                <label for="input">Input value:</label>
                <select name="fname" id='input' class="form-control" multiple='multiple'>
                    <option value="0">Please select ...</option>
                    <option value="HallticketNumber">HallticketNumber</option>
                    <option value="Name">Name</option>
                    <option value="FatherName">FatherName</option>
                    <option value="Age">Age</option>
                    <option value="DOB">DOB</option>
                    <option value="email">email</option>
                    <option value="Petlocation">Petlocation</option>
                    <option value="Gender">Gender</option>
                </select>
            </div>

            <center>
                <canvas id="canvas"></canvas>
                <p id="Input" name='Fieldname' style="font-family:verdana;font-size:160%;"></p>
                <p id="coordinates" name="fool" style="font-family:verdana;font-size:160%;"></p>
                <p id="ycoordinates" name="fool2" style="font-family:verdana;font-size:160%;"></p>
                <button type="submit">Submit</button>
            </center>

            <input type="hidden"  id="Input2" name='name2'>
            <input type="hidden"id="Xco" name="X" >
            <input type="hidden"id="Yco" name="Y" >

        </form>

    </div>


</body>

</html>

<script>
    // Get canvas element
    var canvas = document.getElementById('canvas');

    // Set canvas dimensions
    canvas.width = 1121;
    canvas.height = 789;

    // Get canvas context
    var ctx = canvas.getContext('2d');

    // Create image object
    var img = new Image();

    // Set image source
    img.src = '{{ url("images/$document->certificate_path") }}';

    // Draw image on canvas
    img.onload = function() {
        ctx.drawImage(img, 0, 0);
    }
</script>

{{-- //ajax --}}
<script>
    jQuery('#myForm').submit(function(e) {
        // var id = $('#input :selected').toArray().map(item => item.val);
        var name = document.getElementById("Input").innerHTML;
        var latitude =  document.getElementById("coordinates").innerHTML;
        var longitude =  document.getElementById("ycoordinates").innerHTML;
        document.getElementById("Input2").value = name;
        //alert(name);
         //coordinates
         document.getElementById("Xco").value = latitude;
         document.getElementById("Yco").value = longitude;
         //alert(longitude);
        e.preventDefault();
        jQuery.ajax({
            url: "{{ url('run') }}",
            data: jQuery('#myForm').serialize(),
            //data:{name:name},
            type: 'post',
            success: function(result) {
                alert(result);
                //console.log(result)
            },
            error: function(xhr, status, error) {
                alert("Error occured", error);
            }
        })
    })
</script>
