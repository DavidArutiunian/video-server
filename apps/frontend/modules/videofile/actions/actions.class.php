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
    public function executeIndex(sfWebRequest $request)
    {
        try {
            $this->VideoFiles = VideoFilePeer::doSelect(new Criteria());
        } catch (PropelException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function executeShow(sfWebRequest $request)
    {
        try {
            $this->VideoFile = VideoFilePeer::retrieveByPk($request->getParameter('id'));
        } catch (PropelException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function executeNew(sfWebRequest $request)
    {
        try {
            $this->form = new VideoFileForm();
            $this->form->getWidgetSchema()->setNameFormat('video_file[%s]');
        } catch (sfException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function executeCreate(sfWebRequest $request)
    {
        try {
            $this->forward404Unless($request->isMethod(sfRequest::POST));
        } catch (sfError404Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        try {
            $this->form = new VideoFileForm();
        } catch (sfException $e) {
            echo "Error: " . $e->getMessage();
        }

        $this->processForm($request, $this->form);

        $this->setTemplate('new');

        try {
            $this->redirect($this->generateUrl('homepage'));
        } catch (sfStopException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter('video_file'), $request->getFiles('video_file'));
        if ($form->isValid()) {
            $form->save();

            try {
                $this->redirect('homepage');
            } catch (sfStopException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function executeEdit(sfWebRequest $request)
    {
        try {
            $this->forward404Unless($VideoFile = VideoFilePeer::retrieveByPk($request->getParameter('id')), sprintf('Object VideoFile does not exist (%s).', $request->getParameter('id')));
        } catch (PropelException $e) {
        } catch (sfError404Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        try {
            $this->form = new VideoFileForm($VideoFile);
        } catch (sfException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function executeUpdate(sfWebRequest $request)
    {
        try {
            $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        } catch (sfError404Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        try {
            $this->forward404Unless($VideoFile = VideoFilePeer::retrieveByPk($request->getParameter('id')), sprintf('Object VideoFile does not exist (%s).', $request->getParameter('id')));
        } catch (PropelException $e) {
        } catch (sfError404Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        try {
            $this->form = new VideoFileForm($VideoFile);
        } catch (sfException $e) {
            echo "Error: " . $e->getMessage();
        }

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request)
    {
        try {
            $request->checkCSRFProtection();
        } catch (sfValidatorErrorSchema $e) {
            echo "Error: " . $e->getMessage();
        }

        try {
            $this->forward404Unless($VideoFile = VideoFilePeer::retrieveByPk($request->getParameter('id')), sprintf('Object VideoFile does not exist (%s).', $request->getParameter('id')));
        } catch (PropelException $e) {
            echo "Error: " . $e->getMessage();
        } catch (sfError404Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        try {
            $VideoFile->delete();
        } catch (PropelException $e) {
            echo "Error: " . $e->getMessage();
        }

        try {
            $this->redirect('videofile/index');
        } catch (sfStopException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
