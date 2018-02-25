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
        try {
            // TODO: fix mysql connection issue
            $this->VideoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));
        } catch (PropelException $e) {
            error_log($e->getMessage());
        }
    }

    public function executeNew(): void
    {
        $this->form = new VideoFileForm();
        $this->form->getWidgetSchema()->setNameFormat(VideoFileActions::FORM_NAME . '[%s]');
    }

    public function executeCreate(sfWebRequest $request): void
    {
        try {
            $this->forward404Unless($request->isMethod(sfRequest::POST));
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
            return;
        }

        $this->form = new VideoFileForm();

        $this->processForm($request, $this->form);

        $this->setTemplate('new');

        try {
            $this->redirect($this->generateUrl('homepage'));
        } catch (sfStopException $e) {
            error_log($e->getMessage());
        }
    }

    protected function processForm(sfWebRequest $request, VideoFileForm $form): void
    {
        $form->bind(
            $request->getParameter(VideoFileActions::FORM_NAME),
            $request->getFiles(VideoFileActions::FORM_NAME)
        );
        if ($form->isValid()) {

            try {
                $form->save();
            } catch (sfValidatorError $e) {
                error_log($e->getMessage());
                return;
            }

            try {
                $this->redirect('homepage');
            } catch (sfStopException $e) {
                error_log($e->getMessage());
            }
        }
    }

    public function executeEdit(sfWebRequest $request): void
    {
        /**
         * @var bool | VideoFile $videoFile
         */
        try {
            $videoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));
        } catch (PropelException $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $this->forward404Unless($videoFile, sprintf('Object videoFile does not exist (%s).', $request->getParameter('id')));
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
            return;
        }

        $this->form = new VideoFileForm($videoFile);
    }

    public function executeUpdate(sfWebRequest $request): void
    {
        /**
         * @var bool | VideoFile $videoFile
         */
        try {
            $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $videoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));
        } catch (PropelException $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $this->forward404Unless($videoFile, sprintf('Object videoFile does not exist (%s).', $request->getParameter('id')));
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
            return;
        }

        $this->form = new VideoFileForm($videoFile);

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
        } catch (sfValidatorErrorSchema $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $videoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));
        } catch (PropelException $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $this->forward404Unless($videoFile, sprintf('Object videoFile does not exist (%s).', $request->getParameter('id')));
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $videoFile->delete();
        } catch (PropelException $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $this->redirect('videofile/index');
        } catch (sfStopException $e) {
            error_log($e->getMessage());
        }
    }
}