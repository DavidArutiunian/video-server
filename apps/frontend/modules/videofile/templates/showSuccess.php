<?php
/**
 * @var VideoFile $VideoFile
 */
?>
<div class="navbar">
    <div class="brand">
        <a
            href="<?php echo url_for('homepage') ?>"
            class="brand__title link"
            title="Video Server"
        >
            <span class="brand__text">Video Server</span>
        </a>
    </div>
    <div class="upload__btn">
        <a
            title="Upload video"
            href="<?php echo url_for('video_file_new') ?>"
            class="upload__btn__title link"
        >
            <span class="upload__btn__text">+</span>
        </a>
    </div>
</div>
<?php if ($VideoFile) { ?>
    <div class="video__wrapper">
        <div class="video__frame">
            <!-- TODO: put thumb to poster -->
            <video
                class="video__frame__item"
                poster="http://via.placeholder.com/640x360"
                controls tabindex="0" preload="auto"
            >
                <source
                    src="<?php echo $VideoFile->getAbsoluteUrlToFile() ?>"
                    type="<?php echo VideoFile::getMimeType($VideoFile->getType()) ?>"
                >
            </video>
        </div>
    </div>
    <div class="video__meta">
        <div class="video__title">
            <span><?php echo $VideoFile->getTitle() ?></span>
        </div>
        <div class="video__description">
            <p>
                <?php echo $VideoFile->getDescription() ?>
            </p>
        </div>
    </div>
<?php } else { ?>
    <div class="error">
        <span>Some error happened :(</span>
    </div>
<?php } ?>
