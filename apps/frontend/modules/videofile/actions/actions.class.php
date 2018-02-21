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
    public function executeIndex(sfWebRequest $request): void
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

    public function executeNew(sfWebRequest $request): void
    {
        try {
            $this->form = new VideoFileForm();
            $this->form->getWidgetSchema()->setNameFormat('video_file[%s]');
        } catch (sfException $e) {
            error_log($e->getMessage());
        }
    }

    public function executeCreate(sfWebRequest $request): void
    {
        try {
            $this->forward404Unless($request->isMethod(sfRequest::POST));
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $this->form = new VideoFileForm();
        } catch (sfException $e) {
            error_log($e->getMessage());
            return;
        }

        $this->processForm($request, $this->form);

        $this->setTemplate('new');

        try {
            $this->redirect($this->generateUrl('homepage'));
        } catch (sfStopException $e) {
            error_log($e->getMessage());
        }
    }

    protected function processForm(sfWebRequest $request, sfForm $form): void
    {
        $form->bind($request->getParameter('video_file'), $request->getFiles('video_file'));
        if ($form->isValid()) {

            $form->save();

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
         * @var bool | VideoFile $VideoFile
         */
        try {
            $VideoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));
        } catch (PropelException $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $this->forward404Unless($VideoFile, sprintf('Object VideoFile does not exist (%s).', $request->getParameter('id')));
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $this->form = new VideoFileForm($VideoFile);
        } catch (sfException $e) {
            error_log($e->getMessage());
        }
    }

    public function executeUpdate(sfWebRequest $request): void
    {
        /**
         * @var bool | VideoFile $VideoFile
         */
        try {
            $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $VideoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));
        } catch (PropelException $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $this->forward404Unless($VideoFile, sprintf('Object VideoFile does not exist (%s).', $request->getParameter('id')));
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $this->form = new VideoFileForm($VideoFile);
        } catch (sfException $e) {
            error_log($e->getMessage());
        }

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request): void
    {
        /**
         * @var bool | VideoFile $VideoFile
         */
        try {
            $request->checkCSRFProtection();
        } catch (sfValidatorErrorSchema $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $VideoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));
        } catch (PropelException $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $this->forward404Unless($VideoFile, sprintf('Object VideoFile does not exist (%s).', $request->getParameter('id')));
        } catch (sfError404Exception $e) {
            error_log($e->getMessage());
            return;
        }

        try {
            $VideoFile->delete();
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
