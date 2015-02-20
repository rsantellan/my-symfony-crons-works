<div class="content">
    <div class="pure-g">
        <div class="l-box-lrg pure-u-1 pure-u-md-1">
            <a href="<?php echo url_for("@export_newsletter_user?id=".$id);?>" class='pure-button' style='margin-bottom: 20px;'>
                <?php echo __("newsletter_Bajar lista de usuarios");?>
            </a>
            
            <table class='pure-table pure-table-bordered pure-table-striped'>
                <thead>
                    <tr>
                        <th>Correo electronico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($results as $email): ?>
                        <tr>
                            <td><?php echo $email; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

