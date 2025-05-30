<?php
    $path_for_images = '';
    require_once $_SESSION['WYSIWYGFileManagerRequirements'];
?>
<!DOCTYPE html>
<html>

    <head runat="server">
        <title></title>
        <link href="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/style/editor.css" rel="stylesheet" type="text/css" />
        <style>
            #inpFolder {
                border: 1px inset #ddd;
                font-size: 12px;
                -moz-border-radius: $radius3;
                -webkit-border-radius: $radius3;
                padding-left: 7px;
            }
        </style>
        <script src="jquery/jquery-1.7.min.js" type="text/javascript"></script>
        <script src="jqueryFileTree/jqueryFileTree.js" type="text/javascript"></script>
        <link href="jqueryFileTree/jqueryFileTree.css" rel="stylesheet" type="text/css" />
        <script src="jqueryFileTree/jquery.easing.js" type="text/javascript"></script>
        <link href="//fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css" />
        <script src="jquery/jquery.form.js" type="text/javascript"></script> <?php /* <link href="uploadify/uploadify.css" rel="stylesheet" type="text/css" />
    <script src="uploadify/jquery.uploadify.v2.1.4.min.js" type="text/javascript"></script>
    <script src="uploadify/swfobject.js" type="text/javascript"></script> */ ?> 
    <script language="javascript" type="text/javascript">
            var base = "<?php echo $path_for_images; ?>"; /*Relative to Root*/
            var readonly = false;
            var fullpath = false;
            $(document).ready(function() {
                $("#active_folder").val(base); /*default value*/
                renderTree(false);
                if (readonly) {
                    $("#lnkNewFolder").css("display", "none");
                    $("#lnkUpload").css("display", "none");
                }
            });

            function renderTree(bPreview) {
                $('#container_id').html("");
                $('#container_id').fileTree({
                    root: base + '/',
                    script: 'jqueryFileTree/jqueryFileTree_php',
                    expandSpeed: 750,
                    collapseSpeed: 750,
                    expandEasing: 'easeOutBounce',
                    collapseEasing: 'easeOutBounce',
                    multiFolder: true
                }, function(file) {
                    /*alert(file);*/
                    var fileurl = '';
                    var ext = file.split('.').pop().toLowerCase();
                    var filename = file.substr(file.lastIndexOf("/") + 1);
                    var filepath = file.replace('/editor/editor-image', '');
                    if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) != -1) {
                        $("#preview_id").html("<table><tr><td><a id='idFile' href='" + file + "' target='_blank' rel='" + filepath + "'><img id='imgFile' src='" + file +
                            "' style='width:70px;padding:4px;border:#cccccc 1px solid;background:#ffffff;margin-bottom:3px' /></a></td><td style='padding-left:20px;width:100%;text-align:left;'>" + filename +
                            "<br /><a id='lnkDelFile' style='font-weight:normal;font-size:10px;color:#c90000;word-spacing:2px;white-space:nowrap;' href='javascript:deleteFile()'>DELETE FILE</a></td></tr></table>");
                        if (fullpath) {
                            fileurl = window.location.protocol + "//" + window.location.host + file
                        } else {
                            fileurl = file
                        };
                        try {
                            parent.fileclick(fileurl);
                        } catch (e) {}
                    } else {
                        if (ext.indexOf("/") == -1) {
                            $("#preview_id").html("<table><tr><td><a id='idFile' target='_blank' href='" + file + "' style='color:#000000;background:#ffffff;margin-right:5px;' rel='" + filepath + "'>" + filename +
                                "</a></td><td>&nbsp;&nbsp;<a id='lnkDelFile' style='font-weight:normal;font-size:10px;color:#c90000;word-spacing:2px;white-space:nowrap;' href='javascript:deleteFile()'>DELETE FILE</a></td></tr></table>");
                            if (fullpath) {
                                fileurl = window.location.protocol + "//" + window.location.host + file
                            } else {
                                fileurl = file
                            };
                            try {
                                parent.fileclick(fileurl);
                            } catch (e) {}
                        }
                    }
                    preview();
                    if (file.substr(file.length - 1) == "/") {
                        //folder is selected
                        //$("#preview_id").html("");
                    }
                    var active_folder = file.substr(0, file.lastIndexOf('/')); /* ex. /images/sample */
                    $("#active_folder").val(active_folder);
                    $("#folder_id").html(active_folder.replace(base, '') +
                        "/   &nbsp;&nbsp;&nbsp; <a id='lnkDelFolder' href='javascript:deleteFolder()' style='display:none;font-weight:normal;font-size:10px;color:#c90000;word-spacing:2px'>DELETE&nbsp;FOLDER</a>");
                    if ($("#active_folder").val() == base) {
                        $("#lnkDelFolder").css("display", "none");
                    } else {
                        $("#lnkDelFolder").css("display", "inline");
                    }
                    $("#lnkNewFolder").css("display", "inline");
                    panelUpload();
                    if (readonly) {
                        $("#lnkDelFile").css("display", "none");
                        $("#lnkDelFolder").css("display", "none");
                        $("#lnkNewFolder").css("display", "none");
                        $("#lnkUpload").css("display", "none");
                    }
                });
                jQuery("#divNewFolder").hide();
                jQuery("#divUpload").hide();
                if (!bPreview) jQuery("#divPreview").hide();
            }

            function deleteFile() {
                if (confirm("Are you sure you want to delete this file?")) {
                    $.post('server/delfile.php', {
                        file: $("#idFile").attr("rel")
                    }, function(data) {
                        refresh();
                    });
                }
            }

            function deleteFolder() {
                if (confirm("Are you sure you want to delete this folder?")) {
                    $.post('server/delfolder.php', {
                        folder: $("#active_folder").val()
                    }, function(data) {
                        var active_folder = data.substr(0, data.lastIndexOf('/'));
                        $("#active_folder").val(active_folder);
                        $("#folder_id").html(active_folder.replace(base, '') +
                            "/   &nbsp;&nbsp;&nbsp; <a id='lnkDelFolder' href='javascript:deleteFolder()' style='display:none;font-weight:normal;font-size:10px;color:#c90000;word-spacing:2px'>DELETE&nbsp;FOLDER</a>");
                        refresh();
                    });
                }
            }

            function panelFolder() {
                jQuery("#divUpload").hide();
                jQuery("#divPreview").hide();
                $("#divNewFolder").slideToggle(750, 'easeOutBounce');
            }

            function createFolder() {
                $.post('server/newfolder.php', {
                    folder: $("#active_folder").val() + "/" + $("#inpFolder").val()
                }, function(data) {
                    refresh();
                    $("#inpFolder").val("");
                });
            }

            function refresh() {
                renderTree(true)
                //          if (base == $("#active_folder").val()) {
                ///              renderTree(true); /*Refresh Root*/
                //          }
                //          var rel = $("#active_folder").val() + '/';
                //         $('a[rel="' + rel + '"]').trigger("click").trigger("click");
                //$("#preview_id").html('');
            }

            function upload() {
                jQuery("#divNewFolder").hide();
                jQuery("#divPreview").hide();
                panelUpload();
                $("#divUpload").slideToggle(750, 'easeOutBounce');
            }
            $(document).on('change', '#File1', function() {
            // $(document).delegate('#File1', 'change', function() {
                $(document.frmImgUpload).ajaxSubmit({
                    url: 'server/upload.php',
                    success: (function(t, status, xhr, wrapper) {
                        refresh();
                    })
                });
            });

            function panelUpload() {
                $("#divUpload").html("<h3 style='margin-top:0px'>Upload Files</h3><input id='File1' name='Filedata' type='file' />");
                /* $('#File1').live('change', function(){
                    $(document.frmImgUpload).ajaxSubmit({
                        url: 'server/upload.php',
                        success: (function(t, status, xhr, wrapper){
                            refresh();
                        })
                    });
                }); */
                /* $("#File1").uploadify({
                    'uploader': 'uploadify/uploadify.swf',
                    'script': 'server/upload.php',
                    'cancelImg': 'uploadify/cancel.png',
                    'folder': $("#active_folder").val(),
                    'multi': true,
                    'auto': true,
                    'onComplete': function (event, ID, fileObj, response, data) {
                        //alert('There are ' + data.fileCount + ' files remaining in the queue.');
                        refresh();
                    }
                }); */
            }

            function preview() {
                if ($("#divPreview").css('display') == 'block') return;
                jQuery("#divNewFolder").hide();
                jQuery("#divUpload").hide();
                $("#divPreview").slideToggle(750, 'easeOutBounce');
            }
        </script>
    </head>

    <body style="margin:0px;background:#ffffff;font-family:Arvo;font-size:12px">
        <form id="form1" name="frmImgUpload" method="post" enctype="multipart/form-data">
            <input id="active_folder" name="folder" type="hidden" />
            <div style="padding:15px;background:#fcfcfc;border-bottom:#f7f7f7 1px solid;border-right:#f7f7f7 1px solid">
                <div style="margin-top:5px;margin-bottom:5px;"> <?php  /*  <a id="lnkNewFolder" href="javascript:panelFolder()" style="margin-right:10px;font-size:10px;color:#000;">NEW FOLDER</a> */ ?> <a id="lnkUpload" href="javascript:upload()"
                        style="margin-right:10px;font-size:10px;color:#000;">UPLOAD</a>
                </div>
                <div id="divPreview" style="margin-top:15px;padding:15px;padding-bottom:14px;border:#f3f3f3 1px solid;background:#fefefe;">
                    <div style="font-weight:bold;font-size:12pt;margin-bottom:5px;"> <?php /*Folder: <span id="folder_id">/</span> &nbsp;  */ ?> <a href="javascript:refresh()"
                            style="margin-right:10px;font-size:10px;color:#000;font-weight:normal;">REFRESH</a></div>
                    <div id="preview_id"></div>
                </div>
                <div id="divUpload" style="margin-top:15px;padding:15px;border:#f3f3f3 1px solid;background:#fefefe;">
                </div>
                <div id="divNewFolder" style="margin-top:15px;padding:15px;height:65px;border:#f3f3f3 1px solid;background:#fefefe;">
                    <h3 style="margin-top:0px">New Folder</h3>
                    <input type="text" id="inpFolder" style="width:120px;height:26px;float:left" value="">
                    <input type="button" id="btnAddFolder" value=" create " onclick="createFolder()" class="inpBtn" style="width:70px;height:30px;margin-right:0px" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
                </div>
            </div>
            <div id="container_id" style="padding:15px;">
            </div>
        </form>
    </body>

</html>
