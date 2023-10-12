<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionApiSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();
        $exception = $event->getThrowable();

        if(strpos($request->getPathInfo(),"/admin35786/api/")!== 0){
            return;
        }
   
        if ($exception instanceof NotFoundHttpException || $exception instanceof BadRequestHttpException) {
            
            $data = [
                'error' => 'Not Found',
                'message' => $exception->getMessage(),
            ];
            $response = new JsonResponse($data, $exception->getStatusCode());
            $event->setResponse($response);
            
        }
        
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
