<?php


class StrategyContext
{
    private $strategy;

    /**
     * StrategyContext constructor.
     * @param StrategyInterface $strategy
     */
    public function __construct(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param StrategyInterface $strategy
     */
    public function setStrategy(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function getResponse(array $request): array
    {
        return $this->strategy->prepareResponse($request);
    }
}
