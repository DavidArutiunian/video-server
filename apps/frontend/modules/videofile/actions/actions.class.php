<?php

/**
 * video_file actions.
 *
 * @package    video-server
 * @subpackage videofile
 * @author     David Arutiunian
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class VideoFileActions extends sfActions
{
    private const FORM_NAME = 'video_file';

    public function executeIndex(): void
    {
        try {
            $this->VideoFiles = VideoFilePeer::doSelect(new Criteria());
        } catch (PropelException $e) {
            error_log($e->getMessage());
        }
    }

    public function executeShow(sfWebRequest $request): void
    {
        $this->VideoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));
        try {
            $this->forward404Unless($this->VideoFile);
        } catch (sfError404Exception $e) {
            error_log($e);
        }
    }

    public function executeNew(): void
    {
        try {
            $this->form = new VideoFileForm();
        } catch (sfException $e) {
            error_log($e->getMessage());
        }
        $this->form->getWidgetSchema()->setNameFormat(VideoFileActions::FORM_NAME . '[%s]');
    }

    public function executeCreate(sfWebRequest $request): void
    {
        try {
            $this->forward404Unless($request->isMethod(sfRequest::POST));

            $this->form = new VideoFileForm();

            $this->processForm($request, $this->form);

            $this->setTemplate('new');

            $this->redirect($this->generateUrl('homepage'));
        } catch (sfStopException $e) {
            error_log($e->getMessage());
        } catch (sfException $e) {
            error_log($e->getMessage());
        }
    }

    protected function processForm(sfWebRequest $request, VideoFileForm $form): void
    {
        $form->bind(
            $request->getParameter(VideoFileActions::FORM_NAME),
            $request->getFiles(VideoFileActions::FORM_NAME)
        );
        try {
            if ($form->isValid()) {

                $videoFile = $form->save();

                $this->redirect('video_file_show', array('id' => $videoFile->getId()));
            } else {
                $this->redirect($this->generateUrl('video_file_new'));
            }
        } catch (sfStopException $e) {
            error_log($e->getMessage());
        }
    }

    public function executeEdit(sfWebRequest $request): void
    {
        /**
         * @var bool | VideoFile $videoFile
         */
        $videoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));

        try {
            $str = 'Object videoFile does not exist (%s).';
            $message = sprintf($str, $request->getParameter('id'));
            $this->forward404Unless($videoFile, $message);

            $this->form = new VideoFileForm($videoFile);
        } catch (sfException $e) {
            error_log($e->getMessage());
        }
    }

    public function executeUpdate(sfWebRequest $request): void
    {
        /**
         * @var bool | VideoFile $videoFile
         */
        try {
            $isMethodPost = $request->isMethod(sfRequest::POST);
            $isMethodPut = $request->isMethod(sfRequest::PUT);
            $this->forward404Unless($isMethodPost || $isMethodPut);

            $videoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));

            $str = 'Object videoFile does not exist (%s).';
            $message = sprintf($str, $request->getParameter('id'));
            $this->forward404Unless($videoFile, $message);

            $this->form = new VideoFileForm($videoFile);
        } catch (sfException $e) {
            error_log($e->getMessage());
        }

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request): void
    {
        /**
         * @var bool | VideoFile $videoFile
         */
        try {
            $request->checkCSRFProtection();

            $videoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));

            $str = 'Object videoFile does not exist (%s).';
            $message = sprintf($str, $request->getParameter('id'));
            $this->forward404Unless($videoFile, $message);

            $videoFile->delete();

            $this->redirect('homepage');
        } catch (sfStopException $e) {
            error_log($e->getMessage());
        } catch (sfValidatorErrorSchema $e) {
            error_log($e->getMessage());
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
        } catch (PropelException $e) {
            error_log($e->getMessage());
        }
    }
}
