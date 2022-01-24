<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

use AppBundle\Entity\Address;
use AppBundle\Service\Uploader;



class UploadListener
{
	private $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(\Doctrine\ORM\Event\LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Address) {
            return;
        }

        $file = $entity->getPicture();

        // only upload new files
        if ($file instanceof UploadedFile && $file !== null) {        	
            $fileName = $this->uploader->upload($file);
            $entity->setPicture($fileName);
        } elseif ($file instanceof File) {
            $entity->setPicture($file->getFilename());
        }
    }

    public function postLoad(\Doctrine\ORM\Event\LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // only act on some "Product" entity
        if (!$entity instanceof Address) {
            return;
        }

        if ($fileName = $entity->getPicture()) {        	
            $entity->setPicture(new File($this->uploader->getTargetDirectory().'/'.$fileName));
        }
    }
}