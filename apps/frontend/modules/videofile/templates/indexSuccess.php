<?php
/**
 * @var $VideoFiles VideoFile[]
 */
?>
<h1>Videos</h1>
<br>
<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Type</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($VideoFiles as $videoFile): ?>
        <tr>
            <td>
                <a href="<?php echo "videofile/show?id={$videoFile->getId()}" ?>">
                    <?php echo $videoFile->getTitle() ?>
                </a>
            </td>
            <td><?php echo $videoFile->getDescription() ?></td>
            <td><?php echo VideoFileForm::getMimeType($videoFile->getType()) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<br>

<a href="<?php echo url_for('videofile/new') ?>">Upload video</a>
