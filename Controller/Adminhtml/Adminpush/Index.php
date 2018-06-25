<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Controller\Adminhtml\Adminpush;

use Igorw\EventSource\Stream;
use Magento\Backend\App\Action;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\HTTP\PhpEnvironment\Response;
use Magento\Framework\Serialize\Serializer\Json;
use MSP\NotifierAdminPushAdapter\Model\AdminPush\ShiftNextMessage;
use MSP\NotifierAdminPushAdapterApi\Api\Data\AdminPushInterface;
use MSP\NotifierAdminPushAdapterApi\Api\IconRepositoryInterface;
use MSP\Notifier\Model\SerializerInterface;
use Magento\Framework\View\Asset\Repository as AssetRepo;

class Index extends Action
{
    const RETRY_INTERVAL_MS = 10000;

    /**
     * @var ShiftNextMessage
     */
    private $shiftNextMessage;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var AssetRepo
     */
    private $assetRepo;

    /**
     * @var IconRepositoryInterface
     */
    private $iconRepository;

    /**
     * @var Json
     */
    private $json;

    /**
     * Index constructor.
     * @param Action\Context $context
     * @param ShiftNextMessage $shiftNextMessage
     * @param SerializerInterface $serializer
     * @param Json $json
     * @param IconRepositoryInterface $iconRepository
     * @param AssetRepo $assetRepo
     */
    public function __construct(
        Action\Context $context,
        ShiftNextMessage $shiftNextMessage,
        SerializerInterface $serializer,
        Json $json,
        IconRepositoryInterface $iconRepository,
        AssetRepo $assetRepo
    ) {
        parent::__construct($context);
        $this->shiftNextMessage = $shiftNextMessage;
        $this->serializer = $serializer;
        $this->assetRepo = $assetRepo;
        $this->iconRepository = $iconRepository;
        $this->json = $json;
    }

    /**
     * Apply EventSource headers
     * @param Response $response
     */
    private function setEventSourceHeaders(Response $response)
    {
        $response->setHeader('Content-Type', 'text/event-stream');
        $response->setHeader('Transfer-Encoding', 'identity');
        $response->setHeader('Cache-Control', 'nocache');
        $response->setHeader('Connection', 'close');
    }

    /**
     * Stream event
     * @param Stream $stream
     * @param AdminPushInterface $adminPush
     * @throws \InvalidArgumentException
     */
    private function streamEvent(Stream $stream, AdminPushInterface $adminPush)
    {
        $config = $this->serializer->unserialize($adminPush->getParamsJson());

        try {
            $icon = $this->iconRepository->get($config['icon']);
            $iconUrl = $this->assetRepo->getUrlWithParams($icon, [
                '_secure' => $this->getRequest()->isSecure()
            ]);
            $iconLevel = 'level';
        } catch (NoSuchEntityException $e) {
            $iconUrl = null;
            $iconLevel = '';
        }

        if (!trim($adminPush->getMessage())) {
            return;
        }

        $lines = explode("\n", $adminPush->getMessage());

        $stream->event()
            ->setId($adminPush->getId())
            ->setRetry(self::RETRY_INTERVAL_MS)
            ->setData($this->json->serialize([
                'title' => $lines[0],
                'message' => $adminPush->getMessage(),
                'level' => $iconLevel,
                'mode' => $config['mode'],
                'dismiss' => (int) $config['timeout'],
                'icon' => $iconUrl
            ]))
            ->end();
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var Response $response */
        $response = $this->getResponse();
        $this->setEventSourceHeaders($response);
        $response->sendHeaders();

        // @codingStandardsIgnoreStart
        $stream = new Stream();
        // @codingStandardsIgnoreEnd

        // EventSource implementation with long wait
        while (true) {
            $adminPush = $this->shiftNextMessage->execute();
            if ($adminPush === null) {
                break;
            }

            $this->streamEvent($stream, $adminPush);
        }

        $stream->event()
            ->setRetry(self::RETRY_INTERVAL_MS)
            ->end();

        $stream->flush();
    }
}
