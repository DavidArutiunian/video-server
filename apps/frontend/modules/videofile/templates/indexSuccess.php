<?php
/**
 * @var $VideoFiles VideoFile[]
 */
?>
<div class="navbar">
    <div class="brand">
        <a
            href="<?php echo url_for('homepage') ?>"
            class="brand__title link"
            title="Video Server"
        >
            <span>Video Server</span>
        </a>
    </div>
    <div class="upload__btn">
        <a
            title="Upload video"
            href="<?php echo url_for('video_file_new') ?>"
            class="upload__btn__title link"
        >
            <span>+</span>
        </a>
    </div>
</div>
<div class="video__table">
    <?php foreach ($VideoFiles as $videoFile): ?>
        <a
            href="<?php echo "videofile/show/{$videoFile->getId()}" ?>"
            class="video__table__item"
            title="<?php echo $videoFile->getTitle() ?>"
        >
            <div class="video__item__poster">
                <img
                    class="poster__img"
                    src="http://via.placeholder.com/640x360"
                    alt="<?php echo $videoFile->getTitle() ?>"
                >
            </div>
            <div class="video__item__title">
                <span><?php echo $videoFile->getTitle() ?></span>
            </div>
        </a>
    <?php endforeach; ?>
</div>
