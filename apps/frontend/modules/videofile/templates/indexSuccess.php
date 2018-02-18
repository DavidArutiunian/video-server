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
    <?php foreach ($VideoFiles as $VideoFile): ?>
        <tr>
            <td><?php echo $VideoFile->getType() ?></td>
            <td><?php echo $VideoFile->getTitle() ?></td>
            <td><?php echo $VideoFile->getDescription() ?></td>
            <td>
                <a href="<?php echo $VideoFile->getUrl() ?>" target="_blank">
                    <?php echo $VideoFile->getUrl() ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<br>

<a href="<?php echo url_for('videofile/new') ?>">Upload video</a>
