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
        $activity = $duty->getActivity();
        $hostname = $activity->getVendor()->getHostname();

        $array = [
            'id' => $duty->getId(),
            'name' => $activity->getName(),
            'color' => $activity->getColor(),
            'closing' => $activity->isClosing(),
            'commenting' => $activity->isCommenting(),
            'postponing' => $activity->isPostponing(),
            'comment' => $duty->getComment(),
            'validation_url' => null,
            'iframe' => null,
            'description' => $duty->getDescription()
        ];

        if ($duty->getValidationUrl()) {
            $array['validation_url'] = $hostname . $duty->getValidationUrl();
        }

        $iframe = $hostname . $duty->getIframeUrl();

        if (strpos($iframe, '?') > -1) {
            $iframe .= '&_id=' . $duty->getId() . '&_activity=' . $activity->getCode();
        } else {
            $iframe .= '?_id=' . $duty->getId() . '&_activity=' . $activity->getCode();
        }

        if ($activity->getKey()) {
            $iframe .= '&_key=' . (string) $activity->getKey();
        }

        $array['iframe'] = $iframe;

        return $array;
    }
}
