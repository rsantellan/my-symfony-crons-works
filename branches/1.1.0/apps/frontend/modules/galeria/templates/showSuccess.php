<?php use_javascript('frontend/jquery.lightbox-0.5.js','last') ?>
<?php use_stylesheet('frontend/lightbox.css') ?>
				<h1><?php echo __('Galeria_Titulo') ?></h1>
        <img src="/images/frontend/titl_galeria.jpg" class="titl" />
        <h2><?php echo $galeria->getTitulo() ?></h2>
        <p><?php echo $galeria->getDescripcion() ?></p>
            <div id="gallery">
                <ul>
<?php
$media = mdMediaManager::getInstance(mdMediaManager::MIXED, $galeria)->load();

foreach($media->getItems(mdMedia::$default) as $pic):
?>
                    <li>
                        <a href="<?php echo $pic->getUrl(array(mdWebOptions::WIDTH => 301, mdWebOptions::CODE => mdWebCodes::ORIGINAL)) ?>" title="<?php echo $galeria->getTitulo() ?>"/>
                            <img src="<?php echo $pic->getUrl(array(mdWebOptions::WIDTH => 115, mdWebOptions::HEIGHT => 75,  mdWebOptions::CODE => mdWebCodes::ORIGINAL)) ?>" width="115" height="75" alt="" />
                        </a>
                    </li>
<?php endforeach; ?>
                </ul>
            </div>
						<script type="text/javascript">
						    $(function() {
						        $('#gallery a').lightBox();
						    });
						    </script>
