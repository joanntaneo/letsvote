
<html>  
    <script src="js/jquery-1.12.4.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"></link>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"></link>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css.map"></link>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css.map"></link>
    <link rel="stylesheet" type="text/css" href="css/Common.css">
<head></head>  
  
<body>  
    <div class="container container-table">
        <div class="row vertical-center-row">  
            <div class="text-center col-md-4 col-md-offset-4">
                <div class="row"><p align="center"><h1>Let's Vote!</h1></p></div>
                <form action="controller/ElectionController.php?" method="POST" 
                    enctype="multipart/form-data">
                    <input type="hidden" name="action" id="action" value="uploadcsv"/>
                    <div class="row col-md-2 col-md-offset-4">
                        <br><input  type="file"  name="file" id="file" class="upload"/><br>
                    </div>
                    <div class="row  col-md-6 col-md-offset-3">
                        <input class="smallbutton" type="submit" name="submit" />
                    </div>
                </form>
            </div>                
        </div>
    </div>    
</body>  
</html>  

<script> 
    document.getElementById("file").onchange = function () {
        document.getElementById("uploadFile").value = this.value;
    };
</script>
