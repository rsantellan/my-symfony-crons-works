<div id="multiupload_view">

    <div id="selectview">

        <!-- <p><a id="add" class="addbutton hidden" href="#">Choose Files</a></p> -->
        <?php echo $form['upload'] ?>

        <div class="uploadtype"><?php echo html_entity_decode(str_replace(array('{a}','{/a}'), array('<a href="#basic" id="singleupload" onclick="basicUpload();">','</a>'), __('mdMediaManager_text_basicUpload')));?><!-- Gets filled by upload.js --></div>
    </div>

    <div id="fileblock">
        <table id="fileshead">
            <thead>
                <tr>
                    <td width="260"><?php echo __('mdMediaManager_text_file');?></td>
                    <td width="60"><?php echo __('mdMediaManager_text_size');?></td>
                    <td width="60"><?php echo __('mdMediaManager_text_status');?></td>
                </tr>
            </thead>
        </table>

        <div id="filelist">
            <table id="files">
                <thead>
                    <tr>
                        <td width="260"></td>
                        <td width="60"></td>
                        <td width="60"></td>
                    </tr>
                </thead>
                <tbody>
                <!-- Gets filled with file items -->
                </tbody>
            </table>
        </div>

        <p id="statsrow"><?php echo str_replace("{archivos}", "<span id='stats'></span>", __('mdMediaManager_text_addMoreText'));?> <a id="addmore" href="#action"><?php echo __('mdMediaManager_text_addMore');?></a></p>

        <p><a id="uploadstart" href="#action"><?php echo __('mdMediaManager_text_startUpload');?></a></p>

        <div id="status">
            <div id="progressbar" style="width: 0%"></div>
            <div class="progresstext">
                <span id="progressinfo"></span>&nbsp;<a id="abortupload" href="#action"></a>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
var __MD_UPLOAD_FILE_TEMPLATE = "<tr id=\"{id}\">" +
        "<td class=\"fname\"><a href=\"#action\" class=\"rename\">{name}</a></td>" +
        "<td class=\"size\">{sizefix}</td>" +
        "<td class=\"status\"><a href=\"#action\" class=\"remove\"><?php echo __("mdMediaManager_text_remove"); ?></a>" +
    "</tr>";


    var __MD_OBJECT_CATEGORY     = "<?php echo $category; ?>";
</script>
