<?php
/**
 * @var VideoFileForm $form
 */
?>

<?php
use_stylesheets_for_form($form);
use_javascripts_for_form($form);
?>

<?php echo $form->renderFormTag('create') ?>
<table id="video_file_form">
    <tfoot>
    <?php if ($form->hasErrors()): ?>
        <tr>
            <td colspan="2">
                <?php echo $form->renderGlobalErrors() ?>
            </td>
        </tr>
    <?php endif; ?>
    <tr>
        <td>
            <button>
                <a class="link" href="<?php echo url_for('homepage') ?>">List</a>
            </button>
        </td>
        <td colspan="2">
            <input type="submit" value="Upload video"/>
        </td>
    </tr>
    </tfoot>
    <tbody>
    <?php echo $form ?>
    </tbody>
</table>
</form>
