<?php

namespace Perfumerlabs\Start\Service;

use App\Model\User;
use Perfumerlabs\Start\Model\Duty;

class DutyFormatter
{
    /**
     * @param Duty $duty
     * @param User $user
     * @return array
     */
    public function format(Duty $duty, User $user)
    {
        $hostname = $duty->getActivity()->getVendor()->getHostname();

        $array = [
            'id' => $duty->getId(),
            'name' => $duty->getActivity()->getName(),
            'color' => $duty->getActivity()->getColor(),
            'readonly' => $duty->getActivity()->isReadonly(),
            'writable' => $duty->getActivity()->isWritable(),
            'postponable' => $duty->getActivity()->isPostponable(),
            'comment' => $duty->getComment(),
            'validation_url' => null,
            'iframe' => null,
            'description' => $duty->getDescription()
        ];

        if ($duty->getValidationUrl()) {
            $array['validation_url'] = $hostname . $duty->getValidationUrl();
        }

        $iframe = $hostname . $duty->getIframeUrl() . '?_id=' . $duty->getId() . '&_activity=' . $duty->getActivity()->getCode();

        if (strpos($iframe, '?') > -1) {
            $iframe .= '&_id=' . $duty->getId() . '&_activity=' . $duty->getActivity()->getCode();
        } else {
            $iframe .= '?_id=' . $duty->getId() . '&_activity=' . $duty->getActivity()->getCode();
        }

        $array['iframe'] = $iframe;

        return $array;
    }
}
