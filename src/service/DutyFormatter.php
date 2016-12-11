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
        $activity_properties = $duty->getActivity()->getProperties() ? unserialize($duty->getActivity()->getProperties()) : [];

        $array = [
            'id' => $duty->getId(),
            'name' => $user->getUsername(),
            'title' => $duty->getTitle(),
            'color' => isset($activity_properties['color']) ? $activity_properties['color'] : '',
            'readonly' => $duty->getActivity()->isReadonly(),
        ];

        if ($duty->getActivity()->getIframe()) {
            $data = $duty->getData() ? unserialize($duty->getData()) : [];
            $data['_id'] = $duty->getId();
            $data['_activity'] = $duty->getActivity()->getName();

            $array['iframe'] = $duty->getActivity()->getIframe() . '?' . http_build_query($data);
        }

        return $array;
    }
}