<?php

namespace Perfumerlabs\Start\Controller\Api;

use Perfumerlabs\Start\Model\VendorQuery;

class VendorsController extends LayoutController
{
    public function get()
    {
        $vendors = VendorQuery::create()
            ->orderByName()
            ->find();

        $content = [];

        foreach ($vendors as $vendor) {
            $content[] = [
                'id' => $vendor->getId(),
                'name' => $vendor->getName(),
                'hostname' => $vendor->getHostname(),
            ];
        }

        $this->setContent($content);
    }
}
