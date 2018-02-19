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
        <th>Type</th>
        <th>Title</th>
        <th>Description</th>
        <th>URL</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($VideoFiles as $videoFile): ?>
        <tr>
            <td><?php echo $videoFile->getType() ?></td>
            <td><?php echo $videoFile->getTitle() ?></td>
            <td><?php echo $videoFile->getDescription() ?></td>
            <td>
                <a href="<?php echo $videoFile->getUrl() ?>" target="_blank">
                    <?php echo $videoFile->getUrl() ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<br>

<a href="<?php echo url_for('videofile/new') ?>">Upload video</a>
