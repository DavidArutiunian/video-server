<?php use_stylesheet('main.css') ?>

<table>
    <tbody>
    <tr>
        <th>Id:</th>
        <td><?php echo $VideoFile->getId() ?></td>
    </tr>
    <tr>
        <th>Type:</th>
        <td><?php echo $VideoFile->getType() ?></td>
    </tr>
    <tr>
        <th>Url:</th>
        <td><?php echo $VideoFile->getUrl() ?></td>
    </tr>
    <tr>
        <th>Title:</th>
        <td><?php echo $VideoFile->getTitle() ?></td>
    </tr>
    <tr>
        <th>Description:</th>
        <td><?php echo $VideoFile->getDescription() ?></td>
    </tr>
    <tr>
        <th>Created at:</th>
        <td><?php echo $VideoFile->getCreatedAt() ?></td>
    </tr>
    <tr>
        <th>Updated at:</th>
        <td><?php echo $VideoFile->getUpdatedAt() ?></td>
    </tr>
    </tbody>
</table>

<hr/>

<a href="<?php echo url_for('videofile/edit?id=' . $VideoFile->getId()) ?>">Edit</a>
<br>
<a href="<?php echo url_for('homepage') ?>">List</a>
