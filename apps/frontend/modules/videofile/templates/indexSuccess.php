<h1>VideoFiles List</h1>

<table>
    <thead>
    <tr>
        <th>Url</th>
        <th>Title</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($VideoFiles as $VideoFile): ?>
        <tr>
            <td>
                <a href="<?php echo url_for('videofile_show', $VideoFile) ?>">
                    <?php echo $VideoFile->getTitle() ?>
                </a>
            </td>
            <td><?php echo $VideoFile->getUrl() ?></td>
            <td><?php echo $VideoFile->getTitle() ?></td>
            <td><?php echo $VideoFile->getDescription() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="<?php echo url_for('videofile/new') ?>">New video</a>
