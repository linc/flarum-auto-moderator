<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Api\Controller;

use Askvortsov\AutoModerator\Action\ActionManager;
use Askvortsov\AutoModerator\Api\Serializer\AutomoderatorDriversSerializer;
use Askvortsov\AutoModerator\Metric\MetricManager;
use Flarum\Api\Controller\AbstractShowController;
use Flarum\Http\RequestUtil;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ShowAutomoderatorDriversController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = AutomoderatorDriversSerializer::class;

    /**
     * @var ActionManager
     */
    protected $actions;

    /**
     * @var MetricManager
     */
    protected $metrics;

    public function __construct(ActionManager $actions, MetricManager $metrics)
    {
        $this->actions = $actions;
        $this->metrics = $metrics;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        RequestUtil::getActor($request)->assertAdmin();

        return [
            'actionDrivers'           => $this->actions->getDrivers(),
            'actionDriversMissingExt' => $this->actions->getDrivers(true),
            'metricDrivers'           => $this->metrics->getDrivers(),
            'metricDriversMissingExt' => $this->metrics->getDrivers(true),
        ];
    }
}