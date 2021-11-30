<?php
    if(isset($_GET["save"])) :
?><?php

$myfile = fopen($_POST['path'], "w") or die("Unable to open file!");
$txt = $_POST['text'];
fwrite($myfile, $txt);
fclose($myfile);

?><?php
    elseif(isset($_GET["load"])) :
?><?php
$myfile = fopen($_POST['path'], "r") or die("Unable to open file!");
echo fread($myfile,filesize($_POST['path']));
fclose($myfile);
?><?php
    else :
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor</title>
    <link rel="stylesheet" href="./codemirror/lib/codemirror.css" />
    <script src="./codemirror/lib/codemirror.js"></script>
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <style>
        html, body{
            padding:0;
            margin:0;
            width: 100%;
            height: 100%;
        }
        
    </style>
</head>
<body>
    
    <form action="/editor.php?save=ok" method="post" enctype="multipart/form-data">
        <input id="path" name="path" type="text" placeholder="load path"><button type="button" id="load">Load File</button>
        <textarea id="editor" width="100%" name="editor" id="" cols="30" rows="20"></textarea>
        <button type="button" id="simpan">simpan</button>
    </form>

    <script>

        var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
            lineNumbers: true
        });

        editor.setSize(null, 'calc(100vh - 50px)');

        document.getElementById('load').addEventListener('click', function(){
            var path = document.getElementById('path').value;
            $.ajax({
                url: './editor.php?load=ok',
                method: "POST",
                dataType: "text",
                data: {
                    path: path
                },
                success:function(res){
                    editor.setValue(res)
                }
            })
            
        },false)

        document.getElementById('simpan').addEventListener('click', function(){
            var path = document.getElementById('path').value;
            $.ajax({
                url: './editor.php?save=ok',
                method: "POST",
                dataType: "text",
                data: {
                    path: path,
                    text: editor.getValue()
                },
                success:function(res){
                    alert('simpan')
                }
            })
        },false)

    </script>
</body>
</html>
<?php
    endif;
?>