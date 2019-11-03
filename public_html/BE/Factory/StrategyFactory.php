<?php

class StrategyFactory
{
    public function chooseStrategy($request)
    {
        $message = $request['message']['text'];

        $context = new StrategyContext(new Start());

        switch ($message) {
            case '/start':
                return $context->getResponse($request);
                break;
            case '/random':
                $context->setStrategy(new Random());
                return $context->getResponse($request);
                break;
            case '/info':
                $context->setStrategy(new Info());
                return $context->getResponse($request);
                break;
            default:
                $context->setStrategy(new Custom());
                return $context->getResponse($request);
        }
    }
}