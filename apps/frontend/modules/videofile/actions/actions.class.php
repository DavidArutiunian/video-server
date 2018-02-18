<?php

/**
 * videofile actions.
 *
 * @package    video-server
 * @subpackage videofile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class videofileActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->VideoFiles = VideofilePeer::doSelect(new Criteria());
    }

    public function executeShow(sfWebRequest $request)
    {
        $this->VideoFile = VideofilePeer::retrieveByPk($request->getParameter('id'));
//        $this->forward404Unless($this->VideoFile);
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->form = new VideoFileForm();
    }

    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        $this->form = new VideoFileForm();

        $this->processForm($request, $this->form);

        $this->setTemplate('new');

        $this->redirect($this->generateUrl('homepage'));
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $VideoFile = $form->save();

            $this->redirect('videofile/edit?id=' . $VideoFile->getId());
        }
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($VideoFile = VideofilePeer::retrieveByPk($request->getParameter('id')), sprintf('Object VideoFile does not exist (%s).', $request->getParameter('id')));
        $this->form = new VideoFileForm($VideoFile);
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($VideoFile = VideofilePeer::retrieveByPk($request->getParameter('id')), sprintf('Object VideoFile does not exist (%s).', $request->getParameter('id')));
        $this->form = new VideoFileForm($VideoFile);

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($VideoFile = VideofilePeer::retrieveByPk($request->getParameter('id')), sprintf('Object VideoFile does not exist (%s).', $request->getParameter('id')));
        $VideoFile->delete();

        $this->redirect('videofile/index');
    }
}
