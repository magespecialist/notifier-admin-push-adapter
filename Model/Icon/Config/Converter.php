<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierAdminPushAdapter\Model\Icon\Config;

use Magento\Framework\Config\ConverterInterface;

class Converter implements ConverterInterface
{
    /**
     * @inheritdoc
     */
    public function convert($source)
    {
        $result = [];

        /** @var \DOMNode $templateNode */
        foreach ($source->getElementsByTagName('icon') as $templateNode) {
            if ($templateNode->nodeType != XML_ELEMENT_NODE) {
                continue;
            }

            $id = $templateNode->attributes->getNamedItem('id')->nodeValue;
            $label = $templateNode->attributes->getNamedItem('label')->nodeValue;
            $icon = $templateNode->attributes->getNamedItem('icon')->nodeValue;

            $result[$id] = [
                'label' => $label,
                'file' => $icon,
            ];
        }

        return $result;
    }
}
