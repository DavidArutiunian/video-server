<?php
/**
 * @var VideoFile | null $VideoFile
 */
?>
<h1><?php echo $VideoFile->getTitle() ?></h1>
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
    <tr>
        <td><?php echo $VideoFile->getTitle() ?></td>
        <td><?php echo $VideoFile->getDescription() ?></td>
        <td><?php echo VideoFileForm::getMimeType($VideoFile->getType()) ?></td>
    </tr>
    </tbody>
</table>
<br>
<a href="<?php echo url_for('homepage') ?>">List</a>
